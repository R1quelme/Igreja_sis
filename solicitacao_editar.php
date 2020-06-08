<?php 
require_once 'conexoes/conexao.php';

$id_solicitacoes = $_POST['id_solicitacoes'] ?? null;
$descricao = $_POST['descricao'] ?? null;
$observacao = $_POST['observacao'] ?? null;

$q = "UPDATE `solicitacoes`
SET 
    `id_tipo_solicitacao` = '$descricao',
    `observacao` = '$observacao'
WHERE
    (`id_solicitacoes` = $id_solicitacoes)";

if($conexao->query($q)){
    echo json_encode(array("status" => "sucesso"));
} else{
    echo "Erro ao editar";
    echo $conexao ->error;
}
