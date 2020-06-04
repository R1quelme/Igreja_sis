<?php
function msg_aviso($m){
    $resp = "<div class='aviso'><i class='material-icons'>info</i> $m</div>";
    return $resp;
}

function msg_erro($m){
    $resp = "<div class='erro'><i class='material-icons'>error</i> $m</div>";
    return $resp;
}

function cripto($senha){
    $cripto = '';
    for($pos = 0; $pos < strlen($senha); $pos++){
        $letra = ord($senha[$pos]) + 1;
        $cripto .=chr($letra);
    } 
    return $cripto;
}

function gerarHash($senha){
    $txt = cripto($senha);
    $hash = password_hash($txt, PASSWORD_DEFAULT);
    return $hash;
}

function testarhash($senha, $hash){
    $ok = password_verify(cripto($senha), $hash);
    return $ok;
}