<!DOCTYPE html>
<?php 
require_once "conexoes/conexao.php";
require_once "conexoes/login.php";
?>


<html lang="pt-br">
    <head>
        <meta charset="UTF-8"/>
        <title> ??? </title>
    </head>
    <body>
        <div id="corpo">
            <?php 
                logout();
                header("location: user-login.php");
            ?>
        </div>
    </body>
</html>