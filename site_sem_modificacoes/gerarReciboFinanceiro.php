<?php
require_once __DIR__ . '/vendor/autoload.php';
include 'conexao.php';
$id = $_GET["id"];
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

$sqlFinan = "SELECT TC.despesa, TC.tipo, C.idConta, C.valor, C.mesReferencia, C.dataPagamento, C.dataCadastro, C.observacao
                FROM tipoconta AS TC, conta AS C
                WHERE TC.idTipoConta = C.fk_idTipoConta
                AND C.idConta = " . $id . ";";

$resultFinan = $con->query($sqlFinan);

if ($resultFinan->num_rows > 0) {
    while ($row = $resultFinan->fetch_assoc()) {
        $despesa = $row['despesa'];
        $tipo = $row['tipo'];
        $valor = $row['valor'];
        $valor = str_replace(".", ",", $valor);
        $mesReferencia = $row['mesReferencia'];
        $dataPagamento = date("d/m/Y", strtotime($row['dataPagamento']));
        if ($row['dataPagamento'] == '0000-00-00') {
          $dataPagamento = "";
        }
        $dataCadastro = date("d/m/Y", strtotime($row['dataCadastro']));
        $observacao = $row['observacao'];

        list($ano, $mes, $dia) = explode('-', $mesReferencia);
        $mes = (int) $mes;
        $mesReferencia = $MES[$mes] . "/" . $ano;
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
        <p class="center" >Recibo: <br> nº  ' . $id . '</p>
        </div>
    </div>
    <div class="boxR">
    <h4 style="font-family: arial">' . $tipo  . ' </h4>
    <p style="font-family: arial"> VALOR:  R$' . number_format($valor, 2) . '</p>
    <p style="font-family: arial"> REFERENTE A:  ' . $mesReferencia . '</p>
    </div>
    <div class="boxR">
    <p style="font-family: arial"> DATA: '  . $dataPagamento . '</p>
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
