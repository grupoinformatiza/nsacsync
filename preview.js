$(document).ready(function(){
    carregarBancoDados();
    $('.btnseta').click(function(){
        $(this).find('span').toggleClass('cima');
        $('.footer').toggleClass('minimizado');
    });
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
        {type:'carregarBancoDados',
         host:$('#hdHost').val(),
         port:$('#hdPorta').val(),
         dbname:$('#hdBanco').val(),
         user:$('#hdUsuario').val(),
         pass:$('#hdSenha').val()
        },
        function(ret){
            if(ret.status){
                var linha = '';
                var auxGrp = '';
                var auxSub = '';
                var u = '';
                for(var x = 0; x < ret.dados.length; x ++){
                    u = ret.dados[x];
                    
                    if(auxGrp != u.grupo){ //cabeçalho dos grupos
                        linha = '<tr id="nsac_'+u.grupo+'" class="grupo" data-desc="'+u.grupo+'" data-tipo="ou" data-share="'+u.share+'" data-quota="'+u.quota+'">'
                                + '<td colspan="2" class="principal">'+u.grupo+'</td>'
                                + '</tr>';
                        $(linha).appendTo('#tblNsac'); //linha do grupo
                        $(montaLinhaAcao(u.grupo)).appendTo('.acao'); //acao para o grupo
                        $(montaLinhaSamba(u.grupo)).appendTo('#tblSamba'); //linha do grupo no samba
                        auxGrp = u.grupo;
                    }
                    
                    if(auxSub != u.subgrupo && u.subgrupo != null){
                        linha = '<tr id="nsac_'+u.subgrupo+'" class="subgrupo" data-ou="'+u.grupo+'" data-desc="'+u.subgrupo+'" data-tipo="grupo" data-share="'+u.share+'" data-quota="'+u.quota+'">'
                                + '<td colspan="2" class="principal">'+u.subgrupo+'</td>'
                                + '</tr>';
                        $(linha).appendTo('#tblNsac'); //linha do subgrupo
                        $(montaLinhaAcao(u.subgrupo)).appendTo('.acao'); //acao para o subgrupo
                        $(montaLinhaSamba(u.subgrupo)).appendTo('#tblSamba'); //linha do subgrupo no samba
                        auxSub = u.subgrupo;
                    }
                    
                    linha = '<tr id="nsac_'+u.usuario+'" data-tipo="user" data-ou="'+u.grupo+'" data-grupo="'+u.subgrupo+'" data-desc="'+u.usuario+'" data-share="'+u.share+'" data-quota="'+u.quota+'">'
                            + '<td>'+u.usuario+'</td>'
                            + '<td></td>'
                            + '</tr>';
                    $(linha).appendTo('#tblNsac');
                    $(montaLinhaAcao(u.usuario)).appendTo('.acao');
                    $(montaLinhaSamba(u.usuario)).appendTo('#tblSamba');
                }
                log('Dados do Nsac carregados com êxito.','success');
                iniciarOU();
            }else{
                log(ret.erro,'danger');
            }
            
        },
        'json'
    );
}

var qtdUsuarios = 0;
var countUsuario = 0;
function iniciarUsuarios(){
    var quantidade = $('[data-tipo=user]').length;
    qtdUsuarios = quantidade;
    countUsuario = 0;
    if(quantidade > 0){
        log("Iniciando usuários","primary");
        buscarUsuario(0);
    }
}

function iniciarGrupos(){
    var quantidade = $('[data-tipo=grupo]').length;
    if(quantidade > 0){
        log("Iniciando grupos","primary");
        buscarGrupo(0);
    }else{
        iniciarUsuarios();
    }
}

function iniciarOU(){
    var quantidade = $('[data-tipo=ou]').length; //Quantas OUs temos na lista
    if(quantidade > 0){
        log("Iniciando OUs...","primary");
        buscarOU(0);
    }
}

//busca e cria se não existir. Depois, chama a proxima OU da fila.
function buscarOU(indice){
    var desc = $('[data-tipo=ou]').eq(indice).data('desc');
    var quota = $('[data-tipo=ou]').eq(indice).data('share');
    var share = $('[data-tipo=ou]').eq(indice).data('quota');
    if($('[data-tipo=ou]').eq(indice).length != 0){
        log('Buscando OU '+desc,"primary");
        $.post(
            'processa.php',
            {
                type: 'buscarOU',
                ou: desc,
                share: share,
                quota:quota
            },
            function(ret){
                if(!ret.status){
                    log(ret.msg,'danger');
                    $('#acao_'+desc).find('td').addClass('text-danger').html('Erro');
                    $('#samba_'+desc).addClass('danger').find('td').eq(0).html(desc);
                    //criarOU(indice);
                }else{
                    log(ret.msg,'success');
                    $('#acao_'+desc).find('td').addClass('text-success').html('OK');
                    $('#samba_'+desc).addClass('success text-success').find('td').eq(0).html(desc);
                }
                buscarOU(indice + 1);
            },
            'json'
        );
    }else{
        log('Todas as OUs foram percorridas','primary');
        iniciarGrupos();
    }
}
function atualizaProgresso(){
    var cem = qtdUsuarios;
    var qtd = countUsuario;
   
    var pct = (100 * qtd) / cem;
    pct = Math.ceil(pct);
    $('.progress-bar').css('width',''+pct+'%').text(pct+' %');
}
function buscarUsuario(indice){
    var desc = $('[data-tipo=user]').eq(indice).data('desc');
    $('#acao_'+desc).find('td').addClass('text-info').html('Processando...');
    var quota = $('[data-tipo=user]').eq(indice).data('share');
    var share = $('[data-tipo=user]').eq(indice).data('quota');
    if($('[data-tipo=user]').eq(indice).length != 0){
        
        log('Buscando usuário '+desc,"primary");
        $.post(
            'processa.php',
            {
                type: 'buscarUsuario',
                user: desc,
                ou: $('[data-tipo=user]').eq(indice).data('ou'),
                grupo: $('[data-tipo=user]').eq(indice).data('grupo'),
                quota:quota,
                share:share
            },
            function(ret){
                $('#acao_'+desc).find('td').removeClass('text-info');
                if(!ret.status){
                    log(ret.msg,'danger');
                    $('#acao_'+desc).find('td').addClass('text-danger').html('Erro');
                    $('#samba_'+desc).addClass('danger').find('td').eq(0).html(desc);
                }else{
                    log(ret.msg,'success');
                    $('#acao_'+desc).find('td').addClass('text-success').html('OK');
                    $('#samba_'+desc).addClass('success text-success').find('td').eq(0).html(desc);
                }
                countUsuario ++;
                atualizaProgresso();
                buscarUsuario(indice + 1);
            },
            'json'
        );
    }else{
        log('Todas os Usuários foram percorridos','primary');
    }
}

//busca e cria se não existir. Depois, chama o proximo OU da fila.
function buscarGrupo(indice){
    var desc = $('[data-tipo=grupo]').eq(indice).data('desc');
    var quota = $('[data-tipo=grupo]').eq(indice).data('share');
    var share = $('[data-tipo=grupo]').eq(indice).data('quota');
    if($('[data-tipo=grupo]').eq(indice).length != 0){
        log('Buscando Grupo '+desc,"primary");
        $.post(
            'processa.php',
            {
                type: 'buscarGrupo',
                grp: desc,
                ou: $('[data-tipo=grupo]').eq(indice).data('ou'),
                quota:quota,
                share:share
            },
            function(ret){
                if(!ret.status){
                    log(ret.msg,'danger');
                    $('#acao_'+desc).find('td').addClass('text-danger').html('Erro');
                    $('#samba_'+desc).addClass('danger').find('td').eq(0).html(desc);
                    //criarOU(indice);
                }else{
                    log(ret.msg,'success');
                    $('#acao_'+desc).find('td').addClass('text-success').html('OK');
                    $('#samba_'+desc).addClass('success text-success').find('td').eq(0).html(desc);
                }
                buscarGrupo(indice + 1);
            },
            'json'
        );
    }else{
        log('Todos os grupos foram percorridos','primary');
        iniciarUsuarios();
    }
}
