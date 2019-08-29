<?php
require_once __DIR__ . '/vendor/autoload.php';
include 'conexao.php';

if (isset($_POST["emitir"])) {

//recebe os valores enviados pelo formulário

    $nomeAssinatura = ucwords($_POST['nome']);
    $matricula = $_GET["matricula"];

    $mpdf = new \Mpdf\Mpdf();
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

    .box1 {
      display: inline-block;
      float: left;
      width: 150px;
      height: 50px;
      margin: 1em;
    }
    .box2 {
      display: inline-block;
      float: left;
      width: 500px;
      height: 100px;
      margin: 1em;
    }
    .box3 {
        background-color: #e5e5e5;
        text-align: center;
        padding: 7px 0px 0px 0px;
        height: 30px;
    }
    footer {
        background-color: #e5e5e5;
        padding: 10px;
        text-align: center;
    }
    </style>';
    echo '</head>';
    echo '<body>';
    $sql = "SELECT u.nome, p.parentesco FROM usuario as u, dependente as d, associado as a, parentesco as p WHERE u.idUsuario = d.fk_idUsuario and d.fk_idAssociado = a.idAssociado and a.matriculaAAA = " . $matricula . " and p.idParentesco = d.fk_idParentesco";
    $resulta = $con->query($sql);
    $dependentes = array();
    if ($resulta->num_rows > 0) {
        // output data of each row
        while ($rows = $resulta->fetch_assoc()) {
            $dependentes[] = array(ucwords($rows["nome"]), $rows["parentesco"]);
        }
    }
    $sql = "SELECT u.nome, m.dataReferenciaFinal FROM mensalidade as m INNER JOIN associado as a ON m.fk_idAssociado = a.idAssociado INNER JOIN usuario as u ON a.fk_idUsuario = u.idUsuario WHERE a.matriculaAAA = " . $matricula . " AND a.fk_idSituacao = 1;";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $socio = ucwords($row['nome']);
            $vencimento = $row['dataReferenciaFinal'];
            list($anoV, $mesV, $diaV) = explode("-", $vencimento);
        }
    }else{
        echo"<script language='javascript' type='text/javascript'>alert('ERRO: O(a) associado(a) não realizou nenhum pagamento de mensalidade até o momento.');window.location.href='consultarSocio.php';</script>";
        die();
    }
    $mesV = ltrim($mesV, '0');
    echo '
    <header><div class="box1"><img alt="Brand" src="img/aaalogo.png" width="200px"></div>
                        <div class="box2"><h4>ASSOCIAÇÃO DOS APOSENTADOS E PENSIONISTAS<br> DE OURO BRANCO
                        </h4> <div class="box3"><p>FUNDADA EM 19/04/1991</p></div></div>
    </header>';
    echo '<section><h3 align="center">Declaração</h3>';
    echo '<br>';
    echo '<br>';
    echo '<p align="justify"> Declaramos para os devidos fins que o(a) senhor(a) ' . $socio . ' é associado(a) desta Entidade, inscrito(a) sob o n° de '
     . 'matrícula ' . $matricula . ', estando em dia com suas mensalidades'
     . ' até o dia ' . $diaV . ' de ' . $MES[$mesV] . ' de ' . $anoV;
    if (count($dependentes) > 0) {
        echo ', e possui os seguintes dependentes:</p>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<table id="table" data-toolbar="#toolbar" data-toggle="table" data-sort-name="nasc">';
        echo '<thead>';
        echo '<tr>';
        echo '<th data-field = "nome">Nome</th>';
        echo '<th data-field = "nasc">Parentesco</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($dependentes as $dep) {
            echo '<tr>';
            echo '<td>' . $dep[0] . '</td>';
            echo '<td>' . $dep[1] . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '.</p>';
    }
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<p> Ouro Branco, ' . $dia . ' de ' . $MES[$mes] . ' de ' . $ano . '.  </p>';
    echo '<br>';
    echo '______________________________';
    echo '<br>';
    echo '<p> ' . $nomeAssinatura . '  </p>';
    echo '<p> Tesouraria AAA  </p>';
    echo '<br></section>';
    echo '<footer  class="footer navbar-fixed-bottom"><p>Rua José Joaquim Queiroz Junior, 21 - B. Pioneiros - Ouro Branco - MG - CEP 36420-000 <br> Telefone (31)3742-3639  - Email: aaa.ob@viareal.com.br</p></footer>';
    echo '</body>';
    echo '</html>';

    $html = ob_get_contents();
    ob_end_clean();

    // send the captured HTML from the output buffer to the mPDF class for processing
    $mpdf->WriteHTML($html);
    $mpdf->Output();
}    
?>
/* 
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

