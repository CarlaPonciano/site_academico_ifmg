<?php
    include ("include/headerAdm.php"); 

    $cpf = trim(strip_tags($_GET["cpf"]));

    $sql = "SELECT * FROM usuario WHERE cpf = '" . $cpf . "';";
    $resultado = $conn->query($sql);
    if ($resultado->num_rows > 0) {
        $sql2 = "DELETE FROM usuario WHERE cpf = '" . $cpf . "';";

        if ($conn->query($sql2) == true) { 
            echo "<script>alert('Professor excluído com sucesso!');</script>";
            echo "<script>window.location.href='exibir_professorHTML.php';</script>";
        }else{
            echo "<script>alert('Erro ao excluir professor!');</script>";
            echo "<script>window.location = 'javascript:window.history.go(-1)';</script>";
        }
    }else{
        echo "<script>alert('Professor não cadastrado no sistema!');</script>";
        echo "<script>window.location = 'javascript:window.history.go(-1)';</script>";
    }
?>