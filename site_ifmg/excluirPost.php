<?php
include("conexao.php"); //incluir arquivo com conexão ao banco de dados
include("include/header.php");

if (isset($_SESSION["email"])) { //SE EXISTIR AUTENTICAÇÃO
    if ($_SESSION['tipo'] ==2){ //SE O USUÁRIO LOGADO FOR DO TIPO ADMINISTRADOR
		
	if((is_numeric($_GET["idPost"])) && (is_numeric($_GET["idSecao"]))){
		$idPost = $_GET["idPost"];
		$idSecao = $_GET["idSecao"];
		$SQL = "DELETE FROM post WHERE idPost = ".$idPost;
		if ($conn->query($SQL) === TRUE) {
			$SQL = "DELETE FROM postpendente WHERE idPostPendente = ".$idPost;
			if ($conn->query($SQL) === TRUE) {
				echo "<script>alert('Exclusão realizada com sucesso!');</script>";
				echo "<script>window.location = 'postagens.php?id=". $idSecao."';</script>";
			}else{
				echo "<script>alert('Erro ao realizar a exclusão!');</script>";
				echo "<script>window.history.go(-1);</script>";
			}
		}
		else{
			echo "<script>alert('Erro ao realizar a exclusão!');</script>";
			echo "<script>window.history.go(-1);</script>";
		}
	}

  }else {
    echo "<script>window.location = 'index.php';</script>";
  }
} else {
  echo "<script>window.location = 'index.php';</script>";
}
?>