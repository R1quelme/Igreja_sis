<?php 
session_start();

if(!isset($_SESSION['user_igreja'])){
    $_SESSION['user_igreja'] = "";
    $_SESSION['nome_igreja'] = "";
    $_SESSION['tipo_igreja'] = "";
    $_SESSION['id_usuario_igreja'] = "";
}

function logout(){
    unset($_SESSION['user_igreja']);
    unset($_SESSION['nome_igreja']);
    unset($_SESSION['tipo_igreja']);
    unset($_SESSION['id_usuario_igreja']);
}


function is_logado(){
    if(empty($_SESSION['user_igreja'])){
        return false;
    } else{
        return true;
    }
}

function is_admin(){
    $t = $_SESSION['tipo_igreja'] ?? null;
    if(is_null($t)){ //se a variavel t estiver nula, ou seja, se ele nem estiver logado, ele não é admin, então é falso    
        return false;
    } else {
        if ($t == 'admin'){
            return true;
        } else {
            return false;
        }
    }
}