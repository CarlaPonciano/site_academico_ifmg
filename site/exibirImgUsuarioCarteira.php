<?php

$imgUsuario = "";

$sql = "SELECT iu.imgUsuario FROM imgUsuario AS iu, associado AS a WHERE iu.fk_idUsuario = a.fk_idUsuario and a.matriculaAAA = '".$matricula."';";

$resultIU = $con->query($sql);

if ($resultIU->num_rows > 0) {

    // output data of each row

    while ($rowsIU = $resultIU->fetch_assoc()) {

    $imgUsuario = $rowsIU["imgUsuario"];

    ?>



    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" >        

        <img src=imgUsuario/<?php echo $imgUsuario;?> style='max-width: 70px;'>

        <?php

    }   

}else{

    ?>

    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" >        

        <img src=user_images/user-default.png style='max-width: 70px;'>

    <?php

}



?>