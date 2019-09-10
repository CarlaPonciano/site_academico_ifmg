<?php

require_once ("conexao.php");

//verifica se foi enviado algum valor
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
        echo"<script language='javascript' type='text/javascript'>alert('ERRO: A matrícula do associado é inválida. Tente novamente.');window.location.href='cadastrarQuitacao.php';</script>";
        die();
    }

    $matricula = $_POST['matricula'];
    $valor = $_POST['valor'];
    $dataPagamento = $_POST['dataPagamento'];
    $referenciaInicial = $_POST['referenciaInicial'];
    $referenciaFinal = $_POST['referenciaFinal'];
    $observacao = addslashes($_POST['obs']);

    //CRIA DATETIME com os dados de type=month para referencia Inicial e Final
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
                    $return .= "" . $MES[$dataReferenciaInicial->format('n')] . "/" . $dataReferenciaInicial->format('y') . " PAGO - ";
                    $miss = true;
                }

            }

            $i++;

            $dataReferenciaInicial->add($diff1Month);
        }

        if (!$miss) {

            //retorna aos valores iniciais
            $dataReferenciaInicial = DateTime::createFromFormat('Y-m-d', $referenciaInicial . "-15");
            $dataReferenciaFinal = DateTime::createFromFormat('Y-m-d', $referenciaFinal . "-15");
            $dataReferenciaFinal->add($diff1Month);

            $sql = 'INSERT INTO quitacao(fk_idAssociado,valor, dataPagamento, dataReferenciaInicial, dataReferenciaFinal, observacao, aprovacao) VALUES("' . $idAssociado . '","' . $valor . '","' . $dataPagamento . '","' . $dataReferenciaInicial->format('Y-m-d') . '","' . $dataReferenciaFinal->format('Y-m-d') . '","' . $observacao . '" ,"' . false . '" );';

            if ($con->query($sql) == true) {
                //echo $dataReferenciaInicial->format('Y-m-d') . "foi" . $dataReferenciaFinal->format('Y-m-d');
            } else {
                $errMSG = "error while inserting....2";
                echo $errMSG;
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }
        } else {
            echo $return;
            echo"<script language='javascript' type='text/javascript'>alert('" . $return . "');window.location.href='cadastrarQuitacao.php';</script>";
            die();
        }

        echo"<script language='javascript' type='text/javascript'>alert('Quitação realizada com sucesso. Aguarde aprovação.');window.location.href='exibirQuitacoes.php';</script>";
        die();
    }
}

mysqli_close($con);

?>