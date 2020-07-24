<?php
require_once 'cabecalho.php';

$queryOptionsCadastro = mysqli_query($conexao, "
SELECT 
    id_usuario, nome, situacao
FROM
    cadastro;
");

$queryOptionsTipoSolicitacao = mysqli_query($conexao, "
SELECT 
    id_tipo_solicitacao, descricao 
FROM
    tipo_solicitacao;
");
?>

<link href="https://unpkg.com/ionicons@4.5.5/dist/css/ionicons.min.css" rel="stylesheet">
<link rel="stylesheet" href="node_modules/select2/dist/css/select2.min.css">
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/select2/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
<script src="https://unpkg.com/tableexport.jquery.plugin/libs/jsPDF/jspdf.min.js"></script>
<script src="https://unpkg.com/tableexport.jquery.plugin/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/export/bootstrap-table-export.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<body>
    <div class="table responsive">
        <div class="container">
            <br>
            <form id="form">
                <div class="form-row">
                    <div class="col-md-5 mb-3">
                        <br>
                        <div class="col">
                            <label for="select2_nome"><b>Nome:</b></label>
                        </div>
                        <select style="width:400px;" data-placeholder="  Selecione quais campos deseja no seu relátorio" name="select2_nome" id="select2_nome" multiple>
                            <?php
                            while ($prod = mysqli_fetch_array($queryOptionsCadastro)) { ?>
                                <option value="<?php echo $prod['id_usuario'] ?>"><?php echo $prod['nome'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="col">
                            <br><label for="select2_situacao"><b>Situação:</b></label>
                        </div>
                        <select style="width:400px;" data-placeholder="  Selecione quais campos deseja no seu relátorio" name="select2_situacao" id="select2_situacao" multiple>
                            <option value="R">Requerido</option>
                            <option value="D">Deferido</option>
                            <option value="I">Indeferido</option>
                            <option value="C">Cancelado</option>
                        </select>
                    </div>

                    <div class="col-md-5 mb-3">
                        <div class="col">
                            <br><label for="select2_tipo_solicitacao"><b>Tipo de Solicitacao:</b></label>
                        </div>
                        <select style="width:400px;" data-placeholder="  Selecione quais campos deseja no seu relátorio" name="select2_tipo_solicitacao" id="select2_tipo_solicitacao" multiple>
                            <?php
                            mysqli_data_seek($queryOptionsTipoSolicitacao, 0);
                            while ($prod = mysqli_fetch_array($queryOptionsTipoSolicitacao)) { ?>
                                <option value="<?php echo $prod['id_tipo_solicitacao'] ?>"><?php echo $prod['descricao'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="col">
                            <br><label for="select2_mes"><b>Mês:</b></label>
                        </div>
                        <select style="width:400px;" data-placeholder="  Selecione quais campos deseja no seu relátorio" name="select2_mes" id="select2_mes" multiple>
                            <option value="1">Janeiro</option>
                            <option value="2">Feveiro</option>
                            <option value="3">Março</option>
                            <option value="4">Abril</option>
                            <option value="5">Maio</option>
                            <option value="6">Junho</option>
                            <option value="7">Julho</option>
                            <option value="8">Agosto</option>
                            <option value="9">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                        </select>
                    </div>
                </form>
            </div>
            <button type="button" class="btn btn-success" onclick="return enviarajax()">Filtrar</button>
            <button type="reset" class="btn btn-light">Limpar</button>

        <br><br><br>
        <div class="float-left">
            <h2 id="solicitacao">Relatorio</h2>
        </div>

        <form>
            <table id="tabela_sib" data-search="true" data-icons="icons" data-search="true" data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-show-fullscreen="true" data-show-columns="true" data-show-export="true">
                <thead>
                    <tr>
                        <th scope="col" data-field="nome" data-sortable="true">Nome</th>
                        <th scope="col" data-field="endereco">Endereço</th>
                        <th scope="col" data-field="solicitacao">Tipo de solicitação</th>
                        <th scope="col" data-field="observacao">Observação</th>
                        <th scope="col" data-field="criado" data-sortable="true">Criado</th>
                        <th scope="col" data-field="situacao">Situação</th>
                    </tr>
                </thead>
            </table>
        </form>
    </div>
    </div>

    <div class="container">
        <div align="right">
            <i onClick="window.print()" class='material-icons' style='cursor:pointer;'>print</i>
        </div>
        <br>
        <hr>
        <footer class="container">
            <p>Matheus Riquelme &copy; 2020 Sistema Segunda Igreja Batista</p>
        </footer>
    </div>
</body>

<script>
    function enviarajax() {
        $.ajax({
            url: "busca_solicitacao.php",
            method: "GET", //POST
            data: {
                busca: 'filtra',
                select2_nome: $("#select2_nome").val(),
                select2_situacao: $("#select2_situacao").val(),
                select2_tipo_solicitacao: $("#select2_tipo_solicitacao").val(),
                select2_mes: $("#select2_mes").val()
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
    enviarajax();

    window.icons = {
        export: 'ion-md-download',
        columns: 'ion-md-list',
        fullscreen: 'ion-md-expand'
    }

    $(document).ready(function() {
        $('#select2_nome').select2();
        $('#select2_situacao').select2();
        $('#select2_tipo_solicitacao').select2();
        $('#select2_mes').select2();
    })
</script>