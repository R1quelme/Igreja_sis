<?php 
require_once 'conexoes/conexao.php';

$idcadastros = filter_input(INPUT_GET, 'id_tipo_solicitacao');
$query = "DELETE FROM `tipo_solicitacao` WHERE `id_tipo_solicitacao` = $idcadastros";

$exec = mysqli_query($conexao, $query);

if($exec == false){
    echo json_encode(Array("status"=>'erro'));
} else{
    echo json_encode(Array("status"=>'sucesso'));
}