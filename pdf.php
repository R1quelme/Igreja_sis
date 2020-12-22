<?php	
require_once 'conexoes/conexao.php';

// $html = '<table>';
// $html .= '<thead>';
// $html .= '<tr>';
// $html .= '<td><b>Nome</b></td>';
// $html .= '<td><b>Endereço</b></td>';
// $html .= '<td><b>Tipo de solicitação</b></td>';
// $html .= '<td><b>Observação</b></td>';
// $html .= '<td><b>Situação</b></td>';
// $html .= '<td><b>Criado</b></td>';
// $html .= '</tr>';
// $html .= '</thead>';


//  $_dompdf_warnings
$html = "<table BORDER RULES=rows>
	<thead>
		<tr>
		<td><b>Nome</b></td>
		<td><b>Endereço</b></td>
		<td><b>Tipo de solicitação</b></td>
		<td><b>Observação</b></td>
		<td><b>Situação</b></td>
		<td><b>Criado</b></td>
	</tr>
</thead>";

$result_solicitacoes = 
"SELECT 
	s.id_solicitacoes,
	c.id_usuario,
	s.id_tipo_solicitacao,
	t.descricao,
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
	tipo_solicitacao AS t ON t.id_tipo_solicitacao= s.id_tipo_solicitacao";

$resultado_solicitacoes = mysqli_query($conexao, $result_solicitacoes);

function data($data){
    return date("d/m/Y H:i", strtotime($data));
}

while($row_solicitacoes = mysqli_fetch_assoc($resultado_solicitacoes)){
	$html.='<tbody>';
	$html.='<tr><td>'. $row_solicitacoes['nome'] . '</td>';
	$html.='<td>'. $row_solicitacoes['endereco'] . '</td>';
	$html.='<td>'. $row_solicitacoes['descricao'] . '</td>';
	$html.='<td>'. $row_solicitacoes['observacao'] . '</td>';
	$html.='<td>'. $row_solicitacoes['situacao'] . '</td>';
	// $html.='<td>'. $row_solicitacoes['created'] . '</td>';
	$html.='<td>'. data($row_solicitacoes['created']) .'</td></tr>';
	$html.='</tbody>';
}
$html .= '</table>';

//referenciar o DomPDF com namespace


// include autoloader
require_once("dompdf/autoload.inc.php");
require_once("conexoes/login.php");

	// $objetorecebido = $_POST['table'];
	// echo '<pre>';
	// print_r($_POST);

	$agora = new DateTime();

	//Criando a Instancia
	$dompdf = new Dompdf\Dompdf;
	
	// Carrega seu HTML
	$dompdf->loadHtml('
	<style>
		table { border-collapse:collapse };
	</style>
	<!DOCTYPE html>
	<html lang="pt-br">
		<head>
			<meta charset="utf-8">
			<title>Igreja batista</title>
			<link href="assets/css/personalizarPDF.css" rel="stylesheet">
		</head>
		<body class="body">
			<header class="cabecalho">
				<div class="header">
					<img src="logo_batista.jpg" class="logo">
					<h2>Segunda Igreja Batista</h2>
					<p>Rua Acre, 203 - Santa Luzia</p>
					<p>PASSOS/MG - BRASIL - CEP 164000-503 / Telefone: (00) 00000-0000</p>
				</div>
			</header>
			<div class="grifar">
				<h2>Relatorio de solicitações</h2><br>
			</div>
			'.$html.'
			<footer id="rodape"><hr>
				<div class="box"> 
					<p>Data da impressão: '.$agora->format('d/m/Y H:i').' </p>
					<p>Emissor: '. $_SESSION['nome_igreja'] .' </p>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    				</div>
				<div class="box">
					<p style="color: #696969">&copy; Sistema SIB Desenvolvido por Matheus Riquelme Solutions</p>
				<div>
			</footer>
		</body>
	</html>'
	);

	$dompdf->setPaper('A4');
	
	//Renderizar o html
	$dompdf->render();
	
	// Exibir a página
	// echo base64_encode("relatorio_igreja.pdf");
	$dompdf->stream( 
		"relatorio_igreja.pdf", 
		array(
			"Attachment" => 0 //Para realizar o download somente alterar para true
			)
		);
?>


