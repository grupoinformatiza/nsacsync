<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="index.css">
    </head>
    <body>
        <div class="container">
            <h1>Sincronização NSac &nbsp; <span class="glyphicon glyphicon-arrow-right"></span> &nbsp; SAMBA</h1><br>
            <h4>Insira os dados do banco de dados</h4>
            <form method="post" action="preview.php">
                <div class="jumbotron bd">
                    <div class="col-lg-12">
                        <label>
                            <h3>Host: <input type="text" name="host" value="localhost" class="form-control input-lg"></h3> 
                        </label>
                    </div>
                    <div class="col-lg-6">
                        <label>
                            <h3>Porta:  <input type="text" name="port" value="5432" class="form-control input-lg"></h3>
                        </label>
                    </div>
                    <div class="col-lg-6">
                        <label>
                            <h3>BD:  <input type="password" name="dbname" value="nsac" class="form-control input-lg"></h3>
                        </label>
                    </div>
                    <div class="col-lg-6">
                        <label>
                            <h3>Usuário: <input type="password" name="user" value="postgres" class="form-control input-lg"> </h3>
                        </label>
                    </div>
                    <div class="col-lg-6">
                        <label>
                            <h3>Senha:  <input type="password" name="pass" value="oklahoma1" class="form-control input-lg"></h3>
                        </label>
                    </div>
                </div><!-- jumbotron -->
                
                <div class="jumbotron">
                    <h3>Parâmetrização (OUs e Grupos)</h3>
                    <button type="button" class="btn btn-success btn-add" title="adicionar"><span class="glyphicon glyphicon-plus"></span></button>
                    <button type="button" class="btn btn-info btn-salvar" title="salvar"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <td class="col-sm-1">Código (Int)</td>
                                <td class="col-sm-5">Descrição (String)</td>
                                <td class="col-sm-1">Criar Share (Bit)</td>
                                <td class="col-sm-4">Quota (MB)</td>
                                <td class="col-sm-1"></td>
                            </tr>
                        </thead>
                        <tbody id="tbl-parametros">
                            
                        </tbody>
                        
                    </table>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <button class="btn btn-lg btn-primary pull-right botao" type="submit"><span class="glyphicon glyphicon-play"></span> Sincronizar</button>
                    </div>
                </div>
            </form>
            
            
        </div>
    </body>
    
    <script type="text/javascript" src="jquery.js" ></script>
    <script type="text/javascript" src="index.js" ></script>
</html>

