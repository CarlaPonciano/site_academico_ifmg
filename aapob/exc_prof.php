<?php
    include("conexao.php");
    session_start();

    $cpf = trim(strip_tags($_POST['cpf']));

    $sql = "DELETE FROM usuario WHERE cpf = '" . $cpf . "';";
    echo $sql;

    if ($conn->query($sql) == true) { 
        echo "<script>alert('Professor excluído com sucesso!');</script>";
        echo "<script>window.location.href='admin.php';</script>";
    }else{
        echo "<script>alert('Erro ao excluir professor!');</script>";
        echo "<script>window.location = 'javascript:window.history.go(-1)';</script>";
    }
?>