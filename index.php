<?php
require_once 'cabecalho.php';
require_once 'conexoes/conexao.php';
require_once 'conexoes/login.php';
require_once 'conexoes/funcoes.php';

if (!is_logado()) {
    header("location: user-login.php");
    die;
}

$queryOptionsSolicitacao = mysqli_query($conexao, "
SELECT 
    id_tipo_solicitacao, descricao, situacao
FROM
    tipo_solicitacao
where situacao = 'A';
");
?>

<body id="body">
    <div class="table responsive">
        <div class="container">
            <br>
            <h2>Solicitações</h2>
            <div class="float-left" style="margin-top: 10px;color: #fff !important;">
                <p><a id="solicitacao" onclick="abrirModalSolicitacao()" class="btn btn-info">Fazer solicitação</a></p>
            </div>

            <table id="tabela_sib" data-search="true" data-pagination="true" data-page-list="[10, 25, 50, 100, all]">
                <thead>
                    <tr>
                        <th scope="col" data-field="id" data-visible="false"></th>
                        <th scope="col" data-field="nome">Nome</th>
                        <th scope="col" data-field="endereco">Endereço </th>
                        <th scope="col" data-field="solicitacao">Tipo de solicitação</th>
                        <th scope="col" data-field="observacao">Observação</th>
                        <th scope="col" data-field="criado" data-sortable="true">Criado</th>
                        <th scope="col" data-field="situacao">Situação</th>
                        <th scope="col" id="cadastros-editar" data-field="acoes">Ações</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalSolicitacao" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModalLabel">Fazer solicitação</h5>
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
                                    <select name="descricao" id="descricao" class="form-control" required>
                                        <?php
                                        while ($prod = mysqli_fetch_array($queryOptionsSolicitacao)) { ?>
                                            <option value="<?php echo $prod['id_tipo_solicitacao'] ?>"><?php echo $prod['descricao'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="observacao">Observação</label>
                                    <textarea type="text" name="observacao" id="observacao" class="form-control" required></textarea>
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
    <div class="container">
        <br>
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

    function enviarajax() {
        $.ajax({
            url: "busca_solicitacao.php",
            method: "GET", //POST
            data: {
                busca: 'tudo'
            },
            success: function(result) {

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

    enviarajax()

    ///modal e onde manda a requisição do salvar///
    function abrirModalSolicitacao() {
        $('#modalSolicitacao').modal('show')
    };

    function salvarCadastro(event) {
        event.preventDefault()
        $.ajax({
            url: "ajax/novaSolicitacao.php",
            method: "POST",
            data: {
                descricao: $("#descricao").val(),
                observacao: $("#observacao").val(),
            },
            success: function(dados) {
                dados = JSON.parse(dados)
                if (dados.status == "sucesso") {
                    enviarajax()
                    $('#modalSolicitacao').modal('hide')
                    alertaMensagem('Solictação realizado com sucesso')
                } else {
                    alertaMensagem('Erro ao fazer solitação, ', false)
                }
            },
            error: function() {
                alertaMensagem('Erro ao fazer solitaçãor, favor contatar o suporte', false)
            }
        })
    }
    ///modal e onde manda a requisição do salvar///


    function reverter(id_solicitacoes){
        $.ajax({
            url: `solicitacao-acoes.php?id_solicitacoes=${id_solicitacoes}`,
            method: "GET",
            data: {
                solicitacoes: 'reverter'
            },
            success: function(dados){
                dados = JSON.parse(dados)
                if(dados.status == "sucesso"){  
                    enviarajax()
                    $('#solicitacao-reverter').modal('hide')
                    alertaMensagem('Solicitacao retornada para requerida novamento com sucesso')
                } else{
                    $('#solicitacao-reverter').modal('hide')
                    alertaMensagem('Erro ao retornar solicitacao para requerida novamente, favor contatar o suporte')
                }
            },
            error: function(){
                alertaMensagem('Erro ao retornar solicitacao para requerida novamente, favor contatar o suporte')
            }
        })
    }

    function modalReverter(id_solicitacoes){
        function criarModalReverter(){
           $('#body').append(`
            <div id="solicitacao-reverter" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form>
                            <div class="modal-header">
                                <h4 class="modal-title">Reverter solicitação</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>Voce tem certeza que deseja desfazer a sua ação e reverte-la para requerida novamente?</p>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Fechar">
                                <input type="button" class="btn btn-success" value="Reverter" onclick='reverter(${id_solicitacoes})'>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
           `)
           
           $('#solicitacao-reverter').on('hidden.bs.modal', function(e) {
                $("#solicitacao-reverter").remove();
            })
        }

        criarModalReverter()

        $('#solicitacao-reverter').modal('show')
    }


    function cancelar(id_solicitacoes) {
        $.ajax({
            url: `solicitacao-acoes.php?id_solicitacoes=${id_solicitacoes}`,
            method: "GET",
            data: {
                solicitacoes: 'cancelar'
            },
            success: function(dados) {
                dados = JSON.parse(dados)
                if (dados.status == "sucesso") {
                    enviarajax()
                    $('#solicitacao-cancelar').modal('hide')
                    alertaMensagem('Solicitação cancelada com sucesso')
                } else {
                    $('#solicitacao-cancelar').modal('hide')
                    alertaMensagem('Erro ao cancelar, favor contatar o suporte', false)
                }
            },
            error: function() {
                alertaMensagem('Erro ao cancelar, favor contatar o suporte', false)
            }
        })
    }


    function modalCancelar(id_solicitacoes) {

        function criarMODALCancelar() {
            $('#body').append(`
            <div id="solicitacao-cancelar" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form>
                            <div class="modal-header">
                                <h4 class="modal-title">Cancelar solicitação</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>Voce tem certeza que deseja cancelar a sua solicitação?</p>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Fechar">
                                <input type="button" class="btn btn-danger" value="Cancelar" onclick='cancelar(${id_solicitacoes})'>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            `)

            $('#solicitacao-cancelar').on('hidden.bs.modal', function(e) {
                $("#solicitacao-cancelar").remove();
            })

        }
        criarMODALCancelar()

        $('#solicitacao-cancelar').modal('show')
    }

    function aprovar(id_solicitacoes) {
        $.ajax({
            url: `solicitacao-acoes.php?id_solicitacoes=${id_solicitacoes}`,
            method: "GET",
            data: {
                solicitacoes: 'aprovar'
            },
            success: function(dados) {
                dados = JSON.parse(dados)
                if (dados.status == "sucesso") {
                    enviarajax()
                    $('#solicitacao-aprovar').modal('hide')
                    alertaMensagem('Solicitação aprovada com sucesso')
                } else {
                    $('#solicitacao-aprovar').modal('hide')
                    alertaMensagem('Erro no comando, favor contatar o suporte', false)
                }
            },
            error: function() {
                alertaMensagem('Erro no comando, favor contatar o suporte', false)
            }
        })
    }


    function modalAprovar(id_solicitacoes) {

        function criarMODALAprovar() {
            $('#body').append(`
            <div id="solicitacao-aprovar" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form>
                            <div class="modal-header">
                                <h4 class="modal-title">Aprovar solicitação</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>Tem certeza que deseja aprovar essa solicitação?</p>
                                <p class="text-danger"><small>Está ação nao pode ser desfeita.</small></p>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Fechar">
                                <input type="button" class="btn btn-success" value="Aprovar" onclick='aprovar(${id_solicitacoes})'>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            `)

            $('#solicitacao-aprovar').on('hidden.bs.modal', function(e) {
                $("#solicitacao-aprovar").remove();
            })

        }
        criarMODALAprovar()

        $('#solicitacao-aprovar').modal('show')
    }
    
    
    function indeferir(id_solicitacoes) {
        $.ajax({
            url: `solicitacao-acoes.php?id_solicitacoes=${id_solicitacoes}`,
            method: "GET",
            data: {
                solicitacoes: 'indeferir'
            },
            success: function(dados) {
                dados = JSON.parse(dados)
                if (dados.status == "sucesso") {
                    enviarajax()
                    $('#solicitacao-indeferir').modal('hide')
                    alertaMensagem(`Solicitação de indeferida com sucesso`)
                } else {
                    $('#solicitacao-indeferir').modal('hide')
                    alertaMensagem('Erro no comando, favor contatar o suporte', false)
                }
            },
            error: function() {
                alertaMensagem('Erro no comando, favor contatar o suporte', false)
            }
        })
    }


    function modalIndeferir(id_solicitacoes) {

        function criarMODALIndeferir() {
            $('#body').append(`
            <div id="solicitacao-indeferir" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form>
                            <div class="modal-header">
                                <h4 class="modal-title">Indeferir solicitação</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>Tem certeza que deseja indeferir essa solicitação?</p>
                                <p class="text-danger"><small>Está ação nao pode ser desfeita.</small></p>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Fechar">
                                <input type="button" class="btn btn-danger" value="Indeferir" onclick='indeferir(${id_solicitacoes})'>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            `)

            $('#solicitacao-indeferir').on('hidden.bs.modal', function(e) {
                $("#solicitacao-indeferir").remove();
            })

        }
        criarMODALIndeferir()

        $('#solicitacao-indeferir').modal('show')
    }


    function editarRegistro(id_solicitacoes) {
        $.ajax({
            url: `solicitacao_editar.php`,
            method: "POST",
            data: {
                id_solicitacoes: id_solicitacoes,
                descricao: $("#descricao_edit").val(),
                observacao: $("#observacao_edit").val(),
            },
            success: function(dados) {
                dados = JSON.parse(dados);
                console.log(dados);
                if (dados.status == "sucesso") {
                    enviarajax()
                    $('#solicitacoes-edit').modal('hide')
                    alertaMensagem('Solicitação editada com sucesso')
                } else {
                    alertaMensagem('Erro ao editar, favor contatar o suporte', false)
                }
            },
            error: function() {
                alertaMensagem('Erro ao editar, favor contatar o suporte', false)
            }
        })
    }

    <?php
    $queryOptionsEditar = mysqli_query($conexao, "
        SELECT 
            id_tipo_solicitacao, descricao
        FROM
            tipo_solicitacao
        where 
            situacao = 'A';  
        ");
    ?>

    function modalEditar(id_solicitacoes) {


        function buscaEditar(id_solicitacoes) {
            $.ajax({
                url: `busca_solicitacao.php`,
                method: "GET",
                data: {
                    id_solicitacoes: id_solicitacoes,
                    busca: 'unica'
                },
                success: function(dados) {
                    dados = JSON.parse(dados);

                    $("#descricao_edit").val(dados[0]["id_tipo_solicitacao"])
                    $("#observacao_edit").val(dados[0]["observacao"])
                    $('#solicitacoes-edit').modal('show')
                }
            })
        }



        function criarModalEditar(){

            $('#body').append(`
            <div class="modal fade" id="solicitacoes-edit" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
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
                                                    <label for="descricao_edit">Tipo de solicitação</label>
                                                    <select name="descricao_edit" id="descricao_edit" class="form-control" required>
                                                        <?php
                                                        while ($prod = mysqli_fetch_array($queryOptionsEditar)) { ?> 
                                                            <option value="<?php echo $prod['id_tipo_solicitacao'] ?>"><?php echo $prod['descricao'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <div class="form-group">
                                                <label for="observacao_edit">Observação</label>
                                                <textarea type="text" name="observacao_edit" id="observacao_edit" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                    <button type="button" class="btn btn-success" value="Editar" onclick='editarRegistro(${id_solicitacoes})'>Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `)

            $('#solicitacoes-editar').on('hidden.bs.modal', function(e) {
                $("#solicitacoes-editar").remove();
            })

        }
        criarModalEditar()

        buscaEditar(id_solicitacoes);
    }
</script>