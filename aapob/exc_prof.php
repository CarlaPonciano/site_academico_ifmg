<?php
    include("conexao.php");
    session_start();

    $nome = trim(strip_tags($_POST['nome'])); //trim remove espaços a mais e strip_tags remove tags html e outros códigos
    $cpf = trim(strip_tags($_POST['cpf']));
    $email = trim(strip_tags($_POST['email']));
    $senha = trim(strip_tags($_POST['senha']));

    $sql = "DELETE FROM usuario WHERE (nome = '" . $nome . "' and cpf = '" . $cpf . "';)";

    if ($conn->query($sql) == true) { 
        echo "<script>alert('Professor excluído com sucesso!');</script>";
        echo "<script>window.location.href='admin.php';</script>";
    }else{
        echo "<script>alert('Erro ao excluir professor!');</script>";
        echo "<script>window.location = 'javascript:window.history.go(-1)';</script>";
    }
?>