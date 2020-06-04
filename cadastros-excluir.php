<?php

require_once 'conexoes/conexao.php';


$idcadastros = filter_input(INPUT_GET, 'id_usuario', FILTER_SANITIZE_SPECIAL_CHARS);
//$queryDelete = "DELETE FROM `cadastro_igreja`.`cadastros` WHERE (`id` = $_GET['id']);
// $queryDelete = "delete from `cadastro_igreja`.`cadastros` where (`id` = ".$_GET['id'].");";
$query = "UPDATE `cadastro` SET `situacao` = 'inativo' WHERE `id_usuario` = $idcadastros";

$exec = mysqli_query($conexao, $query);

if($exec == false ){
    echo json_encode(Array("status"=>'erro'));
} else{
    echo json_encode(Array("status"=>'sucesso'));
}