<?php
include "conexao.php";

if (isset($_GET['delete_id'])) {
    // select image from db to delete
    $idUser = $_GET['delete_id'];
    $img = $_GET['img'];
    $imgUsuario = "";

    $sql = "select imgUsuario FROM imgUsuario WHERE fk_idUsuario='" . $idUser . "';";

    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $imgUsuario = $row['imgUsuario'];
        }
    }


    $sql = "DELETE FROM imgUsuario WHERE fk_idUsuario='" . $idUser . "';";
    if ($con->query($sql) == true) {

        echo"<script language='javascript' type='text/javascript'>alert('Imagem removida com Sucesso');</script>";
        die();
    } else {
        $errMSG = "error while inserting....2";
        echo $errMSG;
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}
?>