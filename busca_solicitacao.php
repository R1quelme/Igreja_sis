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
    if(is_admin()){
        $array['acoes'] = "<i class='material-icons' style='cursor:pointer; color: #d60000' onclick='modalCancelar(" . $registro->id_solicitacoes . ")'>cancel</i>
        <i id='mouse' class='material-icons' style='cursor:pointer; color: #117a8b;' onclick='modalEditar(" . $registro->id_usuario . ")'>edit</i>
        <i class='material-icons' style='cursor:pointer; color: #007500' onclick='modalAprovar(" . $registro->id_solicitacoes . ")'>check_circle</i>
        <i class='material-icons' style='cursor:pointer; color: black' cursor:pointer; onclick='modalIndeferir(" . $registro->id_solicitacoes . ")'>delete_forever</i>";
    } elseif($registro->situacao == 'R'){
        $array['acoes'] = "<i class='material-icons' style='cursor:pointer ;color: #d60000' onclick='modalCancelar(" . $registro->id_solicitacoes . ")'>cancel</i><i class='material-icons' style='color: #117a8b;' onclick='modalEditar(" . $registro->id_usuario . ")'>edit</i>";
    // } elseif($registro->situacao == 'D'){
    //     $array['acoes'] = "<i class='material-icons' style='color: #d60000' onclick='modalCancelar(" . $registro->id_solicitacoes . ")'>cancel</i>";
    // } 
    }else{
        $array['acoes'] = 'Não há ações';
    }
    
    $arraypararetorno[] = $array;
}

echo json_encode($arraypararetorno);
