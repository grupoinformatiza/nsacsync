<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sincronização</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="preview.css">
    </head>
    <body>
        <div class="container">
            <div class="row detalhes">
                <div class="col-lg-5">
                    <strong>Host:</strong> 200.145.153.172&nbsp;&nbsp;
                    <strong>Porta:</strong> 5432&nbsp;&nbsp;
                    <strong>BD:</strong> ns-data&nbsp;&nbsp;
                </div>
                <div class="col-lg-5 samba">
                    samba-tool local
                </div>
            </div>
            <div class="row">
                    <div class="col-lg-5">
                        <div class="page-header">
                            <h1>NSac</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="tblNsac">
                                <thead>
                                    <tr>
                                        <td>Usuário</td>
                                        <td>Subgrupo</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div><!-- /tabela -->
                    </div><!-- /coluna nsac -->

                    <div class="col-lg-2">
                        <div class="table-responsive ">
                            <table class=" table acao">
                                <thead>
                                    <tr><td>&nbsp;</td></tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                                

                            </table>
                        </div>
                    </div><!-- /coluna ações -->

                    <div class="col-lg-5">
                        <div class="page-header">
                            <h1>Samba</h1>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="tblSamba">
                                <thead>
                                    <tr>
                                        <td>Usuário</td>
                                        <td>Subgrupo</td>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div><!-- /tabela -->
                    </div><!-- /coluna samba -->
            </div><!-- /row-->                 
        </div><!-- /container -->
        <div class="footer" style="overflow-y: auto">
            <div class="container">
                <div class="row botoes">
                    <div class="col-lg-12">
                        <strong>Log</strong>
                        <div class="cont">
                            <button type="button" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-remove"></span> Parar</button>
                            <button type="button" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-lock"></span> Sincronizar senhas</button>
                            <button type="button" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-refresh"></span> Sincronizar</button>
                            <button type="button" class="btn btn-sm"><span class="glyphicon glyphicon-chevron-down"></span></button>
                        </div>
                    </div>
                </div>                    
                <div class="row">
                    <div class="col-lg-12">
                        
                        <div id="log"></div>
                    </div>
                </div>
            </div>

        </div>
    </body>
    
    <script type="text/javascript" src="jquery.js" ></script>
    <script type="text/javascript" src="preview.js" ></script>
    
</html>
