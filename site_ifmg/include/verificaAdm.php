<?php 
  include ("conexao.php");

  //Caso o usuário não seja administrador, redireciona
  if(!($_SESSION['tipo'] == 2)){
      echo $_SESSION['tipo'];
      //Redireciona para a página inicial
      echo"<script language='javascript' type='text/javascript'>alert('Para acessar esta página é necessário ser administrador!');window.location.href='index.php';</script>";
      die();
  }
?>
