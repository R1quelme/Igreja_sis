<?php 
    include("cabecalho.php");

    if(isset($_POST['enviar'])){
        
        $email = mysqli ->escape_string($_POST['email']);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $erro[] = "E-mail inválido.";
        }

        $sql_code = "SELECT senha FROM cadastro WHERE email = '$_SESSION[email]'"

        $novaSenha = substr(md5(time()), 0, 6);
        $senhaCriptografada = gerarHash(substr(md5(time()), 0, 6));
    }

?>


<form action="">
    <div class="container">
        <div class="row">
            <div class="col-md-11 offset-md-4">
                <div class="form-group">
                    <label><b>E-mail</b></label>
                    <input placeholder="Seu e-mail" name="email" type="text">
                </div>
                <input type="submit" class="btn btn-success btn-block" value="enviar" name="enviar">
            </div>
        </div>
    </div>
</form>