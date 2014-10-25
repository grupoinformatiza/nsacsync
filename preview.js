$(document).ready(function(){
    carregarBancoDados();
});

function montaLinhaAcao(id){
    var html = '<tr id="acao_'+id+'">'
                + '<td>&nbsp;</td>'
                + '</tr>';
    return html;
}
function montaLinhaSamba(id){
    var html = '<tr id="samba_'+id+'">'
                + '<td>&nbsp;</td>'
                + '<td>&nbsp;</td>'
                + '</tr>';
    return html;
}
function log(str,cl){
    $('#log').append('<span class="text-'+cl+'">'+str+'</span><br />');
}
/**
 * busca os dados do banco de dados do nSac e coloca na  tabela do lado esquerdo
 * @returns {undefined}
 */
function carregarBancoDados(){
    log('Carregando dados do NSac...','primary');
    $.post(
        'processa.php',
        {type:'carregarBancoDados'},
        function(ret){
            if(ret.status){
                var linha = '';
                var auxGrp = '';
                var u = '';
                for(var x = 0; x < ret.dados.length; x ++){
                    u = ret.dados[x];
                    
                    if(auxGrp != u.grupo){ //cabeçalho dos grupos
                        linha = '<tr id="nsac_'+u.grupo+'" class="grupo" data-desc="'+u.grupo+'">'
                                + '<td colspan="2" class="principal">'+u.grupo+'</td>'
                                + '</tr>';
                        $(linha).appendTo('#tblNsac'); //linha do grupo
                        $(montaLinhaAcao(u.grupo)).appendTo('.acao'); //acao para o grupo
                        $(montaLinhaSamba(u.grupo)).appendTo('#tblSamba'); //linha do grupo no samba
                        auxGrp = u.grupo;
                    }
                    
                    linha = '<tr id="nsac_'+u.usuario+'">'
                            + '<td>'+u.usuario+'</td>'
                            + '<td></td>'
                            + '</tr>';
                    $(linha).appendTo('#tblNsac');
                    $(montaLinhaAcao(u.usuario)).appendTo('.acao');
                    $(montaLinhaSamba(u.usuario)).appendTo('#tblSamba');
                }
                log('Dados do Nsac carregados com êxito.','success');
                iniciarGrupos();
            }else{
                log(ret.erro,'danger');
            }
            
        },
        'json'
    );
}

function iniciarGrupos(){
    
    log("Iniciando busca dos grupos...","primary");
    var desc = '';
    
    $('.grupo').each(function(){
        desc = $(this).data('desc');
        log("Verificando se o grupo "+desc+" existe no Samba...","primary");
        
        $.post(
            'processa.php',
            {type:'buscarGrupo',desc:desc},
            function(ret){
                if(ret){
                    log("Grupo "+desc+" existe, listando usuários...","info");
                }
            },
            'json'
        );
        
    });
}