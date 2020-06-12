<?php
require_once '../conexoes/conexao.php';
require_once '../conexoes/login.php';
require_once '../conexoes/funcoes.php';

$cpf = $_POST['cpf'];
$nome = $_POST['nome'];
$endereco = $_POST['endereco'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$sexo = $_POST['sexo'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

$hash = gerarHash($senha);

if ($q = "SELECT id_usuario FROM cadastro WHERE usuario = '$usuario'") {
    $busca = $conexao->query($q);
    if (!$busca) {
        echo "Falha ao acessar o banco";
    } else {
        if ($busca->num_rows > 0) {
            $message = [];
            $message['status'] = 'ERRO ao cadastrar, favor tente novamente:';
            echo json_encode($message);
            die;
        } else {
            $q = "INSERT 
            INTO 
            `igreja_sib`.`cadastro` 
                 (`cpf`, `nome`, `endereco`, `telefone`, `email`, `sexo`, `usuario`, `senha`) 
            VALUES 
                 ('$cpf', '$nome', '$endereco', '$telefone', '$email', '$sexo', '$usuario', '$hash');
    ";
        }
    }
}



$res = mysqli_query($conexao, $q);
$message = [];
if (!$res) {
    $message['status'] = 'ERRO ao cadastrar, favor tente novamente:' . mysqli_error($conexao);
    // echo
    echo json_encode($message);
} else {
    $message['status'] = "sucesso";
    echo json_encode($message);
}
