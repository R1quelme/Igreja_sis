<?php
require_once 'conexoes/conexao.php';


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
    solicitacoes AS s
    JOIN
    tipo_solicitacao AS t ON c.id_usuario = s.id_usuario;
";
    // cadastro AS c
    //     JOIN 
    // solicitacoes AS s ON c.id_usuario = s.id_usuario
    //     JOIN
    // tipo_solicitacao AS t ON s.id_solicitacoes = t.id_tipo_solicitacao;

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
    $array['acoes'] = "<i class='material-icons' onclick='modalCancelar(" . $registro->id_solicitacoes . ")'>cancel</i>
    <i class='material-icons' onclick='modalEditar(" . $registro->id_usuario . ")'>edit</i>
    <i class='material-icons' onclick='modalAprovar(" . $registro->id_solicitacoes . ")'>check_circle</i>
    <i class='material-icons' onclick='modalIndeferir(" . $registro->id_solicitacoes . ")'>delete_forever</i>";
    
    $arraypararetorno[] = $array;
}

echo json_encode($arraypararetorno);
