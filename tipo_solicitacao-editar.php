<?php 
require_once 'conexoes/conexao.php';

$id_tipo_solicitacao = $_POST['id_tipo_solicitacao'] ?? null;
$descricao = $_POST['descricao'] ?? null;
$situacao = $_POST['situacao'] ?? null;

$q = "UPDATE `tipo_solicitacao` 
SET 
    `descricao` = '$descricao',
    `situacao` = '$situacao'
WHERE
    (`id_tipo_solicitacao` = $id_tipo_solicitacao)";

if($conexao->query($q)){
    echo json_encode(array("status" => "sucesso"));
} else{
    echo "Erro ao editar";
    echo $conexao ->error;
}
