<?php
/*
 * Nesta página já saberei o que fazer:
 * Criar grupo,
 * Criar Usuario,
 * Atualizar usuario
 * Trocar de grupo
 * Deletar usuario
 */
//Grupos de acordo com a coluna tipo da tabela usuarios do NSac
$grupos = array(
    0 => "alunos",
    1 => "professores",
    3 => "secretaria"    
);


//Processamento da requisição para listagem dos usuários no banco do nsac.
//Lista os usuarios e retorna um html para a coluna da esquerda.
if(isset($_POST['type']) && $_POST['type'] == 'carregarBancoDados'){
    $cn = pg_connect("host=200.145.153.172 port=5432 dbname=ns-data user=ns password=ns-cti") or die("Erro na conexao com o banco!");
    //buscando todos os usuarios cadastrados no NSac.
    $sqlUsuarios = "SELECT nomedeusuario,senha,tema,tipo,level FROM web.usuarios ORDER BY tipo";
    $stUsuarios  = pg_query($cn,$sqlUsuarios);

    $auxGrp = '';
    $html   = "";
    while($u = pg_fetch_object($stUsuarios)){
        //Cabeçalho do grupo na tela
        $ret['dados'][] = array("grupo" => $grupos[$u->tipo],"usuario"=>$u->nomedeusuario);
    }
    die(json_encode($ret));
}



