<?php
include("conexao.php"); //incluir arquivo com conexão ao banco de dados
include("include/headerAdm.php");
		
if((is_numeric($_GET["id"]))){
    $id = $_GET["id"];
    $SQL = "DELETE FROM conta WHERE idConta = ".$id;
    if ($con->query($SQL) === TRUE) {
        echo "<script>alert('Registro excluído com sucesso!');</script>";
        echo "<script>window.history.go(-1);</script>";
    }
    else{
        echo "<script>alert('Erro ao realizar a exclusão!');</script>";
        echo "<script>window.history.go(-1);</script>";
    }
}
?>