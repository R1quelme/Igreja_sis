<?php 
session_start();

require_once '../conexoes/conexao.php';
require_once '../conexoes/funcoes.php';

$id_usuario = $_SESSION['id_usuario_igreja'];
$observacao = $_POST['observacao'];

$q = "INSERT 
    INTO `igreja_sib`.`solicitacoes` 
        (`id_usuario`, `id_tipo_solicitacao`, `observacao`) 
    VALUES ('$id_usuario', '1', '$observacao');
";


$res = mysqli_query($conexao, $q);
$message = []; 
if(!$res){
    $message['status'] = 'ERRO ao cadastrar, favor tente novamente:'.mysqli_error($conexao);
    echo json_encode($message);
}else{
    $message['status'] = "sucesso";
    echo json_encode($message);
}