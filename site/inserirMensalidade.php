<?php
include 'conexao.php';

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
$today->setTimezone(new DateTimeZone('America/Sao_Paulo'));
$today->format('Y\-m\-d');

if (isset($_POST["insertMensalidade"])) {
//recebe os valores enviados pelo formulário
    if($_POST['matricula'] == null) {
        echo"<script language='javascript' type='text/javascript'>alert('ERRO: A matrícula do associado é inválida. Tente novamente.');window.location.href='cadastrarMensalidade.php';</script>";
        die();
    }

    $matricula = $_POST['matricula'];
    $valor = $_POST['valor'];
    $dataPagamento = $_POST['dataPagamento'];
    $referenciaInicial = $_POST['referenciaInicial'];
    $referenciaFinal = $_POST['referenciaFinal'];
    $idAssociado = "";

    $dataReferenciaInicial = DateTime::createFromFormat('Y-m-d', $referenciaInicial . "-15");
    $dataReferenciaFinal = DateTime::createFromFormat('Y-m-d', $referenciaFinal . "-15");

    //Cria o intervalo de UM mês
    $diff1Month = new DateInterval('P1M');

    //ACRESCENTA UM MÊS a refrência final SEMPRE
    $dataReferenciaFinal->add($diff1Month);
    $minInicial = new DateTime();

    //Get a DIFERENÇA entre a data REFERÊNCIA INICIAL E FINAL = quantidade de Meses + (quantidade de ano * 12 meses).
    $dteDiff = date_diff($dataReferenciaInicial, $dataReferenciaFinal);
    $MDiff = $dteDiff->format("%m");
    $y = $dteDiff->format('%y');
    $MDiff = $MDiff + (12 * $y);
    $meses = $MDiff;

    if (!isset($errMSG)) {
        //Get o IDASSOCIADO a partir da matrícula
        $sql = "select idAssociado from associado WHERE matriculaAAA='" . $matricula . "';";
        $result = $con->query($sql) or die($con->error);
        while ($row = $result->fetch_assoc()) {
            $idAssociado = $row['idAssociado'];
        }

        //A CADA MÊS que pretende ser inserido VERIFICAR se já não está cadastrado
        $i = 0;
        $miss = false; //Se HÁ mês pago = true, se NÃO HÁ mês pago = false.
        $return = "";

        while ($i < $meses) {
            $sql = "select dataReferenciaInicial FROM mensalidade WHERE dataReferenciaInicial = '" . $dataReferenciaInicial->format('Y-m-d') . "' and fk_idAssociado = '" . $idAssociado . "';";
            $result = $con->query($sql) or die($con->error);
            if (($result->num_rows > 0)) {
                while ($row = $result->fetch_assoc()) {
                    $return .= "" . $MES[$dataReferenciaInicial->format('n')] . "/" . $dataReferenciaInicial->format('y') . " Já está pago - ";
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
            $dataReferenciaInicial = DateTime::createFromFormat('Y-m-d', $referenciaInicial . "-15");
            $dataReferenciaFinal = DateTime::createFromFormat('Y-m-d', $referenciaInicial . "-15");
            $dataReferenciaFinal->add($diff1Month);
            $v = $valor / $meses;

            while ($i < $meses) {
                $sql = 'INSERT INTO mensalidade(fk_idAssociado,valor, dataPagamento, dataReferenciaInicial, dataReferenciaFinal) VALUES("' . $idAssociado . '","' . $v . '","' . $dataPagamento . '","' . $dataReferenciaInicial->format('Y-m-d') . '","' . $dataReferenciaFinal->format('Y-m-d') . '");';

                if ($con->query($sql) == true) {
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
            echo"<script language='javascript' type='text/javascript'>alert('" . $return . "');window.location.href='cadastrarMensalidade.php';</script>";

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

            $sql = "UPDATE associado SET fk_idSituacao = '" . $sit . "' WHERE matriculaAAA = " . $matricula . ";";

            //echo "<br>" . $sql;

            if (!($con->query($sql))) {

                echo ("Erro <br>");

            }
        }

        include 'selecionarMensalidade.php';

        echo"<script language='javascript' type='text/javascript'>alert('Cadastro de mensalidade realizado com sucesso!');window.location.href='cadastrarMensalidade.php';</script>";
        die();
    }
}

mysqli_close($con);

?>