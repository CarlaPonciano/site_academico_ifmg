<?php
require __DIR__ . '/vendor/autoload.php';
include 'conexao.php';

$idQuitacao = $_GET["idQuitacao"];

$sql = "DELETE FROM quitacao 
        WHERE idQuitacao='" . $idQuitacao . "';";

if ($con->query($sql) == true) {
    echo "<script language='javascript' type='text/javascript'>alert('Quitação removida com sucesso!');window.location.href='exibirQuitacoes.php';</script>";
    die();
} else {
    echo "<script language='javascript' type='text/javascript'>alert('Não foi possível remover a quitação.');window.location.href='exibirQuitacoes.php';</script>";
    die();
    $errMSG = "error while inserting....2";
    echo $errMSG;
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

mysqli_close($con);

?>