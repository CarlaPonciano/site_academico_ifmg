<?php
    include ("include/headerAdm.php"); 

    $nome = trim(strip_tags($_POST['nome'])); //trim remove espaços a mais e strip_tags remove tags html e outros códigos
    $cpf = trim(strip_tags($_POST['cpf']));
    $email = trim(strip_tags($_POST['email']));
    $senha = trim(strip_tags($_POST['senha']));

    $sql = "INSERT INTO usuario(nome, cpf, tipo, email, senha) VALUES ( '" . $nome . "' , '" . $cpf . "',1,
            '" . $email . "', '" . $senha . "');";
    if ($conn->query($sql) == true) { 
        echo "<script>alert('Professor cadastrado com sucesso!');</script>";
        echo "<script>window.location.href='exibir_professorHTML.php';</script>";
    }else{
        echo "<script>alert('Erro ao cadastrar professor!');</script>";
        echo "<script>window.location = 'javascript:window.history.go(-1)';</script>";
    }
?>