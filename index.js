var btnRemover = '<button type="button" class="btn btn-sm btn-danger btn-remover" title="remover"><span class="glyphicon glyphicon-remove"></span></button>';

var linhaprm =  '<tr class="parametro-linha">'
                    +'<td><input type="text" class="form-control input-sm" /></td>'
                    +'<td><input type="text" class="form-control input-sm" /></td>'
                    +'<td><input type="checkbox" /></td>'
                    +'<td><input type="text" class="form-control input-sm" /></td>'
                    +'<td>'+btnRemover+'</td>'
                +'</tr>';

$(document).ready(function(){
    $('.btn-add').click(adicionarLinha);
    $('.btn-salvar').click(salvarConfiguracoes);
    buscarConfiguracoes();
});

function buscarConfiguracoes(){
    $.post(
        'processa.php',
        {type:'buscarConfiguracoes'},
        function(ret){
            if(!ret){
                alert('Nenhuma parametrização foi criada ainda...');
            }else{
                var linha = '';
                for(var x = 0; x < ret.length; x ++){
                    linha = $(linhaprm).appendTo('#tbl-parametros');
                    linha.find('td').eq(0).find('input').val(ret[x].codigo);
                    linha.find('td').eq(1).find('input').val(ret[x].nome);
                    linha.find('td').eq(2).find('input').prop('checked',ret[x].share);
                    linha.find('td').eq(3).find('input').val(ret[x].quota);
                }
                $('.btn-remover').click(removerLinha);
            }
        },
        'json'
    );
}
function salvarConfiguracoes(){
    //Montando dados
    var dados = {};
    
    dados['type'] = 'salvarConfiguracoes';
    var countOu = 0;
    $('.parametro-linha').each(function(){ //percorrendo todas as linhas de parametrização
        dados['ou['+countOu+'][codigo]'] = $(this).find('td').eq(0).find('input').val();
        dados['ou['+countOu+'][nome]'] = $(this).find('td').eq(1).find('input').val();
        dados['ou['+countOu+'][share]'] = $(this).find('td').eq(2).find('input').prop('checked');
        dados['ou['+countOu+'][quota]'] = $(this).find('td').eq(3).find('input').val();
        countOu++;
    });
    
    
    $.post(
        'processa.php',
        dados,
        function(ret){
            if(ret.status){
                alert('parâmetros armazenados com sucesso (parametros.txt)');
            }else{
                alert('Erro gravando parâmetros, pode ser permissão de escrita no diretório.');
            }
        },
        'json'
    );
    
}

function removerLinha(e){
    $(e.target).parents('tr').remove();
}

function adicionarLinha(){
    $('#tbl-parametros').append(linhaprm);
    $('.btn-remover').click(removerLinha);
}
