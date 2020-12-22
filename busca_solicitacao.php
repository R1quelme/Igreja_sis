






<?php
require_once 'conexoes/conexao.php';
require_once 'conexoes/funcoes.php';
require_once 'conexoes/login.php';

switch ($_GET['busca']) {
    case "tudo";
        buscaTudo($_GET, $conexao);
        break;
    case "unica";
        buscaUnica($_GET, $conexao);
        break;
    case "filtra";
        filtrar($_GET, $conexao);
        break;
}

// =======================================
// -----------------Tudo------------------
// =======================================
function buscaTudo($get, $conexao)
{
    $q = "
    SELECT 
        s.id_solicitacoes,
        c.id_usuario,
        s.id_tipo_solicitacao,
        c.nome,
        c.endereco,
        s.observacao,
        t.descricao,
        s.situacao,
        s.created
    FROM
        cadastro AS c
        JOIN 
        solicitacoes AS s on s.id_usuario = c.id_usuario
        JOIN
        tipo_solicitacao AS t ON t.id_tipo_solicitacao = s.id_tipo_solicitacao
    ";

    if (!is_admin()) {
        $q .= " and c.id_usuario = " . $_SESSION['id_usuario_igreja'];
    }
    $id = '';
    if (array_key_exists("id_solicitacoes", $_GET)) {
        $id = $_GET['id_solicitacoes'];
        $q .= " and (id_solicitacoes=$id)";
    }
    $resultados = $conexao->query($q); 

    $arraypararetorno = [];

    while ($registro = $resultados->fetch_object()) {
        $array = [];
        $datetime = new DateTime($registro->created);
        $datetimeformat = $datetime->format('d/m/Y');
        $array['id_solicitacoes'] = $registro->id_solicitacoes;
        $array['nome'] = $registro->nome;
        $array['endereco'] = $registro->endereco;
        $array['solicitacao'] = $registro->descricao;
        $array['observacao'] = $registro->observacao;
        $array['criado'] = $datetimeformat;
        if ($registro->situacao == 'R') {
            $array['situacao'] = "<span class='badge badge-pill badge-info' style='height: 19px; width: 90px; font-size: 98%';>Requerido</span>";
        } elseif ($registro->situacao == 'I') {
            $array['situacao'] = "<span class='badge badge-pill badge-danger' style='height: 19px; width: 90px; font-size: 98%';>Indeferido</span>";
        } elseif ($registro->situacao == 'D') {
            $array['situacao'] = "<span class='badge badge-pill badge-success' style='height: 19px; width: 90px; font-size: 98%';>Deferido</span>";
        } elseif ($registro->situacao == 'C') {
            $array['situacao'] = "<span class='badge badge-pill badge-danger' style='height: 19px; width: 90px; font-size: 98%';>Cancelado</span>";
        }

        if (is_admin() and $registro->situacao == 'R') {
            $array['acoes'] = "<i class='material-icons' style='cursor:pointer; color: #d60000' onclick='modalCancelar(" . $registro->id_solicitacoes . ")'>cancel</i>
            <i class='material-icons' style='cursor:pointer; color: #007500' onclick='modalAprovar(" . $registro->id_solicitacoes . ")'>check_circle</i>
            <i class='material-icons' style='cursor:pointer; color: #545b62' cursor:pointer; onclick='modalIndeferir(" . $registro->id_solicitacoes . ")'>delete_forever</i>";
        } elseif(is_admin() and $registro->situacao == 'D' || $registro->situacao == 'C' ||  $registro->situacao == 'I'){
            $array['acoes'] = "<i class='material-icons' style='cursor:pointer; color: #d60000' onclick='modalCancelar(" . $registro->id_solicitacoes . ")'>cancel</i>
            <i class='material-icons' style='cursor:pointer; color: #007500' onclick='modalAprovar(" . $registro->id_solicitacoes . ")'>check_circle</i>
            <i class='material-icons' style='cursor:pointer; color: #545b62' cursor:pointer; onclick='modalIndeferir(" . $registro->id_solicitacoes . ")'>delete_forever</i>";
        } elseif ($registro->situacao == 'R') {
            $array['acoes'] = "<i class='material-icons' style='cursor:pointer ;color: #d60000' onclick='modalCancelar(" . $registro->id_solicitacoes . ")'>cancel</i>
            <i class='material-icons' style='cursor:pointer; color: #117a8b;' onclick='modalEditar(" . $registro->id_solicitacoes . ")'>edit</i>";
        } elseif($registro->situacao == 'C'){   
            $array['acoes'] = "<i class='material-icons' style='cursor:pointer; color: black' onclick='modalReverter(" . $registro->id_solicitacoes . ")'>autorenew</i>";
        } else {
            $array['acoes'] = 'Não há ações';
        }

        $arraypararetorno[] = $array;
    }

    echo json_encode($arraypararetorno);
}

// =======================================
// ----------------Filtar-----------------
// =======================================
function filtrar($get, $conexao){
    $select2_nome = $get['select2_nome'] ?? null;
    $select2_situacao = $get['select2_situacao'] ?? null;
    $select2_tipo_solicitacao = $get['select2_tipo_solicitacao'] ?? null;
    $select2_mes= $get['select2_mes'] ?? null;

    $q = "
    SELECT 
        s.id_solicitacoes,
        c.id_usuario,
        s.id_tipo_solicitacao,
        c.nome,
        c.endereco,
        s.observacao,
        t.descricao,
        s.situacao,
        s.created
    FROM
        cadastro AS c
        JOIN 
        solicitacoes AS s on s.id_usuario = c.id_usuario
        JOIN
        tipo_solicitacao AS t ON t.id_tipo_solicitacao= s.id_tipo_solicitacao
    ";

    if($select2_nome != null){
        $valores = '';
        for($i = 0; $i< count($select2_nome);$i++){
            if($i == 0){
                $valores = $select2_nome[$i];
            } else{
                $valores .= ','. $select2_nome[$i];
            }
        }
        $q .=" and c.id_usuario in (" . $valores.")";
    }
    
    if($select2_situacao != null){
        $valores = '';
        for($i = 0; $i< count($select2_situacao); $i++){
            $id = $select2_situacao[$i];
            if($i == 0){
                $valores = "'$id'";
            } else{
                $valores .= ",'$id'";
            }
        }
        $q .=" and s.situacao in ($valores)";
    }

    if($select2_tipo_solicitacao != null){
    $valores = '';
        for($i = 0; $i< count($select2_tipo_solicitacao); $i++){
            if($i == 0){
                $valores = $select2_tipo_solicitacao[$i];
            } else{
                $valores .= ','. $select2_tipo_solicitacao[$i];
            }
        }
        $q .=" and s.id_tipo_solicitacao in (" . $valores.")";
    }

    if($select2_mes != null){
    $valores = '';
        for($i = 0; $i< count($select2_mes); $i++){
            if($i == 0){
                $valores = $select2_mes[$i];
            } else{
                $valores .= ','. $select2_mes[$i];
            }
        }
        $q .=" and MONTH(created) in (" . $valores.")";
    }

    $resultados = $conexao->query($q);  

    $arraypararetorno = [];

    while ($registro = $resultados->fetch_object()) {
        $array = [];
        $datetime = new DateTime($registro->created);
        $datetimeformat = $datetime->format('d/m/Y');
        $array['id_solicitacoes'] = $registro->id_solicitacoes;
        $array['nome'] = $registro->nome;
        $array['endereco'] = $registro->endereco;
        $array['solicitacao'] = $registro->descricao;
        $array['observacao'] = $registro->observacao;
        $array['criado'] = $datetimeformat;
        $array['situacao'] = $registro->situacao;
        if ($registro->situacao == 'R') {
            $array['situacao'] = "<span class='badge badge-pill badge-info' style='height: 19px; width: 90px; font-size: 98%';>Requerido</span>";
        } elseif ($registro->situacao == 'I') {
            $array['situacao'] = "<span class='badge badge-pill badge-danger' style='height: 19px; width: 90px; font-size: 98%';>Indeferido</span>";
        } elseif ($registro->situacao == 'D') {
            $array['situacao'] = "<span class='badge badge-pill badge-success' style='height: 19px; width: 90px; font-size: 98%';>Deferido</span>";
        } elseif ($registro->situacao == 'C') {
            $array['situacao'] = "<span class='badge badge-pill badge-danger' style='height: 19px; width: 90px; font-size: 98%';>Cancelado</span>";
        }
        
        $arraypararetorno[] = $array;
    }

    echo json_encode($arraypararetorno);
}

// =======================================
// ----------------Unica------------------
// =======================================
function buscaUnica($get, $conexao)
{
    $q = "
    SELECT 
        s.id_solicitacoes,
        c.id_usuario,
        t.id_tipo_solicitacao,
        s.observacao
    FROM
        cadastro AS c
        JOIN 
        solicitacoes AS s on s.id_usuario = c.id_usuario
        JOIN
        tipo_solicitacao AS t ON t.id_tipo_solicitacao= s.id_tipo_solicitacao
    where 
        (id_solicitacoes= " . $_GET['id_solicitacoes'] . " )
    ";
    //o where é para uma questão de segurança, para nao deixar que a pessoa consiga ir nos dados de editar de outra pessoa(vendo o nome da função) atraves d o id! 

    if (!is_admin()){
        $q .= " and c.id_usuario = " . $_SESSION['id_usuario_igreja'];
    }
    $resultados = $conexao->query($q);


    $arraypararetorno = [];

    while ($registro = $resultados->fetch_object()) {
        $array = [];
        $array['id_solicitacoes'] = $registro->id_solicitacoes;
        $array['id_tipo_solicitacao'] = $registro->id_tipo_solicitacao;
        $array['observacao'] = $registro->observacao;

        $arraypararetorno[] = $array;
    }

    echo json_encode($arraypararetorno);
}
