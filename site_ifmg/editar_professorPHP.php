<?php 
    include ("include/headerAdm.php"); 

    $nome = trim(strip_tags($_POST['nome']));
    $email = trim(strip_tags($_POST['email']));
    $cpf = trim(strip_tags($_POST['cpf']));

    $sql = "UPDATE usuario SET nome = '" . $nome . "', cpf = " . $cpf . ", email = '" . $email . "' WHERE cpf = $cpf";
    if ($conn->query($sql) == true) { 
        echo "<script>alert('Professor atualizado com sucesso!');</script>";
        echo "<script>window.location.href='exibir_professorHTML.php';</script>";
    }else{
        echo "<script>alert('Erro ao editar professor!');</script>";
        echo "<script>window.location = 'javascript:window.history.go(-1)';</script>";
    }
?>