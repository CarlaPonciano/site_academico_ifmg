<?php
require_once __DIR__ . '/vendor/autoload.php';
include 'conexao.php';
$idMensalidade = $_GET["idMensalidade"];
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'utf-8', 'format' => [210, 297],
    'margin_top' => 5,
    'margin_left' => 5,
    'margin_right' => 0,
    font => 'Arial']);
ob_start();
date_default_timezone_set('America/Sao_Paulo');
$today = date("d-n-Y");
list($dia, $mes, $ano) = explode("-", $today);

$MES[1] = "janeiro";
$MES[2] = "fevereiro";
$MES[3] = "março";
$MES[4] = "abril";
$MES[5] = "maio";
$MES[6] = "junho";
$MES[7] = "julho";
$MES[8] = "agosto";
$MES[9] = "setembro";
$MES[10] = "outubro";
$MES[11] = "novembro";
$MES[12] = "dezembro";

$json = file_get_contents('data/associado.json');
$json_data = json_decode($json);


$sql = "select u.nome, m.dataReferenciaInicial, m.dataReferenciaFinal, m.valor, m.dataPagamento, m.idMensalidade, a.matriculaAAA "
        . "FROM mensalidade as m INNER JOIN associado as a ON m.fk_idAssociado = a.idAssociado "
        . "INNER JOIN usuario as u ON a.fk_idUsuario = u.idUsuario WHERE m.idMensalidade =" . $idMensalidade . ";";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $socio = ucwords($row['nome']);
        $dataReferenciaFinal = $row['dataReferenciaFinal'];
        list($anoV, $mesV, $diaV) = explode("-", $dataReferenciaFinal);
        $dataReferenciaInicial = $row['dataReferenciaInicial'];
        list($anoI, $mesI, $diaI) = explode("-", $dataReferenciaInicial);
        $mesI = ltrim($mesI, "0");

        $diff = date_diff(date_create($dataReferenciaFinal), date_create($dataReferenciaInicial));

        if ($diff->format("%m") == "1") {
            $mesesReferencia = $MES[$mesI] . "/" . $anoI;
        } else {
            $date = date_create($dataReferenciaFinal);
            date_sub($date, date_interval_create_from_date_string("1 month"));
            $mesesReferencia = $MES[$mesI] . "/" . $anoI . " a " . $MES[$date->format("n")] . "/" . $date->format("Y");
        }
        $dataPagamento = $row['dataPagamento'];
        list($anoP, $mesP, $diaP) = explode("-", $dataPagamento);
        $valor = $row['valor'];
        $idMensalidade = $row['idMensalidade'];
        $matricula = $row['matriculaAAA'];
    }
}

echo "<!DOCTYPE html>";

echo"<html>";
echo"<head>";

echo"<link href='https://fonts.googleapis.com/css?family=Lora|Raleway' rel='stylesheet'>";

echo '<script src="vendor/components/jquery/jquery.min.js" type="text/javascript"></script>';
echo '<script src="vendor/twitter/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>';
echo '<script src="vendor/wenzhixin/bootstrap-table/src/bootstrap-table.js" type="text/javascript"></script>';

echo '<link href="vendor/wenzhixin/bootstrap-table/src/bootstrap-table.css" rel="stylesheet" type="text/css"/>';
echo '<link href="vendor/twitter/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>';
echo '<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

.boxL {
  float: left;
  width: 275px;
  height: 50px;
  padding: 1px 1px 1px 1px;
  border:
}
.box1 {
  float: left;
  width: 70px;
  height: 50px;
  padding: 1px 1px 1px 1px;
}
.box2 {
  float: left;
  width: 200px;
  height: 50px;
  padding: 1px 1px 1px 1px;
}
.box3 {
  background-color: #e5e5e5;
  float: left;
  width: 80px;
  height: 50px;
  margin-right:5px;
  margin-left:5px;
  padding-top:5px;
  text-align: center;
  border-radius: 5px;
}
.boxR {
  float: left;
  width: 240px;
  height: 120px;
  margin-top: 10px;
  padding-left: 4px;
  border-left: 1px solid #3f3f3f;
}
.bor {
  margin-bottom: 10px;
  border-bottom: 1px dashed #3f3f3f;
}
.center {
text-align: center;
}
</style>';


echo '</head>
<body>
<div class="bor">
    <div class="boxL">
        <div class="box1">
        <img src="img/aaalogo.png" width="70" height="35">
        </div>
        <div class="box2">
        <p>Associação dos Aposentados e Pensionistas de Ouro Branco</p>
        </div>
        <div class="box3">
        <p class="center" >Recibo: <br> nº  ' . $idMensalidade . '</p>
        </div>
        <div class="box3">
        <p class="center" >Matrícula: <br> nº   ' . $matricula . '</p>
        </div>
    </div>
    <div class="boxR">
    <p style="font-family: arial"> TITULAR:  ' . $socio . ' </p>
    <p style="font-family: arial"> VALOR PAGO:  R$' . number_format($valor, 2) . '</p>
    <p style="font-family: arial"> REFERENTE A:  ' . $mesesReferencia . '</p>
    </div>
    <div class="boxR">
    <p style="font-family: arial" >VALIDADE: '  . $diaV . '/' . $mesV . '/' . $anoV . '</p>
    <p style="font-family: arial"> DATA: '  . $diaP . '/' . $mesP . '/' . $anoP . '</p>
    <p class="center" style="font-family: arial">  _________________________________<br>DPTO. FINANCEIRO</p>
    </div>
</div>

</body>
</html>';

$html = ob_get_contents();
ob_end_clean();

// send the captured HTML from the output buffer to the mPDF class for processing
$mpdf->WriteHTML($html);
$mpdf->Output();
?>
