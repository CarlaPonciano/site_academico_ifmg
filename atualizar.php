<?php

require __DIR__ . '/vendor/autoload.php';

require 'conexao.php';

include 'selecionarSocio.php';

// Atribui o conteúdo do arquivo para variável $arquivo

$associadoArquivo = file_get_contents('data/associado.json');

// Decodifica o formato JSON e retorna um Objeto

$associadoJson = json_decode($associadoArquivo);

$vencimento = "";

$pagamentos = array();

// Loop para percorrer o Objeto

foreach ($associadoJson as $associado) {

    $matricula = $associado->matricula;

    $idAssociado = $associado->idAssociado;

    if(isset($associado->debito)){

        $deb = $associado->debito;

        $debito = explode(';', $deb);

        $qtdDebito = count($debito) * 30;

        $qtdDebito = $qtdDebito - 60;

        //echo "<br>entrou " . $matricula;

    }else{
        $qtdDebito = 0;
    }

    //echo "mat - " . $matricula . " qtddeb - " . $qtdDebito . "<br>";

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

    $sql = "UPDATE `associado` SET `fk_idSituacao` = '" . $sit . "' WHERE `matriculaAAA` = '" . $matricula . "';";

    //echo "<br>" . $sql;

    if (!($con->query($sql))) {

        echo ("Erro <br>");

    }

}

//definir como inadimplente todos os sócios que não tem mensalidade
$sqlSociosSemMensalidade = "SELECT idAssociado FROM associado";

$resultSociosSemMensalidade = $con->query($sqlSociosSemMensalidade);

if ($resultSociosSemMensalidade->num_rows > 0){
  while ($exibirSociosSemMensalidade = $resultSociosSemMensalidade->fetch_assoc()){

    $idAssociado = $exibirSociosSemMensalidade["idAssociado"];

    $sqlMensalidades = "SELECT dataReferenciaInicial FROM mensalidade WHERE fk_idAssociado = " . $idAssociado . ";";

    //echo $sqlMensalidades . "<br>";

    $resultMensalidades = $con->query($sqlMensalidades);

    if ($resultMensalidades->num_rows <= 0){

        $sqlSitInadimplente = "UPDATE associado SET fk_idSituacao = 3 WHERE idAssociado = " . $idAssociado . ";";

        if ($con->query($sqlSitInadimplente) === true) {
        }

    } // fim if mensalidades

  } // fim while socios

} // fim if socios