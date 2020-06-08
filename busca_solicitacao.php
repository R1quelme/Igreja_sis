<?php
require_once 'conexoes/conexao.php';
require_once 'conexoes/login.php';


$q = "
SELECT 
    s.id_solicitacoes,
    c.id_usuario,
    t.id_tipo_solicitacao,
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


if(!is_admin()){
    $q .= " WHERE c.id_usuario = " . $_SESSION['id_usuario_igreja'];
}
$id = '';
if(array_key_exists("id_solicitacoes", $_GET)){
    $id = $_GET['id_solicitacoes'];
    $q .= " WHERE (id_solicitacoes=$id)";
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
    if($registro->situacao == 'R'){
        $array['situacao'] = "Requerido";
    }elseif($registro->situacao == 'I'){
        $array['situacao'] = "Indeferido";
    }elseif($registro->situacao == 'D'){
        $array['situacao'] = "Deferido";
    }elseif($registro->situacao == 'C'){
        $array['situacao'] = "Cancelado";
    }
    if(is_admin()){
        $array['acoes'] = "<i class='material-icons' style='cursor:pointer; color: #d60000' onclick='modalCancelar(" . $registro->id_solicitacoes . ")'>cancel</i>
        <i class='material-icons' style='cursor:pointer; color: #117a8b;' onclick='modalEditar(" . $registro->id_solicitacoes . ")'>edit</i>
        <i class='material-icons' style='cursor:pointer; color: #007500' onclick='modalAprovar(" . $registro->id_solicitacoes . ")'>check_circle</i>
        <i class='material-icons' style='cursor:pointer; color: #545b62' cursor:pointer; onclick='modalIndeferir(" . $registro->id_solicitacoes . ")'>delete_forever</i>";
    } elseif($registro->situacao == 'R'){
        $array['acoes'] = "<i class='material-icons' style='cursor:pointer ;color: #d60000' onclick='modalCancelar(" . $registro->id_solicitacoes . ")'>cancel</i>
        <i class='material-icons' style='cursor:pointer; color: #117a8b;' onclick='modalEditar(" . $registro->id_solicitacoes . ")'>edit</i>";
    // } elseif($registro->situacao == 'D'){
    //     $array['acoes'] = "<i class='material-icons' style='color: #d60000' onclick='modalCancelar(" . $registro->id_solicitacoes . ")'>cancel</i>";
    }else{
        $array['acoes'] = 'Não há ações';
    }
    
    $arraypararetorno[] = $array;
}

echo json_encode($arraypararetorno);
