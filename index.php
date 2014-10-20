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
                <div class="row">
                    <div class="col-lg-12">
                            <label>
                                Host: <input type="text" name="host" value="localhost">
                            </label>
                            <label>
                                Porta: <input type="text" name="port" value="5432">
                            </label>
                            <label>
                                BD: <input type="text" name="dbname" value="nsac">
                            </label>
                            <label>
                                Usuário: <input type="text" name="user" value="postgres">
                            </label>
                            <label>
                                Senha: <input type="text" name="pass" value="oklahoma1">
                            </label>
                    </div><!--/col -->
                </div><!--/row -->
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
