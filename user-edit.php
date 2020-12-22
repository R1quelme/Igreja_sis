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


<script type="text/javascript">
    $("#telefone").mask("(00) 00000-0000");
    $("#cpf").mask("000.000.000-00");
</script>

<!DOCTYPE html>
<html lang="pt-br">

<head> 
    <meta charset="utf-8">
    <title>CRUD - Editar</title>
</head>

<body>
    <div class="container">
        <div class="float-left" style="margin-top: 10px;color: #fff !important;">
            <p><a href="password-edit.php" id="novoCadastro" class="btn btn-info">Alterar senha</a></p>
        </div>
        <form method="POST">
            <br><br><br><br>
            <h1>Editar Usuário</h1>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <label for="cpf"><strong>CPF</strong></label>
                        <input type="text" name="cpf" id="cpf" class="form-control" value="<?php echo $row_usuario['cpf']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nome"><strong>Nome</strong></label>
                        <input type="text" name="nome" id="nome" class="form-control" value="<?php echo $row_usuario['nome']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="endereco"><strong>Endereço</strong></label>
                        <input type="text" name="endereco" id="endereco" class="form-control" value="<?php echo $row_usuario['endereco']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telefone"><strong>Telefone</strong></label>
                        <input type="text" name="telefone" id="telefone" class="form-control" value="<?php echo $row_usuario['telefone']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email"><strong>E-mail</strong></label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo $row_usuario['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="usuario"><strong>Usuário</strong></label>
                        <input type="text" name="usuario" id="usuario" class="form-control" value="<?php echo $row_usuario['usuario']; ?>" required>
                    </div>
                    <button type="button" class="btn btn-success" onclick='editarRegistro()'>Salvar</button>
                </div>
            </div>
        </form>
    </div>
    <br><hr>
    <footer class="container">
        <p>Matheus Riquelme &copy; 2020 Sistema Segunda Igreja Batista</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
    <!-- PAra fazer a mascar esses dois links -->
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

    function editarRegistro() {
        $.ajax({
            url: `cadastros-editar.php`,
            method: "POST",
            data: {
                cpf: $("#cpf").val(),
                nome: $("#nome").val(),
                endereco: $("#endereco").val(),
                telefone: $("#telefone").val(),
                email: $("#email").val(),
                usuario: $("#usuario").val(),
                cadastro: 'usuario'
            },
            success: function(dados) {
                dados = JSON.parse(dados);
                console.log(dados);
                if (dados.status == "sucesso") {
                    
                    alertaMensagem('usuario editado com sucesso')
                } else {
                    alertaMensagem('Erro ao editar, favor contatar o suporte', false)
                }
            },
            error: function() {
                alertaMensagem('Erro ao excluir, favor contatar o suporte', false)
            }
        })
    }
</script> 