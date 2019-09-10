<?php
    include("conexao.php"); //incluir arquivo com conexão ao banco de dados
    include("include/headerAdm.php");

    if (isset($_POST["cadastrar"])) {

        $tipo = addslashes($_POST["tipo"]);
        $despesa = $_GET["despesa"];

        $SQL = 'INSERT INTO tipoconta (tipo, despesa) VALUES ("' . $tipo . '", ' . $despesa . ');';

        if ($con->query($SQL) === TRUE){
            echo "<script>alert('Cadastro realizado com sucesso!');</script>";
            echo "<script>javascript:history.go(-1);</script>";
        }else{
            //mensagem exibida caso ocorra algum erro na execução do comando sql
            echo "<script>alert('Erro ao cadastrar!');</script>";
            echo "Erro: ". $SQL. "<br>" . $con->error;
        }

    } //fim se cadastrar

?>