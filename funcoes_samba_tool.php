<?php

/** FUNÇÕES DE MANIPULAÇÃO DO SAMBA **/
function setPassword($usuario,$password){
    
}

function listarUsuarios(){
    $ret = executarComando("group list"); //retorna string com todos grupos separados por \n
    $grupos = explode("\n",$ret);
    
    foreach($grupos as $grupo){
        
        $ret = executarComando("group listmembers <$grupo>"); //retorna quem está neste grupo
        
        $membros = explode("\n",$ret);
       
        foreach($membros as $membro){
            
            $retorno[] = array(
                "grupo" => $grupo,
                "nome"  => $membro
            );
            
        }
        
        
    }   
    return $retorno;
}

function interpretaRetorno($retorno){
    
    return array(
        
        "sts" => true,
        "msg" => $retorno
        
    );
}
function executarComando($comando){
    $tool  = "/usr/local/samba/bin/samba-tool "; //caminho do samba-tool
    $erro  = "2>&1"; //exibe as mensagens de retorno
    
    $retorno = shell_exec($tool." ".$comando." ".$erro);
    
    return $retorno;
}


function criarUsuario($usuario,$password,$ou){
    global $tool;
    
    $r = executarComando("user add $usuario $password --userou=OU=$ou");
    $r .= executarComando("group addmembers $ou <$usuario>");
    
    return $r;
}
function deletarUsuario($usuario){
    
}
function trocarGrupo($old,$new){
    
}
/** FIM DAS FUNÇÕES DO SAMBA **/