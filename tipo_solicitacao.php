<?php 
require_once 'cabecalho.php';
require_once 'conexoes/conexao.php';

if(!is_admin()){
    header("location: user-login.php");
    die;
}
?>

<body id="body">
    <div class="table responsive">
        <div class="container">
            <br>
            <h2>Tipo de solicitação</h2>
            <div class="float-left" style="margin-top: 10px;color: #fff !important;">
                <p><a id="solicitacao" onclick="abrirModalSolicitacao()" class="btn btn-info">Novo tipo de solicitação</a></p>
            </div>

            <table class="table" id="tabela_sib" data-search="true" data-pagination="true" data-page-list="[10, 25, 50, 100, all]">
                <thead>
                    <tr>
                        <th scope="col" data-field="id" data-visible="false"></th>
                        <th scope="col" data-field="descricao">Tipo de solicitação</th>
                        <th scope="col" data-field="situacao">Situação</th>
                        <th scope="col" id="tipo_solicitacao_editar" data-field="editar">Editar</th>
                        <th scope="col" id="tipo_solicitacao_excluir" data-field="excluir">Excluir</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalSolicitacao" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModalLabel">Novo tipo de solicitação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_ke" onsubmit="return salvarCadastro(event)">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="descricao">Tipo de solicitação</label>
                                    <input type="text" name="descricao" id="descricao" class="form-control" required>
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


    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
    <script src="tata-master/dist/tata.js"></script>

    <br>
    <footer class="container">
        <p>Matheus Riquelme &copy; 2020 Sistema Segunda Igreja Batista</p>
    </footer>
</body>

<script>
    function alertaMensagem(texto, sucesso = true) {
        if (sucesso) {
            tata.success(texto, '')
        } else {
            tata.error(texto, '')
        }
    }

    function enviarajax(){
        $.ajax({
            url: "busca_tipo_solicitacao.php",
            success: function(result){
                $('#tabela_sib').bootstrapTable('destroy')
                $('#tabela_sib').bootstrapTable({
                    data: JSON.parse(result)
                })
                $('#tabela_sib').bootstrapTable('refreshOptions', {
                    classes: "table"
                })
            }
        })
    }

    enviarajax();

    function abrirModalSolicitacao(){
        $('#modalSolicitacao').modal('show');
    };

    function salvarCadastro(event) {
        event.preventDefault()
        $.ajax({
            url: "ajax/novoTipoSolicitacao.php",
            method: "POST",
            data: {
                descricao: $("#descricao").val(),
            },
            success: function(dados) {
                dados = JSON.parse(dados)
                if (dados.status == "sucesso") {
                    enviarajax()
                    $('#modalSolicitacao').modal('hide')
                    alertaMensagem('Novo tipo de solicitação cadastrada com sucesso')
                } else {
                    alertaMensagem('Erro ao cadastrar, favor contatar o suporte', false)
                }
            },
            error: function() {
                alertaMensagem('Erro ao cadastrar, favor contatar o suporte', false)
            }
        })
    }

    function excluir(id_tipo_solicitacao) {
        $.ajax({
            url: `tipo_solicitacao-excluir.php?id_tipo_solicitacao=${id_tipo_solicitacao}`,
            method: "GET",
            success: function(dados) {
                dados = JSON.parse(dados)
                if (dados.status == "sucesso") {
                    enviarajax()
                    $('#cadastros-excluir').modal('hide')
                    alertaMensagem('Cadastro excluido com sucesso')
                } else {
                    $('#cadastros-excluir').modal('hide')
                    alertaMensagem('Erro ao excluir, favor contatar o suporte', false)
                }
            },
            error: function() {
                alertaMensagem('Erro ao excluir, favor contatar o suporte', false)
            }
        })
    }

    function modalExcluir(id_tipo_solicitacao) {

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
                            <p>Voce tem certeza que deseja excluir esse tipo de solicitacao?</p>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                            <input type="button" class="btn btn-danger" value="Excluir" onclick='excluir(${id_tipo_solicitacao})'>
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


    function editarSolicitacao(id_tipo_solicitacao) {
        $.ajax({
            url: `tipo_solicitacao-editar.php`,
            method: "POST",
            data: {
                id_tipo_solicitacao: id_tipo_solicitacao,
                descricao: $("#descricao_edit").val(),
                situacao: $("#situacao_edit").val(),
            },
            success: function(dados) {
                dados = JSON.parse(dados);
                console.log(dados);
                if (dados.status == "sucesso") {
                    enviarajax()
                    $('#tipo_solicitacao-editar').modal('hide')
                    alertaMensagem('Tipo de solicitação editado com sucesso')
                } else {
                    alertaMensagem('Erro ao editar, favor contatar o suporte', false)
                }
            },
            error: function() {
                alertaMensagem('Erro ao editar, favor contatar o suporte', false)
            }
        })
    }

    function modalEditar(id_tipo_solicitacao) {


        function buscaEditar(id_tipo_solicitacao) {
            $.ajax({
                url: `busca_tipo_solicitacao.php?id_tipo_solicitacao=${id_tipo_solicitacao}`,
                method: "GET",
                success: function(dados) {
                    dados = JSON.parse(dados); 

                    $("#descricao_edit").val(dados[0]["descricao"])
                    $("#situacao_edit").val(dados[0]["situacao"])
                    $('#tipo_solicitacao-editar').modal('show')
                }
            })
        }



        function criarModalEditar() {

            $('#body').append(`
        <div class="modal fade" id="tipo_solicitacao-editar" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
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
                                            <label for="descricao_edit">Tipo de solicitacao</label>
                                            <input type="text" name="descricao_edit" id="descricao_edit" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="situacao_edit">Situacao</label>
                                            <select name="situacao_edit" id="situacao_edit" class="form-control">
                                                <option value="A">Ativo</option>
                                                <option value="I">Inativo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                <button type="button" class="btn btn-success" value="Editar" onclick='editarSolicitacao(${id_tipo_solicitacao})'>Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    `)

            $('#tipo_solicitacao-editar').on('hidden.bs.modal', function(e) {
                $("#tipo_solicitacao-editar").remove();
            })

        }
        criarModalEditar()

        buscaEditar(id_tipo_solicitacao);
    }
</script>