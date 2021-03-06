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
                    <input type="hidden" name="hdHost" id="hdHost" value="<?php echo $_POST['host'] ?>" />
                    <input type="hidden" name="hdPorta" id="hdPorta" value="<?php echo $_POST['port'] ?>" />
                    <input type="hidden" name="hdBanco" id="hdBanco" value="<?php echo $_POST['dbname'] ?>" />
                    <input type="hidden" name="hdUsuario" id="hdUsuario" value="<?php echo $_POST['user'] ?>" />
                    <input type="hidden" name="hdSenha" id="hdSenha" value="<?php echo $_POST['pass'] ?>" />
                    <strong>Host:</strong> <?php echo $_POST['host'] ?>&nbsp;&nbsp;
                    <strong>Porta:</strong> <?php echo $_POST['port'] ?>&nbsp;&nbsp;
                    <strong>BD:</strong> <?php echo $_POST['dbname'] ?>&nbsp;&nbsp;
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
        <div class="footer">
            <div class="container">
                <div class="row botoes">
                    <div class="col-lg-3">
                        <strong>Log</strong>
                    </div>
                    <div class="col-lg-2">
                        <span class=text-muted">Progresso Usuários</span>
                    </div>
                    <div class="col-lg-3">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cont">
                            
                            <!--<button type="button" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-remove"></span> Parar</button>
                            <button type="button" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-refresh"></span> Sincronizar</button>-->
                            <button type="button" class="btn btn-sm btnseta"><span class="glyphicon glyphicon-chevron-down"></span></button>
                        </div>
                    </div>
                </div>                    
                <div class="row">
                    <div class="col-lg-12" style="height:100px;overflow-y: auto">
                        <div id="log"></div>
                    </div>
                </div>
            </div>

        </div>
    </body>
    
    <script type="text/javascript" src="jquery.js" ></script>
    <script type="text/javascript" src="preview.js" ></script>
    
</html>
