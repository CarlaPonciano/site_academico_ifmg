<?php
require __DIR__ . '/vendor/autoload.php';
include 'conexao.php';

$idQuitacao = $_GET["idQuitacao"];

$sql = "select * from quitacao WHERE idQuitacao='" . $idQuitacao . "';";
$result = $con->query($sql) or die($con->error);
while ($row = $result->fetch_assoc()) {
    $idAssociado = $row['fk_idAssociado'];
    $valor = $row['valor'];
    $dataPagamento = $row['dataPagamento'];
    $referenciaInicial = $row['dataReferenciaInicial'];
    $referenciaFinal = $row['dataReferenciaFinal'];

    $sql = "update quitacao SET aprovacao ='" . true . "' WHERE idQuitacao='" . $idQuitacao . "';";
    if ($con->query($sql) == true) {
    } else {
        $errMSG = "error while inserting....2";
        echo $errMSG;
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}

$dataReferenciaInicial = DateTime::createFromFormat('Y-m-d', $referenciaInicial);
$dataReferenciaFinal = DateTime::createFromFormat('Y-m-d', $referenciaFinal);

//Cria o intervalo de UM mês
$diff1Month = new DateInterval('P1M');
$minInicial = new DateTime();

//Get a DIFERENÇA entre a data REFERÊNCIA INICIAL E FINAL = quantidade de Meses + (quantidade de ano * 12 meses).
$dteDiff = date_diff($dataReferenciaInicial, $dataReferenciaFinal);
$MDiff = $dteDiff->format('%m');
$y = $dteDiff->format('%y');
$MDiff = $MDiff + (12 * $y);
$meses = $MDiff;

if (!isset($errMSG)) {
    //A CADA MÊS que pretende ser inserido VERIFICAR se já não está cadastrado
    $i = 0;
    $miss = false; //Se HÁ mês pago = true, se NÃO HÁ mês pago = false.
    $return = "";

    while ($i < $meses) {
        $sql = "select dataReferenciaInicial FROM mensalidade WHERE dataReferenciaInicial = '" . $dataReferenciaInicial->format('Y-m-d') . "' and fk_idAssociado = '" . $idAssociado . "';";
        $result = $con->query($sql) or die($con->error);

        if (($result->num_rows > 0)) {
            while ($row = $result->fetch_assoc()) {
                $return .= "" . $MES[$dataReferenciaInicial->format('n')] . "/" . $dataReferenciaInicial->format('y') . " PAGO - ";
                $miss = true;
            }
        }
        $i++;
        $dataReferenciaInicial->add($diff1Month);
    }

    //Se NÃO HÁ mês pago INSERIR o registo de CADA mês
    $i = 0;
    if (!$miss) {

        //retorna aos valores iniciais
        $dataReferenciaInicial = DateTime::createFromFormat('Y-m-d', $referenciaInicial);
        $dataReferenciaFinal = DateTime::createFromFormat('Y-m-d', $referenciaInicial);
        $dataReferenciaFinal->add($diff1Month);

        $v = $valor / $meses;

        while ($i < $meses) {
            $sql = 'INSERT INTO mensalidade(fk_idAssociado,valor, dataPagamento, dataReferenciaInicial, dataReferenciaFinal) VALUES("' . $idAssociado . '","' . $v . '","' . $dataPagamento . '","' . $dataReferenciaInicial->format('Y-m-d') . '","' . $dataReferenciaFinal->format('Y-m-d') . '" );';

            if ($con->query($sql) == true) {
                //echo $dataReferenciaInicial->format('Y-m-d') . "foi" . $dataReferenciaFinal->format('Y-m-d');
            } else {
                $errMSG = "error while inserting....2";
                echo $errMSG;
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }

            $i++;
            $dataReferenciaInicial->add($diff1Month);
            $dataReferenciaFinal->add($diff1Month);
        }
    } else {
        echo"<script language='javascript' type='text/javascript'>alert('" . $return . "');window.location.href='exibirQuitacoes.php';</script>";
        die();
    }

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

    echo "<script language='javascript' type='text/javascript'>alert('Pagamento aprovado com sucesso!');window.location.href='exibirQuitacoes.php';</script>";
    die();
}

mysqli_close($con);

?>

