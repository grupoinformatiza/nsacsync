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
                        <div class="jumbotron">
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
                <div class="row">
                    <div class="col-lg-12">
                        <button class="btn btn-lg btn-primary pull-right botao" type="submit"><span class="glyphicon glyphicon-eye-open"></span> Pré Visualização</button>
                    </div>
                </div>
        </form>
        </div>
    </body>
    
      <script type="text/javascript" src="jquery.js" ></script>
</html>
