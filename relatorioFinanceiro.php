<?php
include 'conexao.php';
require_once __DIR__ . '/vendor/autoload.php';

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
$today = new DateTime();

$total = 0;

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'utf-8', 'format' => [210, 297],
    'margin_top' => 5,
    'margin_left' => 5,
    'margin_right' => 0,
    font => 'Arial']);
ob_start();

$today->setTimezone(new DateTimeZone('America/Sao_Paulo'));

$today->format('Y\-m\-d');

$html = "<!DOCTYPE html>";

$html .= "<html>";
$html .= "<head>";

$html .= "<link href='https://fonts.googleapis.com/css?family=Lora|Raleway' rel='stylesheet'>";

$html .= '<script src="vendor/components/jquery/jquery.min.js" type="text/javascript"></script>';
$html .= '<script src="vendor/twitter/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>';
$html .= '<script src="vendor/wenzhixin/bootstrap-table/src/bootstrap-table.js" type="text/javascript"></script>';

$html .= '<link href="vendor/wenzhixin/bootstrap-table/src/bootstrap-table.css" rel="stylesheet" type="text/css"/>';
$html .= '<link href="vendor/twitter/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>';
$html .= '<style>
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

$html .= '</head>
<body>
<div class="bor">
    <div class="boxL">
        <div class="box1">
        <img src="img/aaalogo.png" width="70" height="35">
        </div>
        <div class="box2">
        <p>Associação dos Aposentados e Pensionistas de Ouro Branco</p>
        </div>
    </div>
</div>';

if (isset($_POST["emitirRelatorio"])) {
//recebe os valores enviados pelo formulário
    $referenciaInicial = $_POST['referenciaInicialFinanceiro'];
    $referenciaFinal = $_POST['referenciaFinalFinanceiro'];
    $dReferenciaInicial = DateTime::createFromFormat('Y-m-d', $referenciaInicial . "-01");
    $dReferenciaFinal = DateTime::createFromFormat('Y-m-d', $referenciaFinal . "-01");

    //Cria o intervalo de UM mês
    $diff1Month = new DateInterval('P1M');

    //ACRESCENTA UM MÊS a refrência final SEMPRE
    $dReferenciaFinal->add($diff1Month);

    $html .= '<h3>Relatório de Mensalidades Recebidas</h3><table class="table table-hover table-responsive">
        <tr> <th>Matrícula</th> <th>CPF</th> <th>Nome</th> <th>Data do Pagamento</th> <th>Mês de Referência</th> <th>Vencimento</th> <th>Valor</th> </tr>';

    $sql = "SELECT nome, cpf, matriculaAAA, idMensalidade, valor, dataPagamento, dataReferenciaInicial, dataReferenciaFinal 
              FROM mensalidade 
              JOIN associado ON fk_idAssociado = idAssociado 
              JOIN usuario ON fk_idUsuario = idUsuario 
              WHERE dataPagamento BETWEEN '" . $dReferenciaInicial->format('Y-m-d') . "' 
              AND '" . $dReferenciaFinal->format('Y-m-d') . "';";

    //echo $sql;

    $result = $con->query($sql);

    $var = "[";

    $i = 0;

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            $nome = ucwords($row['nome']);

            $cpf = $row['cpf'];

            $matricula = $row['matriculaAAA'];

            $idMensalidade = $row['idMensalidade'];

            $valor = $row['valor'];
            $valor = number_format($valor,2);//formata o número com duas casas decimais
            $valorExibido = str_replace(".", ",", $valor);

            $dataPagamento = $row['dataPagamento'];

            $dataReferenciaInicial = $row['dataReferenciaInicial'];

            $dataReferenciaFinal = $row['dataReferenciaFinal'];

            date_default_timezone_set('America/Sao_Paulo');

            $today = date("Y-m-d");

            $diaTd = date("d");

            $mesTd = date("n");

            $anoTd = date("Y");

            list($anoI, $mesI, $diaI) = explode('-', $dataReferenciaInicial);

            $mesI = (int) $mesI;

            $anoI = (int) $anoI;

            list($anoV, $mesV, $diaV) = explode('-', $dataReferenciaFinal);

            $mesV = (int) $mesV;

            $anoV = (int) $anoV;

            //descobre quantos meses foram pagos nesse cadastro

            $diff = date_diff(date_create($dataReferenciaFinal), date_create($dataReferenciaInicial));

            //dá nome aos meses pagos

            if ($diff->format("%m") == "1") {

                $mesesReferencia = $MES[$mesI] . "/" . $anoI;

            } else {

                $date = date_create($dataReferenciaFinal);

                date_sub($date, date_interval_create_from_date_string("1 month"));

                $mesesReferencia = $MES[$mesI] . "/" . $anoI . " a " . $MES[$date->format("n")] . "/" . $date->format("Y");

            }

            // Descobre que dia é hoje e retorna a unix timestamp

            $hoje = mktime(0, 0, 0, $mesTd, $diaTd, $anoTd);

            // Descobre a unix timestamp da data de nascimento do fulano

            $vencimento = mktime(0, 0, 0, $mesV, $diaV, $anoV);

            $vencimento = $diaV . "/" . $mesV . "/" . $anoV;//transforma date em string

            list($anoP, $mesP, $diaP) = explode('-', $dataPagamento);

            $dataPagamento = $diaP . "/" . $mesP . "/" . $anoP;//transforma date em string

            $valor = number_format($valor,2);//formata o número com duas casas decimais

            $html .= '<tr>

            <td>' . $matricula . '</td>
            <td>' . $cpf . '</td>
            <td>' . $nome . '</td>
            <td>' . $dataPagamento . '</td>
            <td>' . ucwords($mesesReferencia) . '</td>
            <td>' . $vencimento . '</td>
            <td><span style="color: green;">R$ ' . $valorExibido . '</span></td>

            </tr>';

            $total += $valor;

        } // while
    } // if

    $html .= '</table>';

    $html .= '<h3>Relatório Financeiro</h3><table class="table table-hover table-responsive">
        <tr> <th></th> <th>Mês de Referência</th> <th>Data do Recebimento/Pagamento</th> <th>Valor</th> </tr>';

    $sqlFinan = "SELECT TC.despesa, TC.tipo, C.idConta, C.valor, C.mesReferencia, C.dataPagamento
                    FROM tipoconta AS TC, conta AS C
                    WHERE TC.idTipoConta = C.fk_idTipoConta
                    AND C.mesReferencia >= '" . $dReferenciaInicial->format('Y-m-d') . "' 
                    AND C.mesReferencia <= '" . $dReferenciaFinal->format('Y-m-d') . "'
                    ORDER BY TC.despesa;";

    $resultFinan = $con->query($sqlFinan);

    if ($resultFinan->num_rows > 0) {
        while ($row = $resultFinan->fetch_assoc()) {
            $idConta = $row['idConta'];
            $despesa = $row['despesa'];
            $tipo = $row['tipo'];
            $valor = $row['valor'];
            $valorExibido = str_replace(".", ",", $valor);
            $mesReferencia = $row['mesReferencia'];
            $dataPagamento = date("d/m/Y", strtotime($row['dataPagamento']));
            if ($row['dataPagamento'] == '0000-00-00') {
                $dataPagamento = "";
            }

            list($ano, $mes, $dia) = explode('-', $mesReferencia);
            $mes = (int) $mes;
            $mesReferencia = $MES[$mes] . "/" . $ano;

            $html .= '<tr>

            <td>' . $tipo . '</td>
            <td>' . ucwords($mesReferencia) . '</td>
            <td>' . $dataPagamento . '</td>';
            if ($despesa == 0) {
              $html .= '<td><span style="color: green;">R$ ' . $valorExibido . '</span></td>';
            }else{
              $html .= '<td><span style="color: red;">- R$ ' . $valorExibido . '</span></td>';
            }

            $html .= '</tr>';

            if ($despesa == 0)  {
              $total += $valor;
            }else{
              $total -= $valor;
            }

        } // while
    } // if

    $total = number_format($total,2);//formata o número com duas casas decimais

    $html .= '</table>

              <div class="bor"></div><h4>VALOR TOTAL: R$ ' . str_replace(".", ",", $total) . '</h4>';

}

//define o modo do display
$mpdf->SetDisplayMode('fullpage');
//define o arquivo css para formatar a saída
$css = file_get_contents("css/");
//escreve o css no html
$mpdf->WriteHTML($css,1);
//cria o html para pdf
$mpdf->WriteHTML($html);
//método para gerar o arquivo pdf
$mpdf->Output();
//sai do bloco de script
//exit;

mysqli_close($con);

?>