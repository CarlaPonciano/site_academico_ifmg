<?php

require_once ("conexao.php");

//verifica se foi enviado algum valor
if (isset($_POST["cadastrar"])) {

    //recebe os valores enviados pelo formulário
    $tipo = $_POST['tipo'];
    $valor = $_POST['valor'];
    $mesReferencia = $_POST['mesReferencia'];
    $dataPagamento = $_POST['dataPagamento'];
    $observacao = $_POST['observacao'];
    $dataMesReferencia = $mesReferencia . "-01";
    $valor = str_replace(",", ".", $valor);

    $sqlRenda = "INSERT INTO conta (fk_idTipoConta, valor, mesReferencia, dataPagamento, observacao, dataCadastro) 
                VALUES (" . $tipo . ", " . $valor . ", '" . $dataMesReferencia . "', '" . $dataPagamento . "', '" . $observacao . "', CURRENT_TIME());";

    if ($con->query($sqlRenda) == true) {
        echo "<script language='javascript' type='text/javascript'>alert('Cadastro realizado com sucesso!');window.location.href='exibirHistoricoFinanceiro.php';</script>";
    } else {
        echo"<script language='javascript' type='text/javascript'>alert('Erro ao cadastrar!');</script>";
        echo "Error: " . $sqlRenda . "<br>" . mysqli_error($con);
        die();
    }

    mysqli_close($con);

}

?>

    