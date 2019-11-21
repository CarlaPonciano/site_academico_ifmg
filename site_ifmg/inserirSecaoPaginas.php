<?php
  include("conexao.php"); //incluir arquivo com conexão ao banco de dados
  include("include/header.php");

  if (isset($_SESSION["email"])) { //SE EXISTIR AUTENTICAÇÃO
    if ($_SESSION['tipo']==2){ //SE O USUÁRIO LOGADO FOR DO TIPO ADMINISTRADOR

      if (isset($_POST["cadastrar"])) {

        $titulo = addslashes($_POST["titulo"]);

        $SQL = 'INSERT INTO secaopaginas (titulo, exibir) VALUES ("' . $titulo . '", 1);';

        if ($conn->query($SQL) === TRUE){
          echo "<script>alert('Cadastro realizado com sucesso!');</script>";
          echo "<script>window.location = 'index.php';</script>";
        }else{
          //mensagem exibida caso ocorra algum erro na execução do comando sql
          echo "<script>alert('Erro ao cadastrar seção!');</script>";
          echo "Erro: ". $SQL. "<br>" . $conn->error;
        }

      } //fim se cadastrar

    }else {
      echo "<script>window.location = 'index.php';</script>";
    }
  } else {
    echo "<script>window.location = 'index.php';</script>";
  }
?>