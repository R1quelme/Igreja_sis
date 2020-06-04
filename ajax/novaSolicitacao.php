<?php 
require_once '../conexoes/conexao.php';
require_once '../conexoes/funcoes.php';

$observacao = $_POST['observacao'];

$q = "INSERT 
    INTO `igreja_sib`.`solicitacoes` 
        (`id_usuario`, `id_tipo_solicitacao`, `observacao`) 
    VALUES ('66', '1', '$observacao');
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