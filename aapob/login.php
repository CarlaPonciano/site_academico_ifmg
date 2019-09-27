<?php
    include("conexao.php");
    session_start();

    /* Pega o usuário e senha preenchidos no formulário de login*/
    $email = trim(strip_tags($_POST['email'])); //trim remove espaços a mais e strip_tags remove tags html e outros códigos
    $senha = trim(strip_tags($_POST['senha']));
    //$senhaCrip = base64_encode($senha);

    $sql = "SELECT * FROM usuario WHERE email = '" . $email . "' AND senha = '" . $senha. "';";
    $resultado = $conn->query($sql);
    if ($resultado->num_rows > 0) { //SE O USUÁRIO E SENHA FOREM VÁLIDOS
        $exibir = $resultado->fetch_assoc();
        //$exibir = $resultado->fetch_assoc();
        $_SESSION['nome'] = $exibir["nome"];
        $_SESSION['email'] = $exibir["email"];
        $_SESSION['id'] = $exibir["id"];
        $_SESSION['tipo'] = $exibir["tipo"];
        echo "<script>alert('Login realizado com sucesso!.');</script>";
        echo "<script>window.location.href='index.php';</script>";
    }else{
        echo "<script>alert('Erro no login. Tente novamente.');</script>";
        echo "<script>window.location = 'javascript:window.history.go(-1)';</script>";
    }
?>