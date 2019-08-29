<?php
include "conexao.php";
//include "atualizar.php";

// session_start inicia a sessão
session_start();

// as variáveis login e senha recebem os dados digitados na página anterior
$login = $_POST['login'];
$senha = $_POST['senha'];

// A variavel $result pega as varias $login e $senha, faz uma pesquisa na tabela de usuarios
$sql = "SELECT * FROM usuario WHERE login = '$login' AND senha = '$senha'";
$result = $con->query($sql);

/* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $_SESSION['login'] = $row['login'];
        $_SESSION['tipo'] = $row['tipo'];
        $_SESSION['senha'] = $row['senha'];
        $idUsuario = $row['idUsuario'];
        $sqlMatricula = "SELECT matriculaAAA FROM associado WHERE fk_idUsuario = " . $idUsuario;
        $resultMatricula = $con->query($sqlMatricula);
        if ($resultMatricula->num_rows > 0) {
            while ($rowMatricula = $resultMatricula->fetch_assoc()) {
                $matricula = $rowMatricula["matriculaAAA"];
            }
        }
        $_SESSION['matricula'] = $matricula;
        echo "<script language='javascript' type='text/javascript'>window.location.href='exibirSocio.php?matricula=" . $matricula . "';</script>";
    }
} else {
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    unset($_SESSION['tipo']);
    $mensagem = "Dados Incorretos!";
    echo "<script language='javascript' type='text/javascript'>alert('".$mensagem."');window.location.href='login.php';</script>";
    die();
}
?>