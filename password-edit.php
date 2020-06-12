<?php
require_once 'cabecalho.php';
require_once 'conexoes/conexao.php';
if (!is_logado()) {
    header("location: user-login.php");
    die;
}

$result_usuario = "SELECT * FROM cadastro WHERE id_usuario='" . $_SESSION['id_usuario_igreja'] . "'";
$resultado_usuario = mysqli_query($conexao, $result_usuario);
$row_usuario = mysqli_fetch_assoc($resultado_usuario);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>CRUD - Editar</title>
</head>

<body>
    <div class="container">
        <div class="float-left" style="margin-top: 10px;color: #fff !important;">
            <p><a href="user-edit.php" id="novoCadastro" class="btn btn-info">Alterar cadastro</a></p>
        </div>
        <form method="POST">
            <br><br><br><br>
            <h1>Alterar senha</h1>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <label for="senha_atual"><strong>Senha atual</strong></label>
                        <input type="text" name="senha_atual" id="senha_atual" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nova_senha"><strong>Nova senha</strong></label>
                        <input type="password" name="nova_senha" id="nova_senha" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmar_senha"><strong>Confirmar senha</strong></label>
                        <input type="password" name="confirmar_senha" id="confirmar_senha" class="form-control" required>
                    </div>
                    <button type="button" class="btn btn-success" onclick='alterarSenha()'>Salvar</button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
    <!-- mensagens de aviso, é esse link abaixo -->
    <script src="tata-master/dist/tata.js"></script>
</body>

</html>

<script> 


    function alertaMensagem(texto, sucesso = true) {
        if (sucesso) {
            tata.success(texto, '')
        } else {
            tata.error(texto, '')
        }
    }

    function alterarSenha() {
        // if(value="< ?php $row_usuario['senha']?>" ===  $("#senha_atual").val()){
        if($("#nova_senha").val() === $("#confirmar_senha").val()){
        $.ajax({
            url: `cadastros-editar.php`,
            method: "POST",
            data: {
                senha_atual: $("#senha_atual").val(),
                senha: $("#nova_senha").val(),
                cadastro: 'senha'
            },
            success: function(dados) {
                dados = JSON.parse(dados);
                console.log(dados);
                if (dados.status == "sucesso") {
                    alertaMensagem('Senha editada com sucesso')
                } else {
                    alertaMensagem('Senha atual errada', false)
                }
            },
            error: function() {
                alertaMensagem('Erro ao excluir, favor contatar o suporte', false)
            }
        })
        }else{
            alertaMensagem('Erro ao editar, suas senhas nao coincidem', false)
        }
        // }else{
        //     alertaMensagem('Sua senha atual nao coincide com a que voce pois', false)
        // }
    }
</script> 