<?php
require_once 'conexoes/conexao.php';

$q = "SELECT 
        id_tipo_solicitacao, descricao, situacao
      FROM
        tipo_solicitacao";
$id = '';
if(array_key_exists("id_tipo_solicitacao", $_GET)){
    $id = $_GET['id_tipo_solicitacao'];
    $q .= " WHERE (id_tipo_solicitacao=$id)";  
}
$resultados = $conexao->query($q);

$arraypararetorno = [];
while ($registro = $resultados->fetch_object()){
    $array = [];
    $array['id_tipo_solicitacao'] = $registro->id_tipo_solicitacao;
    $array['descricao'] = $registro->descricao;
    $array['situacao'] = $registro->situacao; 
    if($id == ''){
        $array['editar'] = "<a class='btn btn-info' onclick='modalEditar(" . $registro->id_tipo_solicitacao . ")' style='color: #fff !important;'>Editar</a>";
        $array['inativar'] = "<a  class='btn btn-danger' onclick='modalExcluir(" . $registro->id_tipo_solicitacao . ")' style='color: #fff !important;'>Inativar</a>";
    }             

    $arraypararetorno[] = $array;
}

echo json_encode($arraypararetorno);