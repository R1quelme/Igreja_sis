<?php
require_once 'cabecalho.php';
require_once 'conexoes/conexao.php';
require_once 'conexoes/login.php';
require_once 'conexoes/funcoes.php';

if (is_logado()) {
    header("Location: index.php");
    exit;
}

function formulario($msg, $usuario = "")
{
    echo  '<br><form action="user-login.php" method="post">
    <div class="container">
    <div class="corpo">
        <div class="row">
            <div class="col-md-3 col-md-offset-0">
                <div class="form-group">
                    <label><b>Usuário</b></label>
                    <input type="text" name="usuario" id="usuario" class="form-control" value="' . $usuario . '">
                </div>
                <div class="form-group">
                    <label><b>Senha</b></label>
                    <input type="password" name="senha" id="senha" class="form-control">
                    <a href="" data-toggle="modal" data-target="#criarCadastro">Criar novo cadastro</a>
                </div>
                ' . $msg . '
                <input type="submit" class="btn btn-success btn-block" value="Entrar">
            </div>
        </div>
    </div>
</div>
</form>';
}
?>

<body>
    <div id="corpo">
        <?php
        $usuario = ($_POST['usuario']) ?? null;
        $senha = $_POST['senha'] ?? null;

        if (is_null($usuario) || is_null($senha)) {
            formulario('');
        } else {
            $q = "SELECT id_usuario, usuario, nome, senha, tipo, situacao FROM cadastro WHERE usuario = '$usuario' LIMIT 1";
            $busca = $conexao->query($q);
            if (!$busca) {
                echo "Falha ao acessar o banco";
            } else {
                if ($busca->num_rows > 0) {
                    $registro = $busca->fetch_object();
                    if ($registro->situacao === "ativo") {
                        if (testarHash($senha, $registro->senha)) {
                            header("location: index.php");
                            $_SESSION['user_igreja'] = $registro->usuario;
                            $_SESSION['nome_igreja'] = $registro->nome;
                            $_SESSION['tipo_igreja'] = $registro->tipo;
                            $_SESSION['id_usuario_igreja'] = $registro->id_usuario;
                        } else {
                            formulario(msg_erro('Senha Inválida'), $usuario);
                        }
                    } else {
                        formulario(msg_erro('Usuário inátivo'));
                    }
                } else {
                    formulario(msg_erro('Usuário inválido'));
                }
            }
        }
        ?>
    </div>

    <script type="text/javascript">
        $("#telefone").mask("(00) 00000-0000");
        $("#cpf").mask("000.000.000-00");
    </script>

    <div class="container"><br>
        <!-- Modal -->
        <div class="modal fade" id="criarCadastro" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Novo cadastro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form_ke" onsubmit="return salvarCadastro(event)">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="cpf">CPF</label>
                                            <input type="text" name="cpf" id="cpf" class="form-control" placeholder="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nome">Nome</label>
                                            <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome completo" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="endereco">Endereço</label>
                                            <input type="text" name="endereco" id="endereco" class="form-control" placeholder="Rua Bairro e Nº" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="telefone">Telefone</label>
                                            <input type="text" name="telefone" id="telefone" class="form-control" placeholder="(35)99999-9999" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">E-mail</label>
                                            <input type="email" name="email" id="email" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="sexo">Sexo</label>
                                            <select name="sexo" id="sexo" class="form-control">
                                                <option value="M">Masculino</option>
                                                <option value="F">Feminino</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="usuario_log">Usuário</label>
                                            <input type="text" name="usuario_log" id="usuario_log" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="senha_log">Senha </label>
                                            <input type="password" name="senha_log" id="senha_log" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="senha2">Confirmar senha</label>
                                            <input type="password" name="senha2" id="senha2" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-success">Criar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
        <script src="tata-master/dist/tata.js"></script>

        <br><br>
        <hr>
        <footer class="container">
            <p>Matheus Riquelme &copy; 2020 Sistema Segunda Igreja Batista</p>
        </footer>
    </div>
</body>

<script>
    function alertaMensagem(texto, sucesso = true) {
        if (sucesso) {
            tata.success(texto, '')
        } else {
            tata.error(texto, '')
        }
    }

    function salvarCadastro(event) {
        event.preventDefault()
        if ($("#senha_log").val() === $("#senha2").val()) {
            $.ajax({
                url: "ajax/criarCadastro.php",
                method: "POST",
                data: {
                    cpf: $("#cpf").val(),
                    nome: $("#nome").val(),
                    endereco: $("#endereco").val(),
                    telefone: $("#telefone").val(),
                    email: $("#email").val(),
                    sexo: $("#sexo").val(),
                    usuario: $("#usuario_log").val(),
                    senha: $("#senha_log").val(),
                },
                success: function(dados) {
                    dados = JSON.parse(dados)
                    if (dados.status == "sucesso") {
                        $('#criarCadastro').modal('hide')
                        alertaMensagem('Cadastro realizado com sucesso')
                    } else {
                        alertaMensagem('Erro ao cadastrar, favor contatar o suporte', false)
                    }
                },
                error: function() {
                    alertaMensagem('Erro ao cadastrar, favor contatar o suporte', false)
                }

            })
        } else {
            alertaMensagem('Erro ao cadastrar, suas senhas nao coincidem', false)
        }
    }
</script>