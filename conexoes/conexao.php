<?php

$conexao = new mysqli("localhost", "Riquelme_admin", "12345678", "igreja_sib");

if($conexao->connect_errno) {
    echo "<p>Encontrei um erro $conexao->errno --> 
    $conexao->connect_error</p>";
    die();
}

$conexao->query("SET NAMES 'utf-8'");
$conexao->query("SET character_set_connection=utf8");
$conexao->query("SET character_set_client=utf8");
$conexao->query("SET character_set_results=utf8");

// $busca = $conexao->query("select * from cadastro");
// if(!$busca) {
//     echo "<p>Falha na busca! $conexao->error</p>";
// } else {    
//         while($registro = $busca->fetch_object()){
//          print_r($registro);
//        } 
// } //mostra os registros da tabela