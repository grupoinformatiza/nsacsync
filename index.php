<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Sincronização NSac > SAMBA</h1>
        <h4>Insira os dados do banco de dados</h4>
        <form method="post" action="preview.php">
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
            <input type="submit" value="Pré Visualização" />
        </form>
    </body>
</html>
