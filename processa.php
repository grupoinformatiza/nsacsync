<?php

$host   = $_POST['host'];
$port   = $_POST['port'];
$user   = $_POST['user'];
$pass   = $_POST['pass'];
$dbname = $_POST['dbname'];

//Grupos de acordo com a coluna tipo da tabela usuarios do NSac
$grupos = array(
    0 => "alunos",
    1 => "professores",
    3 => "secretaria"    
);


//criando conexão com o banco de dados
$cn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass") or die("Erro na conexao com o banco!");

//buscando todos os usuarios cadastrados no NSac.
$sqlUsuarios = "SELECT nomedeusuario,senha,tema,tipo,level FROM web.usuarios ORDER BY tipo";
$stUsuarios  = pg_query($cn,$sqlUsuarios);

if(!$stUsuarios)
    die("Falha buscando usuarios!");

if(pg_num_rows($stUsuarios) == 0)
    die("Nenhum usuario encontrado!");


$auxGrp = '';


while($u = pg_fetch_object($stUsuarios)){
    
        //Cabeçalho do grupo na tela
        if($u->tipo != $auxGrp){
            echo "<h1>{$grupos[$u->tipo]}</h1>";
        }
        
        
        
        echo $u->nomedeusuario . "<br />";
       
}


