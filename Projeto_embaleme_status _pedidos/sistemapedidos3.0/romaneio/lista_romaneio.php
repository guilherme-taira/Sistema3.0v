<?php
session_start();

$rota = $_REQUEST['rota'];
$data = $_REQUEST['data'];
include_once '../teste/conexao_pdo.php';
$statement = $pdo->query("SELECT *, nome  FROM `codigo` inner join colaborador on codigo.colaborador = colaborador.id where Tipo = '{$rota}' and datas like '%{$data}%'");
$dados = $statement->fetchAll(PDO::FETCH_ASSOC);
$i = 1;

// INSTANCIA DO OBJETO GERA PDF ROMANEIO
use Dompdf\Dompdf;
// ADICIONA O AUTOLOAD DA CLASSE
require_once 'dompdf/autoload.inc.php';

$pdf = new Dompdf();
$html = '<table border=1>';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th style="font-size: 20px">Número</th>';
$html .= '<th style="font-size: 20px">Código</th>';
$html .= '<th style="font-size: 20px">Colaborador</th>';
$html .= '<th style="font-size: 20px">Data</th>';
$html .= '<th style="font-size: 20px">Peso Tray</th>';
$html .= '<th style="font-size: 20px">Peso Loja</th>';
$html .= '<th style="font-size: 20px">Divergência Peso</th>';
$html .= '<th style="font-size: 20px">Tipo</th>';
$html .= '</tr>';
$html .= '</thead>';

if($_REQUEST['rota'] == 'M'){
  $Tipo = "Mandaê";
}else if($_REQUEST['rota'] == 'ML'){
  $Tipo = "Mercado Livre";
}else if($_REQUEST['rota'] == 'C'){
  $Tipo = "Corrêio";
}else if($_REQUEST['rota'] == 'U'){
  $Tipo = "Uello";
}else if($_REQUEST['rota'] == 'SH'){
  $Tipo = "Shopee";
}

foreach($dados as $row) {
  $html .= '<tbody>';
  $html .=  '<tr><td style="font-size: 15pxpx">'.$i++ .   "</td>";
  $html .= '<td style="font-size: 15px">'.$row["cod"].  "</td>";
  $html .= '<td style="font-size: 15px">'.$row["nome"]. "</td>";
  $html .= '<td style="font-size: 15px">'.$row["datas"]."</td>";
  $html .= '<td style="font-size: 15px">'.$row["peso"] . "</td>";
  $html .= '<td style="font-size: 15px">'.$row["peso_loja"].'</td>';
  $html .= '<td style="font-size: 15px">'.$row["divergencia_peso"]."</td>";
  $html .= '<td style="font-size: 15px">'.$Tipo."</td>";
  $html .= '</tbody>';
  $total = $i -1;
}
$html .= '</table>';

 
$pdf->loadHtml('
  <h1 style="text-align:center;"> Romaneio De Caixas</h1><br>
  <h4 style="text-align:center;">Embaleme Comércio de Embalagens e Festas</h4>
  <div style="padding:10px"><img src="Embalemelogo.png" alt="" width="100px"/>
  <br><br><br><hr>
  <b>Leme: '.date('Y-m-d : H:i:s'). ' Total:'. $total.' Assinatura: _____________________________________________ </b> <br><br>
  <b>Placa do Veículo: ___________________________________ </b> <br> <hr>
  '.$html.'</div>'
);

// RENDERIZA O PDF
$pdf->render();
echo $pdf->stream(
  "relatorioRomaneio.pdf", // nome do arquivo gerado
  array(
    "Attachment" => false,
  )
);

// http://localhost/dashboard/embaleme_sistema/teste/SistemaNovo/sistema_pedidos_v2.0/romaneio/lista_romaneio.php?rota=M&data=2021-10-08
?>

