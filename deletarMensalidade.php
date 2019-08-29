<?php

require __DIR__ . '/vendor/autoload.php';
require 'conexao.php';

$idMensalidade = $_GET["idMensalidade"];
$idAssociado = $_GET["idAssociado"];

$sql = "DELETE FROM mensalidade WHERE idMensalidade='" . $idMensalidade . "';";

$result = $con->query($sql);

if ($con->query($sql) === true) {

	// atualizar situacao

    $diff1Month = new DateInterval('P1M');
    $today = new DateTime();
    $today->setTimezone(new DateTimeZone('America/Sao_Paulo'));
    $today->format('Y\-m\-d');

    $minInicial = new DateTime();
    $minInicial->setTimezone(new DateTimeZone('America/Sao_Paulo'));
    $minInicial->format('Y\-m\-d');

    //Seleciona o primeiro mês de pagamento da mensalidade.

    $sqlMes1Pgto = "SELECT MIN(dataReferenciaInicial), dataReferenciaFinal 
                FROM mensalidade 
                WHERE fk_idAssociado = '" . $idAssociado . "';";

    $res = $con->query($sqlMes1Pgto) or die($con->error);

    if ($res->num_rows > 0) {
        while ($r = $res->fetch_assoc()) {
            if (!is_null($r['MIN(dataReferenciaInicial)'])) {
                $minInicial = DateTime::createFromFormat('Y-m-d', $r['MIN(dataReferenciaInicial)']);
            }
        }
    }

    $miss = false;
    $return = array();

    $interval = $today->diff($minInicial);
    $d = $interval->format('%m');
    $y = $interval->format('%y');
    $d = $d + (12 * $y);

    //Seleciona os meses NÃO pagos até a data atual.

    while ($d > 0) {
        $sqlMesesNaoPg = "SELECT dataReferenciaInicial 
                    FROM mensalidade 
                    WHERE dataReferenciaInicial = '" . $minInicial->format("Y-m-d") . "' 
                    AND fk_idAssociado = '" . $idAssociado . "';";

        $res = $con->query($sqlMesesNaoPg) or die($con->error);

        if ($res->num_rows > 0) {

        } else {

            $return[] = $minInicial->format("n") . "-" . $minInicial->format("Y") . ";";

        }

        $minInicial = $minInicial->add($diff1Month);

        $d--;
    }

    if(isset($return)){

        $debito = "";

        if (count($return) > 0) {

            foreach ($return as $value) {
                $debito .= $value;
            }
            $debito .= '"';
        } else {
            $debito = "";
        }

        $debito = explode(';', $debito);

        $qtdDebito = count($debito) * 30;

        $qtdDebito = $qtdDebito - 60;

        $result = $con->query("SELECT s.rotulo, s.atraso FROM situacao AS s; ");

        $situacao = array();

        while ($row = $result->fetch_assoc()) {

            $situacao[] = $row;

        }

        //echo "<script language='javascript' type='text/javascript'>alert('" . $matricula . " - " . $qtdDebito . "');</script>";

        $emdia = (int) $situacao[0]["atraso"];

        $atrasado = (int) $situacao[1]["atraso"];

        $inadimplente = (int) $situacao[2]["atraso"];

        if ($qtdDebito < $atrasado) {

            //echo $qtdDebito . " " . $atrasado;

            $sit = 1;

            //echo $situacao[0]["rotulo"]."<br>";

        }

        if (($qtdDebito >= $atrasado) && ($qtdDebito < $inadimplente)) {

            $sit = 2;

            //echo $situacao[1]["rotulo"]."<br>";

        }

        if ($qtdDebito >= $inadimplente) {

            $sit = 3;

            // echo $situacao[2]["rotulo"]."<br>";

        }

        $sql = "UPDATE associado SET fk_idSituacao = '" . $sit . "' WHERE idAssociado= " . $idAssociado . ";";

        //echo "<br>" . $sql;

        if (!($con->query($sql))) {

            echo ("Erro <br>");

        }
    }
    echo "<script language='javascript' type='text/javascript'>alert('Mensalidade excluída com sucesso!');window.location.href='exibirMensalidades.php';</script>";
    die();
} else {
    echo"<script language='javascript' type='text/javascript'>alert('Não foi possivel excluir a mensalidade.');window.location.href='exibirMensalidades.php';</script>";
    die();
}

?>

