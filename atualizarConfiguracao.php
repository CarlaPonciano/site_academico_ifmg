<?php

require_once ("conexao.php");
//verifica se foi enviado algum valor
if (isset($_POST["atualizarConfiguracao"])) {
//recebe os valores enviados pelo formulário
    $rotuloRegular = $_POST["rotuloRegular"];
    $diasRegular = $_POST["diasRegular"];
    $rotuloAtraso = $_POST["rotuloAtraso"];
    $diasAtraso = $_POST["diasAtraso"];
    $rotuloInadimplente = $_POST["rotuloInadimplente"];
    $diasInadimplente = $_POST["diasInadimplente"];

    $mensal = $_POST["mensal"];
    $anual = $_POST["anual"];

    if (!isset($errMSG)) {
        $sqlRegular = "UPDATE situacao
                        SET atraso = " . $diasRegular . ", rotulo = '" . $rotuloRegular . "'
                        WHERE idSituacao = 1;"; 

        if ($con->query($sqlRegular) === true) {

            $sqlAtraso = "UPDATE situacao
                        SET atraso = " . $diasAtraso . ", rotulo = '" . $rotuloAtraso . "'
                        WHERE idSituacao = 2;"; 

            if ($con->query($sqlAtraso) === true) {

                $sqlInadimplente = "UPDATE situacao
                        SET atraso = " . $diasInadimplente . ", rotulo = '" . $rotuloInadimplente . "'
                        WHERE idSituacao = 3;"; 

                if ($con->query($sqlInadimplente) === true) {

                    $sqlMensal = "UPDATE valorMensalidade
                        SET valor = " . $mensal . "
                        WHERE idValor = 1;"; 

                    if ($con->query($sqlMensal) === true) {

                        $sqlAnual = "UPDATE valorMensalidade
                        SET valor = " . $anual . "
                        WHERE idValor = 2;"; 

                        if ($con->query($sqlAnual) === true) {

                            $sqlSocios= "SELECT idAssociado FROM associado";

                            $resultSocios = $con->query($sqlSocios);

                            if ($resultSocios->num_rows > 0){
                              while ($exibirSocios = $resultSocios->fetch_assoc()){

                                $idAssociado = $exibirSocios["idAssociado"];

                                $sqlMensalidades = "SELECT dataReferenciaInicial FROM mensalidade WHERE fk_idAssociado = " . $idAssociado . ";";

                                //echo $sqlMensalidades . "<br>";

                                $resultMensalidades = $con->query($sqlMensalidades);

                                if ($resultMensalidades->num_rows <= 0){ // socio sem mensalidades é inadimplente

                                    $sqlSitInadimplente = "UPDATE associado SET fk_idSituacao = 3 WHERE idAssociado = " . $idAssociado . ";";

                                    if ($con->query($sqlSitInadimplente) === true) {
                                    }

                                } // fim if mensalidades

                                else{ // se tiver mensalidades, atualizar a situação

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

                                        $sql = "UPDATE associado SET fk_idSituacao = '" . $sit . "' WHERE idAssociado = " . $idAssociado . ";";

                                        //echo "<br>" . $sql;

                                        if (!($con->query($sql))) {

                                            echo ("Erro <br>");

                                        }
                                    }

                                }

                              } // fim while socios

                            } // fim if socios

                            echo"<script language='javascript' type='text/javascript'>alert('Configurações atualizadas com sucesso!');window.location.href='configurarSistema.php';</script>";

                        }else{
                            echo "Error: " . $sqlAnual . "<br>" . mysqli_error($con);
                        }

                    }else{
                        echo "Error: " . $sqlMensal . "<br>" . mysqli_error($con);
                    }

                }else{
                    echo "Error: " . $sqlInadimplente . "<br>" . mysqli_error($con);
                }

            }else{
                echo "Error: " . $sqlAtraso . "<br>" . mysqli_error($con);
            }

        }else{
            echo "Error: " . $sqlRegular . "<br>" . mysqli_error($con);

            echo"<script language='javascript' type='text/javascript'>alert('Erro ao atualizar!');window.location.href='configurarSistema.php';</script>";
        }
    }

    mysqli_close($con);
}
?>
    