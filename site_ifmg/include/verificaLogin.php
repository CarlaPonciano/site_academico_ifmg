<?php 
  include ("conexao.php"); 
  session_start();

  //Caso o usuário não esteja autenticado, limpa os dados e redireciona
  if (!isset($_SESSION['email'])) {
      
      //Limpa
      unset($_SESSION['nome']);
      unset($_SESSION['email']);
      unset($_SESSION['id']);
      unset($_SESSION['tipo']);

      
      //Redireciona para a página de autenticação
      echo"<script language='javascript' type='text/javascript'>alert('Para acessar esta página é preciso fazer login!');window.location.href='index.php';</script>";
      die();
  }
?>
