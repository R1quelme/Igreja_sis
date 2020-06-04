<?php
require_once '../conexoes/conexao.php';
require_once '../conexoes/funcoes.php';

$descricao = $_POST['descricao'];

$q = "INSERT 
        INTO
        `igreja_sib`.`tipo_solicitacao`
            (`descricao`)
        VALUES
            ('$descricao');
";

$res = mysqli_query($conexao, $q);
$message = [];
if(!$res){
    $message['status'] = 'ERRO ao cadastrar, favor tente novamente:'.mysqli_error($conexao);
    echo json_encode($message);
} else{
    $message['status'] = "sucesso";
    echo json_encode($message);
}