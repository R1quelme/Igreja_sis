<?php
require_once 'cabecalho.php';

if (!is_admin()) {
    header("location: user-login.php");
    die;
}
?>

<body id="body">
    <div class="table responsive">
        <div class="container">
            <br>
            <h2>Cadastros</h2>


            <script type="text/javascript">
                $("#telefone").mask("(00) 00000-0000");
                $("#cpf").mask("000.000.000-00");
                $("#telefone_edit").mask("(00) 00000-0000");
                $("#cpf_edit").mask("000.000.000-00");
            </script>


            <!-- Modal criar novo cadastro -->
            <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarModalLabel">Criar novo cadastro</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
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
                                            <label for="usuario">Usuário</label>
                                            <input type="text" name="usuario" id="usuario" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="senha">Senha </label>
                                            <input type="password" name="senha" id="senha" class="form-control" required>
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
                                <button type="submit" class="btn btn-success">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal vem até aqui -->


            <table class="table" id="tabela_sib" data-search="true" data-pagination="true" data-page-list="[10, 25, 50, 100, all]">
                <thead>
                    <tr>
                        <th scope="col" data-field="id" data-visible="false"></th>
                        <th scope="col" data-field="cpf" data-sortable="true">CPF</th>
                        <th scope="col" data-field="nome" data-sortable="true">Nome</th>
                        <th scope="col" data-field="endereco">Endereço </th>
                        <th scope="col" data-field="telefone">Telefone </th>
                        <th scope="col" data-field="email">E-mail</th>
                        <th scope="col" data-field="sexo">Sexo</th>
                        <th scope="col" data-field="tipo">Tipo</th>
                        <th scope="col" data-field="situacao">Situação</th>
                        <th scope="col" id="cadastros-editar" data-field="editar">Editar</th>
                        <th scope="col" id="cadastros-inativar" data-field="inativar">Inativar</th>
                    </tr>
                </thead>
            </table>
            <br>
            <hr>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
    <!-- PAra fazer a mascar esses dois links -->
    <script src="tata-master/dist/tata.js"></script>


    
    <footer class="container">
        <p>Matheus Riquelme &copy; 2020 Sistema Segunda Igreja Batista</p>
    </footer>
</body>

</html>
<script>
    function editarRegistro(id_usuario) {
        $.ajax({
            url: `cadastros-editar.php`,
            method: "POST",
            data: {
                id_usuario: id_usuario,
                cpf: $("#cpf_edit").val(),
                nome: $("#nome_edit").val(),
                endereco: $("#endereco_edit").val(),
                telefone: $("#telefone_edit").val(),
                email: $("#email_edit").val(),
                sexo: $("#sexo_edit").val(),
                tipo: $("#tipo_edit").val(),
                situacao: $("#situacao_edit").val(),
                cadastro: 'cadastro'
            },
            success: function(dados) {
                dados = JSON.parse(dados);
                console.log(dados);
                if (dados.status == "sucesso") {
                    enviarajax()
                    $('#cadastros-editar').modal('hide')
                    alertaMensagem('Cadastro editado com sucesso')
                } else {
                    alertaMensagem('Erro ao editar, favor contatar o suporte', false)
                }
            },
            error: function() {
                alertaMensagem('Erro ao editar, favor contatar o suporte', false)
            }
        })
    }

    function modalEditar(id_usuario) {


        function buscaEditar(id_usuario) {
            $.ajax({
                url: `busca_cadastro.php?id_usuario=${id_usuario}`,
                method: "GET",
                success: function(dados) {
                    dados = JSON.parse(dados);

                    $("#cpf_edit").val(dados[0]["cpf"])
                    $("#nome_edit").val(dados[0]["nome"])
                    $("#endereco_edit").val(dados[0]["endereco"])
                    $("#telefone_edit").val(dados[0]["telefone"])
                    $("#email_edit").val(dados[0]["email"])
                    $("#sexo_edit").val(dados[0]["sexo"])
                    $("#tipo_edit").val(dados[0]["tipo"])
                    $("#situacao_edit").val(dados[0]["situacao"])
                    $('#cadastros-editar').modal('show')
                }
            })
        }



        function criarModalEditar() {

            $('#body').append(`
        <div class="modal fade" id="cadastros-editar" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarModalLabel">Editar cadastro</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="form_editar">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="cpf_edit">CPF</label>
                                            <input type="text" name="cpf_edit" id="cpf_edit" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nome_edit">Representante</label>
                                            <input type="text" name="nome_edit" id="nome_edit" class="form-control" placeholder="Nome completo" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="endereco_edit">Endereco</label>
                                            <input type="text" name="endereco_edit" id="endereco_edit" class="form-control" placeholder="Rua Bairro e Nº" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="telefone_edit">Telefone</label>
                                            <input type="text" name="telefone_edit" id="telefone_edit" class="form-control" placeholder="(35)99999-9999" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email_edit">E-mail</label>
                                            <input type="text" name="email_edit" id="email_edit" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="sexo_edit">Sexo</label>
                                            <select name="sexo_edit" id="sexo_edit" class="form-control">
                                                <option value="M">Masculino</option>
                                                <option value="F">Feminino</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tipo_edit">Tipo</label>
                                            <select name="tipo_edit" id="tipo_edit" class="form-control">
                                                <option value="usuario">Usuario</option>
                                                <option value="admin">Administrador</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="situacao_edit">Situacao</label>
                                            <select name="situacao_edit" id="situacao_edit" class="form-control">
                                                <option value="ativo">Ativo</option>
                                                <option value="inativo">Inativo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                <button type="button" class="btn btn-success" value="Editar" onclick='editarRegistro(${id_usuario})'>Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    `)

            $('#cadastros-editar').on('hidden.bs.modal', function(e) {
                $("#cadastros-editar").remove();
            })

        }
        criarModalEditar()

        buscaEditar(id_usuario);
    }



    function inativar(id_usuario) {
        $.ajax({
            url: `cadastros-excluir.php?id_usuario=${id_usuario}`,
            method: "GET",
            success: function(dados) {
                dados = JSON.parse(dados)
                if (dados.status == "sucesso") {
                    enviarajax()
                    $('#cadastros-excluir').modal('hide')
                    alertaMensagem('Cadastro inativado com sucesso')
                } else {
                    $('#cadastros-excluir').modal('hide')
                    alertaMensagem('Erro ao inativar, favor contatar o suporte', false)
                }
            },
            error: function() {
                alertaMensagem('Erro ao inativar, favor contatar o suporte', false)
            }
        })
    }

    function modalExcluir(id_usuario) {

        function criarMODALEXCLUIR() {
            $('#body').append(`
        <div id="cadastros-excluir" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h4 class="modal-title">Deletar cadastro</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Voce tem certeza que deseja inativar esse cadastro?</p>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                            <input type="button" class="btn btn-danger" value="Inativar" onclick='inativar(${id_usuario})'>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        `)

            $('#cadastros-excluir').on('hidden.bs.modal', function(e) {
                $("#cadastros-excluir").remove();
            })

        }
        criarMODALEXCLUIR()

        $('#cadastros-excluir').modal('show')
    }


    function alertaMensagem(texto, sucesso = true) {
        if (sucesso) {
            tata.success(texto, '')
        } else {
            tata.error(texto, '')
        }
    }

    function enviarajax() {
        $.ajax({
            url: "busca_cadastro.php",
            success: function(result) {

                $('#tabela_sib').bootstrapTable('destroy')
                $('#tabela_sib').bootstrapTable({
                    data: JSON.parse(result)
                })
                $('#tabela_sib').bootstrapTable('refreshOptions', {
                    classes: "table"
                })
                $(".fixed-table-toolbar").append(`
                    <div class="float-left" style="margin-top: 10px;color: #fff !important;">
                    <p><a id="novoCadastro" onclick="abrirModalNovoCadastro()" class="btn btn-info">Criar cadastro</a></p>
                    </div>
                    `)

            }
        })

    }

    enviarajax()

    function abrirModalNovoCadastro() {
        $('#editarModal').modal('show')
    };

    function salvarCadastro(event) {
        event.preventDefault()
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
                usuario: $("#usuario").val(),
                senha: $("#senha").val(),
            },
            success: function(dados) {
                dados = JSON.parse(dados)
                if (dados.status == "sucesso") {
                    enviarajax()
                    $('#editarModal').modal('hide')
                    alertaMensagem('Cadastro realizado com sucesso')
                } else {
                    alertaMensagem('Erro ao cadastrar, favor contatar o suporte', false)
                }
            },
            error: function() {
                alertaMensagem('Erro ao cadastrar, favor contatar o suporte', false)
            }
        })
    }
</script>