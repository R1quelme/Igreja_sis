<?php
require_once 'conexoes/login.php';
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <title>Controle de Cadastros</title>
</head>

<body>
    <style>
        body {
            margin: 0;
            font-family: Helvetica;
            font-size: 0.85rem;
            font-weight: 400;
            line-height: 1.42857143;
            color: #212529;
            text-align: left;
            background-color: #fff;
        }
    </style>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="">Sistema SIB</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- onclick="colapsarobotao()" -->

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item" style="color: white">
                        <?php
                        if (is_logado()) {
                            echo "<a href='index.php' style='text-decoration: none; margin-top: 10px;color: #fff !important;'> | Solicitações</a>";
                        }
                        ?>
                    </li>
                    &nbsp;&nbsp;
                    <li class="nav-item" style="color: white">
                        <?php
                        if (is_admin()) {
                            echo "<a href='cadastros.php' style='text-decoration: none; margin-top: 10px;color: #fff !important;'>| Cadastros</a>";
                        }
                        ?>
                    </li>
                    &nbsp;&nbsp;
                    <li class="nav-item" style="color: white">
                        <?php
                        if (is_admin()) {
                            echo "<a href='tipo_solicitacao.php' style='text-decoration: none; margin-top: 10px;color: #fff !important;'>| Tipo de solicitação</a>";
                        }
                        ?>
                    </li>
                </ul><br>
                <div align="right" style="color: white">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item" style="color: white">
                            <?php
                            if (empty($_SESSION['user_igreja'])) {
                                echo "<a class='nav-link' href='index.php'></a>";
                            } else {
                                echo "Ola, <strong>" . $_SESSION['nome_igreja'] . "</strong> | ";
                                echo "<a href='user-edit.php' style= 'text-decoration: none; margin-top: 10px;color: #fff !important;'> Meus dados | </a>";
                                echo "<a href='user-logout.php' style='margin-top: 10px;color: #fff !important;'>Sair</a>";
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- PAra fazer a mascar esses dois links -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
</body>

<!-- <script>
function colapsarobotao(){
$('#navbarSupportedContent').collapse('toggle')
}
</script> -->