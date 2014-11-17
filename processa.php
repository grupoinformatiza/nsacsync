<?php
ini_set('display_errors',0);
/*
 * Nesta página já saberei o que fazer:
 * Criar grupo,
 * Criar Usuario,
 * Atualizar usuario
 * Trocar de grupo
 * Deletar usuario
 */

function getConexao($host,$port,$db,$user,$pass){
    $cn = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass");
    if(!$cn)
        return false;
    return $cn;
}

//Grupos de acordo com a coluna tipo da tabela usuarios do NSac
$grupos = array(
    0 => "Aluno",
    1 => "Professores",
    3 => "Secretaria"    
);


if(isset($_POST['type']) && $_POST['type'] == 'buscarUsuario'){
    
    $usuario = $_POST['user'];
    $ou = $_POST['ou'];
    $grupo = $_POST['grupo'];
    
    //Criando usuario em sua respectiva OU
    $excUser = shell_exec("sudo samba-tool user add $usuario 123 --userou=OU=$ou --must-change-at-next-login 2>&1");
    //Adicionando usuario no grupo de sua OU
    $excGrpOu = shell_exec("sudo samba-tool group addmembers $ou $usuario 2>&1");
    
    if(trim($grupo) != '')
        //Movendo usuario para seu respectivo grupo
        $excGrp  = shell_exec("sudo samba-tool group addmembers $grupo $usuario 2>&1");
    
    $status = true;
    $msg    = '';
    //testando retorno da criação de usuario
    if(strpos($excUser,'created successfully')){
        $msg .= "usuário $usuario criado com sucesso na OU $ou.";
        
        $nomeUsuario = "CN=$usuario,OU=$ou";
        
        $exc  = shell_exec("sudo cp /home/arquivos-samba/cloudQuota/usercloudQuota.ldif /home/arquivos-samba/cloudQuota/{$usuario}cloudQuota.ldif 2>&1");
        $exc .= shell_exec("sudo sed -i 's/CN_USUARIO/$nomeUsuario/g' /home/arquivos-samba/cloudQuota/{$usuario}cloudQuota.ldif 2>&1");
        $exc .= shell_exec("sudo sed -i 's/QUOTA_USUARIO/60 m/g' /home/arquivos-samba/cloudQuota/{$usuario}cloudQuota.ldif 2>&1");
        $exc .= shell_exec("sudo ldbmodify -H /usr/local/samba/private/sam.ldb /home/arquivos-samba/cloudQuota/{$usuario}cloudQuota.ldif 2>&1");
    }else{
        $msg .= "usuário existe.";
    }
    
    //testando retorno do grupo da ou
    if(strpos($excGrpOu,'Added') !== false){
        $msg .= " Movido para o grupo de sua OU ($ou).";
    }else{
        $status = false;
        $msg .= " Erro movendo para o grupo de sua OU ($ou). Detalhes: $excGrpOu";
    }
    
    if(trim($grupo) != ''){
        //testando retorno do grupo
        if(strpos($excGrp, "Added") !== false){
            $msg .= " Movido para o grupo $grupo";
        }else{
            $status = false;
            $msg .= " Problema movendo para o grupo $grupo. Detalhes: ".$excGrp;
        }
    }
    
    $ret['status'] = $status;
    $ret['msg'] = $msg;
    
    die(json_encode($ret));
}

function criarShare($grp,&$ret){
    //Tentando criar pasta compartilhada
    $pasta = shell_exec("sudo mkdir $grp /home/shares/ 2>&1");

    if(strpos($pasta, 'File exists') !== false){ //arquivo existe
        $ret['msg'] .= ' | Pasta compartilhada já existe.';
    }else{
        $ret['msg'] .= " | Pasta compartilhada foi criada.";

        //verificando arquivo smb.conf
        $smb = shell_exec("sudo grep '$grp' /usr/local/samba/etc/smb.conf 2>&1");

        if(strpos($smb,"[$grp]") !== false){
            $ret['msg'] .= " | Grupo já está no smb.conf";
        }else{
            //Criar grupo no smb.conf

            $criar = shell_exec("sudo echo -e \"\n[$grp]\n\tpath = /home/shares/$grp\n\tread only = Yes\" 2>&1");
            $atualizar = shell_exec("sudo smbclient all reload-config 2>&1");

            die($criar . ' - ' . $atualizar);
        }
    }
}

if(isset($_POST['type']) && $_POST['type'] == 'buscarGrupo'){
    
    $grp = $_POST['grp'];
    $ou  = $_POST['ou'];
    
    $exc = shell_exec("sudo samba-tool group add $grp --groupou=OU=$ou 2>&1");
    if(strpos($exc,'already')){    
        $ret['status'] = true;
        $ret['msg']    = 'Grupo existe';
    }elseif(strpos($exc,'failed')){
        $ret['status'] = false;
        $ret['msg']    = 'Grupo não existe, ocorreu uma falha na criação. Detalhes: '.$exc;
    }else{
        $ret['status'] = true;
        $ret['msg']    = 'grupo não existia e foi criado.';
    }
    
    if($ret['status']){
        criarShare($grp,$ret);
        
    }
    /* 
            se a OU não existir no smb.conf:
            root@cloud:/home/arquivos-samba# echo -e "\n[[NOME_OU]|[NOME_GRUPO]]\n\tpath = /home/shares/[NOME_OU]|[NOME_GRUPO]\n\tread only = Yes"

            Atualiza o samba:
            root@cloud:/home/arquivos-samba# smbclient all reload-config
         */
    
    die(json_encode($ret));
}

if(isset($_POST['type']) && $_POST['type'] == 'buscarOU'){
    
    $ou = $_POST['ou'];
    
    //clonando arquivo
    $exc = shell_exec("sudo cp -f /home/arquivos-samba/ou.ldif /home/arquivos-samba/{$ou}OU.ldif 2>&1");
    //substituindo
    $exc .= shell_exec("sudo sed -i 's/OU_NOME/$ou/g' /home/arquivos-samba/{$ou}OU.ldif 2>&1");
    //executando
    $exc .= shell_exec("sudo ldbadd -H /usr/local/samba/private/sam.ldb /home/arquivos-samba/{$ou}OU.ldif 2>&1");
    
    //criando grupo da OU na OU
    $exc .= shell_exec("sudo samba-tool group add $ou --groupou=OU=$ou 2>&1");
    
    //die($exc);
    
    //$exc = shell_exec("ldbadd -H /usr/local/samba/private/sam.ldb /home/arquivos-samba/TesteOU.ldif");
    if(strpos($exc, 'already')){
        $ret['status'] = true;
        $ret['msg']    = 'OU Existe';
    }else if(!strpos($exc, 'failed') && !strpos($exc,'Permission denied') && !strpos($exc,'Sorry, try again') && trim($exc) != ''){ //se for false, criou
        $ret['status'] = true;
        $ret['msg'] = "OU Não existe, e foi criada";
    }else{ //nao criou
        $ret['status'] = false;
        $ret['msg'] = "OU Não existe e ocorreu erro na criação. Detalhes :".$exc;
    }
    if($ret['status']){
        criarShare($ou,$ret);
    }
    die(json_encode($ret));
    
}
if(isset($_POST['type']) && $_POST['type'] == 'buscarOU'){
    $ou = $_POST['ou'];
    //Executando comando shell para buscar a OU
    $ex = shell_exec("ldbsearch -H /usr/local/samba/private/sam.ldb '(OU=*$ou)' 2>&1");
    $str = strpos($ex, '0 entries');
    
    
    if($str != false){ //encontrou, OU não existe
        $ret['existe'] = false;
    }else{
        $ret['existe'] = true;
    }
    
    die(json_encode($ret));    
}
//Processamento da requisição para listagem dos usuários no banco do nsac.
//Lista os usuarios e retorna um html para a coluna da esquerda.
if(isset($_POST['type']) && $_POST['type'] == 'carregarBancoDados'){
    $cn = getConexao($_POST['host'], $_POST['port'], $_POST['dbname'], $_POST['user'], $_POST['pass']);
    if(!$cn){
        $ret['status'] = false;
        $ret['erro']   = "Erro na conexão com o banco de dados";
        die(json_encode($ret));
    }
    $ret['status'] = true;
    //buscando todos os usuarios cadastrados no NSac.
    $sqlUsuarios = ""
            . "SELECT nomedeusuario,senha,tema,tipo,level,t.nomenclatura As subgrupo "
            . "FROM web.usuarios usu "
            . "LEFT JOIN alunos.matriculas mat ON (usu.nomedeusuario = mat.aluno) "
            . "LEFT JOIN public.turmas t ON (mat.turma = t.codigo) "
            . "WHERE usu.tipo <> 0 "
            . "ORDER BY tipo,subgrupo";
    $stUsuarios  = pg_query($cn,$sqlUsuarios);
    if(pg_num_rows($stUsuarios) == 0){
        $ret['status'] = false;
        $ret['erro'] = 'Nenhum usuário encontrado.';
    }
    $auxGrp = '';
    $html   = "";
    while($u = pg_fetch_object($stUsuarios)){
        //Cabeçalho do grupo na tela
        $ret['dados'][] = array("grupo" => $grupos[$u->tipo],"usuario"=>$u->nomedeusuario,"subgrupo"=>$u->subgrupo);
    }
    die(json_encode($ret));
}

if(isset($_POST['type']) && $_POST['type'] == 'buscarGrupo'){
    
    require_once 'funcoes_samba_tool.php';
    
    die('oi');
    
}



if(isset($_GET['acao']) && $_GET['acao'] == 'criaralunos'){
    
    $cn = pg_connect("host={$_GET['host']} port={$_GET['port']} dbname={$_GET['dbname']} user={$_GET['user']} password={$_GET['pass']}") or die("Erro na conexao com o banco!");
    
    
    for($x = 1; $x < 333; $x ++){
        
        $matricula = str_pad($x, 7, '0', STR_PAD_LEFT);
        
        $sqlDados = "INSERT INTO alunos.matriculas(turma,situacao,aluno) VALUES (1,0,'$matricula')";
        pg_query($cn,$sqlDados);
        
        $sqlUsuario = "INSERT INTO web.usuarios(nomedeusuario,senha,tipo,level) VALUES ('$matricula','senha',0,0)";
        pg_query($cn,$sqlUsuario);
        
    }
    
    
}
