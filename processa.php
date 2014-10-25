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
    $cn = pg_connect("host=200.145.153.172 port=5432 dbname=ns-data user=ns password=ns-cti");
    if(!$cn)
        return false;
    return true;
}

//Grupos de acordo com a coluna tipo da tabela usuarios do NSac
$grupos = array(
    0 => "alunos",
    1 => "professores",
    3 => "secretaria"    
);


//Processamento da requisição para listagem dos usuários no banco do nsac.
//Lista os usuarios e retorna um html para a coluna da esquerda.
if(isset($_POST['type']) && $_POST['type'] == 'carregarBancoDados'){
    $cn = getConexao('200.145.153.172', '5432', 'ns-data', 'ns', 'ns-cti');
    if(!$cn){
        $ret['status'] = false;
        $ret['erro']   = utf8_encode("Erro na conexão com o banco de dados");
        die(json_encode($ret));
    }
    $ret['status'] = true;
    //buscando todos os usuarios cadastrados no NSac.
    $sqlUsuarios = ""
            . "SELECT nomedeusuario,senha,tema,tipo,level,t.nomenclatura As subgrupo "
            . "FROM web.usuarios user "
            . "LEFT JOIN alunos.matriculas mat ON (user.nomedeusuario = mat.aluno) "
            . "LEFT JOIN public.turmas t ON (mat.turma = t.codigo) "
            . "ORDER BY tipo,subgrupo";
    $stUsuarios  = pg_query($cn,$sqlUsuarios);

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
    
    $cn = pg_connect("host=200.145.153.172 port=5432 dbname=ns-data user=ns password=ns-cti") or die("Erro na conexao com o banco!");
    
    
    for($x = 666; $x < 1000; $x ++){
        
        $matricula = str_pad($x, 7, '0', STR_PAD_LEFT);
        
        $sqlDados = "INSERT INTO alunos.matriculas(turma,situacao,aluno) VALUES (1,0,'$matricula')";
        pg_query($cn,$sqlDados);
        
        $sqlUsuario = "INSERT INTO web.usuarios(nomedeusuario,senha,tipo,level) VALUES ('$matricula','senha',0,0)";
        pg_query($cn,$sqlUsuario);
        
    }
    
    
}
