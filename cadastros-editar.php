<?php
session_start();

require_once 'conexoes/conexao.php';
require_once 'conexoes/funcoes.php';

switch ($_POST['cadastro']) {
    case "cadastro":
        editarCadastro($_POST, $conexao);
        break;
    case "usuario":
        editarUsuario($_POST, $conexao);
        break;
    case "senha":
        editarSenha($_POST, $conexao);
        break;
}

function editarCadastro($post, $conexao)
{
    $id_usuario = $post['id_usuario'] ?? null;
    $cpf = $post['cpf'] ?? null;
    $nome = $post['nome'] ?? null;
    $endereco = $post['endereco'] ?? null;
    $telefone = $post['telefone'] ?? null;
    $email = $post['email'] ?? null;
    $sexo = $post['sexo'] ?? null;
    $tipo = $post['tipo'] ?? null; 
    $situacao = $post['situacao'] ?? null;

    $q = "UPDATE `cadastro` 
    SET 
        `cpf` = '$cpf',
        `nome` = '$nome',
        `endereco` = '$endereco',
        `telefone` = '$telefone',
        `email` = '$email',
        `sexo` = '$sexo',
        `tipo` = '$tipo',
        `situacao` = '$situacao'
    WHERE
        (`id_usuario` = $id_usuario)";

    if ($conexao->query($q)) {
        echo json_encode(array("status" => "sucesso"));
    } else {
        echo " &nbsp &nbsp Erro ao editar";
        echo $conexao->error;
    }
}

function editarUsuario($post, $conexao)
{
    $id_usuario = $_SESSION['id_usuario_igreja'];
    $cpf = $post['cpf'] ?? null;
    $nome = $post['nome'] ?? null;
    $endereco = $post['endereco'] ?? null;
    $telefone = $post['telefone'] ?? null;
    $email = $post['email'] ?? null;
    $usuario = $post['usuario'] ?? null;

    $q = "UPDATE `cadastro` 
    SET 
        `cpf` = '$cpf',
        `nome` = '$nome',
        `endereco` = '$endereco',
        `telefone` = '$telefone',
        `email` = '$email',
        `usuario` = '$usuario'
    WHERE
        (`id_usuario` = $id_usuario)";

    if ($conexao->query($q)) {
        echo json_encode(array("status" => "sucesso"));
    } else {
        echo " &nbsp &nbsp Erro ao editar";
        echo $conexao->error;
    }
}

function editarSenha($post, $conexao)
{
    $id_usuario = $_SESSION['id_usuario_igreja'];
    $senha_atual = $post['senha_atual'];
    $senha = $post['senha'];
    $hash_atual = gerarHash($senha_atual);
    $hash = gerarHash($senha);

    
    $result_usuario = "SELECT senha FROM cadastro WHERE id_usuario='" . $_SESSION['id_usuario_igreja'] . "'";
    $resultado_usuario = mysqli_query($conexao, $result_usuario);
    $row_usuario = mysqli_fetch_assoc($resultado_usuario);
    
    // print_r($row_usuario);
    // exit;
    // echo $hash_atual; 
    // echo testarhash($senha_atual, $row_usuario['senha']);
    if (testarhash($senha_atual, $row_usuario['senha'])) {
        $q = "UPDATE `cadastro` 
    SET  
    `senha` = '$hash' 
    WHERE 
    (`id_usuario` = $id_usuario)";

        if ($conexao->query($q)) {
            echo json_encode(array("status" => "sucesso"));
        } else {
            echo " &nbsp &nbsp Erro ao editar";
            echo $conexao->error;
        }
    } else {
            echo json_encode(array("status" => "erro"));
    }
}
