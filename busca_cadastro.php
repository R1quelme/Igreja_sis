<?php
require_once 'conexoes/conexao.php';


$q = "SELECT id_usuario, cpf, nome, endereco, telefone, email, sexo, usuario, senha, tipo, situacao FROM cadastro";
$id = '';
if (array_key_exists("id_usuario", $_GET)) {
    $id = $_GET['id_usuario'];
    $q .= " WHERE (id_usuario=$id)";
}
$resultados = $conexao->query($q);


$arraypararetorno = [];

while ($registro = $resultados->fetch_object()) {
    $array = [];
    $array['id_usuario'] = $registro->id_usuario;
    $array['cpf'] = $registro->cpf;
    $array['nome'] = $registro->nome;
    $array['endereco'] = $registro->endereco;
    $array['telefone'] = $registro->telefone;
    $array['email'] = $registro->email;
    $array['sexo'] = $registro->sexo;
    $array['usuario'] = $registro->usuario;
    $array['tipo'] = $registro->tipo;
    $array['situacao'] = $registro->situacao;
    if($id == ''){    
        $array['editar'] = "<a class='btn btn-info' onclick='modalEditar(" . $registro->id_usuario . ")' style='color: #fff !important;'>Editar</a>";
        $array['inativar'] = "<a  class='btn btn-danger' onclick='modalExcluir(" . $registro->id_usuario . ")' style='color: #fff !important;'>Inativar</a>";
    }


    $arraypararetorno[] = $array;
}

echo json_encode($arraypararetorno);