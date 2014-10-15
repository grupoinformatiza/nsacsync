<?php

require 'funcoes_samba_tool.php';

$usuarios = listarUsuarios();


$auxGrupo = "";


foreach($usuarios as $key => $usu){
    
    echo $usu['grupo']."<br />";
    
}


