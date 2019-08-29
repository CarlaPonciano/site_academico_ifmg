<?php
    include("conexao.php"); //incluir arquivo com conexão ao banco de dados
    include("include/headerAdm.php");

    //SE ATUALIZAR
    if (isset($_POST["atualizar"])) {

        $tipo = addslashes($_POST["tipo"]);
        $idTipo = $_GET['id'];

        $sql = "UPDATE tipoconta SET tipo = '".$tipo."' WHERE idTipoConta = " . $idTipo;
        
        if ($con->query($sql) === TRUE) {
            echo "<script>alert('Atualização realizada com sucesso!');</script>";
            echo "<script>javascript:history.go(-1);</script>";
        } else {
            echo "Erro: " . $sql . "<br>" . $con->error;
        }
        $con->close();
            
    } //fim se atualizar

?>