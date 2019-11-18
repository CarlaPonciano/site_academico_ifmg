<?php
require_once ("conexao.php");

//verifica se foi enviado algum valor
if (isset($_POST["insertDesligamento"])) {

    //recebe os valores enviados pelo formulário
    $matricula = $_POST['matricula'];
    $dataDesligamento = addslashes($_POST['dataDesligamento']);
    $vinculo = addslashes($_POST['vinculo']);
    $obs = addslashes($_POST['obs']);
    $idAssociado = "";

    if (!isset($errMSG)) {
        $sql = "select idAssociado from associado WHERE matriculaAAA='" . $matricula . "';";
        $result = $con->query($sql) or die($con->error);
        while ($row = $result->fetch_assoc()) {
            $idAssociado = $row['idAssociado'];
        }

        $sql = 'INSERT INTO desligamento(fk_idAssociado,dataDesligamento, vinculo, observacao) VALUES("' . $idAssociado . '","' . $dataDesligamento . '","' . $vinculo . '","' . $obs . '");';
        if ($con->query($sql) == true) {
            $sql = "UPDATE associado SET ativo = '" . $vinculo . "' WHERE idAssociado= '" . $idAssociado . "';";
            $result = $con->query($sql) or die($con->error);
            if ($con->query($sql) == true) {
                //include 'selecionarSocio.php';
                //include 'selecionarUsuario.php';
                //include 'selecionarDependente.php';
                echo"<script language='javascript' type='text/javascript'>alert('O vínculo do sócio foi atualizado com sucesso!');window.location.href='exibirSocios.php';</script>";
                die();
            }
        } else {
            echo "<script language='javascript' type='text/javascript'>alert('Erro ao atualizar o vínculo do sócio!');window.location.href='cadastrarDesligamento.php';</script>";
            die();
        }

        //include 'selecionarSocio.php';
        //include 'selecionarUsuario.php';
        //include 'selecionarDependente.php';

        mysqli_close($con);

    } else {
        echo "<script language='javascript' type='text/javascript'>alert('Erro ao atualizar o vínculo do sócio!');window.location.href='cadastrarDesligamento.php';</script>";
        die();
    }
}
?>