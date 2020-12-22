<?php
require_once 'conexoes/conexao.php';
require_once 'conexoes/funcoes.php';
require_once 'conexoes/login.php';

switch ($_GET['solicitacoes']) {
    case "cancelar":
        cancelarSolicitacao($_GET, $conexao);
        break;
    case "aprovar":
        if(is_admin()){
            aprovarSolicitacao($_GET, $conexao);
        } else{
            echo json_encode(Array("status"=>'erro'));
        }
        break;
    case "indeferir";
        if(is_admin()){    
            indeferirSolicitacao($_GET, $conexao);
        } else{
            echo json_encode(Array("status"=>'erro'));
        }
        break;
    case "reverter":
        reverterSolicitacao($_GET, $conexao);
}

function cancelarSolicitacao($get, $conexao){
    $idsolicitacoes = filter_input(INPUT_GET, 'id_solicitacoes');
    $query = "UPDATE `solicitacoes`
    SET 
        `situacao` = 'C' 
    WHERE 
        `id_solicitacoes` = $idsolicitacoes";

    $exec = mysqli_query($conexao, $query);

    if($exec == false ){
        echo json_encode(Array("status"=>'erro'));
    } else{
        echo json_encode(Array("status"=>'sucesso'));
    }
}

function aprovarSolicitacao($get, $conexao){
    $idsolicitacoes = filter_input(INPUT_GET, 'id_solicitacoes');
    $query = "UPDATE `solicitacoes` 
    SET
        `situacao` = 'D' 
    WHERE 
        `id_solicitacoes` = $idsolicitacoes";

    $exec = mysqli_query($conexao, $query);

    if($exec == false ){
        echo json_encode(Array("status"=>'erro'));
    } else{
        echo json_encode(Array("status"=>'sucesso'));
    }
}

function indeferirSolicitacao($get, $conexao){
    $idsolicitacoes = filter_input(INPUT_GET, 'id_solicitacoes');
    $query = "UPDATE `solicitacoes`
    SET 
        `situacao` = 'I'
    WHERE 
        `id_solicitacoes` = $idsolicitacoes";
    
    $exec = mysqli_query($conexao, $query);

    if($exec == false){
        echo json_encode(Array("status"=>'erro'));
    } else{
        echo json_encode(Array("status"=>'sucesso'));
    }
}

function reverterSolicitacao($get, $conexao){
    $idsolicitacoes = filter_input(INPUT_GET, 'id_solicitacoes');
    $query = "UPDATE `solicitacoes`
    SET 
        `situacao` = 'R'
    WHERE 
        `id_solicitacoes` = $idsolicitacoes";
    
    $exec = mysqli_query($conexao, $query);

    if($exec == false){
        echo json_encode(Array("status"=>'erro'));
    } else{
        echo json_encode(Array("status"=>'sucesso'));
    }
};