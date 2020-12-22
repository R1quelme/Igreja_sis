<?php 
use Mpdf\Mpdf;

require_once __DIR__ . '/mpdf/autoload.php';
require_once 'conexoes/conexao.php';
require_once 'conexoes/login.php';
$agora = new DateTime();

$mpdf = new Mpdf();

$objetorecebido = json_decode($_POST['table']);
	// echo '<pre>';
    // var_dump($_POST);
    
// for ($i=0; $i < count($array); $i++) { 
//     $array[$i][] 
// }


$linhasParaRelatorio = "";
foreach ($objetorecebido as $a){

    $cor = '';
    if($a->situacao == "<span class='badge badge-pill badge-info' style='height: 19px; width: 90px; font-size: 98%';>Requerido</span>"){
        $cor = "class='situacaoRequerido'";
    } else if($a->situacao == "<span class='badge badge-pill badge-success' style='height: 19px; width: 90px; font-size: 98%';>Deferido</span>"){
        $cor = "class='situacaoDeferido'";
    } else{
        $cor = "class='situacaoIndeferidoCancelado'";
    }
    // $a->situacao = html_entity_decode($a->situacao);
    $linhasParaRelatorio .= 
    "<tr>
        <td>{$a->nome}</td>
        <td>{$a->endereco}</td>
        <td>{$a->solicitacao}</td>
        <td>{$a->observacao}</td>
        <td ".$cor."><b>{$a->situacao}</b></td>
        <td>{$a->criado}</td>
    </tr>";
}                                                                                                                                                                                                                                                                                               

$html = "
    <table class='table_export'>
        <thead>
            <tr>
                <td><b>Nome</b></td>
                <td><b>Endereço</b></td>
                <td><b>Tipo de solicitação</b></td>
                <td><b>Observação</b></td>
                <td><b>Situação</b></td>
                <td><b>Criado</b></td>
            </tr>
        </thead>
        <tbody>
            $linhasParaRelatorio
        </tbody>
    </table>
";

$htmlHeader = '
<div style="text-align:right;">&copy; Sistema SIB</div>';

$htmlConteudo = '
<fieldset class="body">
<header class="cabecalho">
    <div class="header">
        <table>
            <tr class="linha">
                <td class="tdHeader"><img src="logo_batista.jpg" class="logo"></td>
                <td align="center"><h2>Segunda Igreja Batista</h2>
                <p>Rua Acre, 203 - Santa Luzia</p>
                <p>PASSOS/MG - BRASIL - CEP 164000-503 / Telefone: (00) 00000-0000</p>
                </td>
            </tr>
        </table>
    </div>
</header><hr>';

$htmlConteudo .= '
<h2>
<div class="grifar">Relatório de solicitações</div>
<h2><br>
'.$html.'';

$htmlFooter = 
'<footer id="rodape"><hr>
<div class="boxleft"> 
    <p>Data da impressão: '.$agora->format('d/m/Y H:i').' </p>
    <p>Emissor: '. $_SESSION['nome_igreja'] .' </p>      
</div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              				</div>
<div class="box">
    <p style="color: #696969">&copy; Sistema SIB Desenvolvido por Matheus Riquelme</p>
<div>
<div style="text-align:right;">Página {PAGENO} de {nbpg}</div>.
</footer>
</fieldset>';


$css = file_get_contents('assets/css/personalizarPDF.css');
$mpdf->SetHTMLHeader($htmlHeader);
$mpdf->SetHTMLFooter($htmlFooter);
$mpdf->WriteHTML($css, 1);
$mpdf->WriteHTML($htmlConteudo);

$data = md5($agora->format('d/m/Y H:i:s'));
ob_start();
$nomeCaminho = "DowloadsMPDF/relatorio de solicitacoes_$data.pdf";
$mpdf->Output($nomeCaminho, "F");
ob_clean();
// $mpdf->Output('relatorioSib.pdf', "I");
echo json_encode(['url' => $nomeCaminho]);



