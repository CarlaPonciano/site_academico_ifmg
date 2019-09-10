<?php

require_once ("conexao.php");

//verifica se foi enviado algum valor
if (isset($_POST["atualizarDependente"])) {
//recebe os valores enviados pelo formulário
    $idDependente = $_GET["idDependente"];
    $matricula = $_GET["matricula"];
    $nome = addslashes(strtolower($_POST['nome']));
    $cpf = addslashes($_POST['cpf']);
    $dataNascimento = addslashes($_POST['dataNascimento']);
    $genero = addslashes($_POST['genero']);
    $telefone = addslashes($_POST['telefone']);
    $telefone2 = addslashes($_POST['telefone2']);
    $email = addslashes(strtolower($_POST['email']));
    $parentesco = $_POST['parentesco'];
    $agregado = $_POST['agregado'];

    //>> Verifica se já não há usuário com o cpf ou número de matrícula

    if (!isset($errMSG)) {

        $sql = "SELECT fk_idUsuario FROM dependente WHERE idDependente = '" . $idDependente . "'";

        $result = $con->query($sql) or die($con->error);

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $idUsuario = $row['fk_idUsuario'];

            }

            $sql = "SELECT nome, cpf FROM usuario WHERE usuario.cpf = '" . $cpf . "' AND idUsuario != '" . $idUsuario . "';";

            $result = $con->query($sql) or die($con->error);

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                    echo"<script language='javascript' type='text/javascript'>alert('O CPF digitado já está cadastrado com o usuário " . ucwords($row['nome']) . ".');window.location.href='editarDependente.php?id=" . $idDependente . "&matricula=" . $matricula . "';</script>";

                    die();

                }

            }
        }

    }

    if (!isset($errMSG)) {

        $sqlUsuario = 'UPDATE usuario SET nome="' . $nome . 
        '", cpf = "' . $cpf . '" WHERE idUsuario =' . $idUsuario . ';';

        if ($con->query($sqlUsuario) === true) {
        //header("refresh:5;index.php"); // redirects image view page after 5 seconds.
        } else {
            $errMSG = "1 error while inserting....2";
            echo $errMSG;
            echo "Error: " . $sqlUsuario . "<br>" . mysqli_error($con);
        }

        $sqlDependente = "UPDATE dependente SET dataNascimento='" . $dataNascimento . "',fk_idGenero=" . $genero . ",email = '" . $email . "', fk_idParentesco = '" . $parentesco . "', agregado = '" . $agregado . "' WHERE idDependente = '" . $idDependente . "';";

        if ($con->query($sqlDependente) === true) {

             

        //header("refresh:5;index.php"); // redirects image view page after 5 seconds.
        } else {
            $errMSG = "2 error while inserting....2";
            echo $errMSG;
            echo "Error: " . $sqlDependente . "<br>" . mysqli_error($con);
        }

        $sqlTelefone = "UPDATE `telefone` SET `telefone` = '" . $telefone . "' ,`telefone2` = '" . $telefone2 . "' WHERE `fk_idUsuario` = '" . $idUsuario . "';";

        if ($con->query($sqlTelefone) == true) {


        } else {
            $errMSG = "3 error while inserting....2";
            echo $errMSG;
            echo "Error: " . $sqlTelefone . "<br>" . mysqli_error($con);
        }
    }

    echo "<script language='javascript' type='text/javascript'>alert('Atualização realizada com sucesso!');window.location.href='editarDependente.php?id=" . $idDependente . "&matricula=" . $matricula . "';</script>";
    die();
}
?>