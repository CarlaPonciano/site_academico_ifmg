<?php

require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();
ob_start();


$json = file_get_contents('data/associado.json');
$json_data = json_decode($json);
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

</style>';
echo '</head>';
echo '<body><div class="bor">
                <div class="boxL">
                    <div class="box1">
                    <img src="img/aaalogo.png" width="70" height="35">
                    </div>
                    <div class="box2">
                    <p>Associação dos Aposentados e Pensionistas de Ouro Branco</p>
                    </div>
                </div>
            </div>';
date_default_timezone_set('America/Sao_Paulo');
$today = date('d/m/y');
$diaTd = date("d");
$diaTdW = date("w");
$mesTd = date("n");
$anoTd = date("Y");

$diaTdW = ltrim($diaTdW, '/0');
$d = $diaTdW;
if ($d == 0) {
    $d = 1;
} else {
    if ($d == 1) {
        $d = 0;
    } else {
        $d = - ($d - 1);
    }
}

echo '<h3>Lista de Aniversariantes da Semana - ' . $today . '</h3>';
echo '<h4> de segunda-feira(' . ($diaTd + $d) . ') a domingo(' . ($diaTd + $d + 6) . ') </h4>';

echo '<table id="table" data-toolbar="#toolbar" data-toggle="table" data-sort-name="nasc">';
echo '<thead>';
echo '<tr>';
echo '<th data-field = "nome">NOME</th>';
echo '<th data-field = "nasc">DATA DE NASCIMENTO</th>';
echo '<th data-field = "tele">TELEFONE</th>';
echo '<th data-field = "ende">ENDEREÇO</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

foreach ($json_data as $associado) {
    $situacao = $associado->situacao;
    if ($situacao == 'REGULAR') {
        $dataNascimento = $associado->dataNascimento;
        list($ano, $mes, $dia) = explode("-", $dataNascimento);
        if ($mes == $mesTd) {
            if (($dia >= ($diaTd + $d))and ( $dia <= ($diaTd + $d + 6))) {

                echo '<tr>';
                echo '<td>' . $associado->nome . '</td>';
                echo '<td>' . $dia . "/" . $mes . "/" . $ano . '</td>';
                echo '<td>' . $associado->telefone->TEL . '</td> ';
                echo '<td>' . $associado->endereco . '</td>';
                echo '</tr>';
            }
        }
    }
}

echo '</tbody>';
echo '</table>';
echo '</body>';
echo '</html>';

$html = ob_get_contents();
ob_end_clean();

// send the captured HTML from the output buffer to the mPDF class for processing
$mpdf->WriteHTML($html);
$mpdf->Output();
?>