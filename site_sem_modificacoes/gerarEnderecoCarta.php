<?php



require_once __DIR__ . '/vendor/autoload.php';

include 'conexao.php';

$matricula = $_GET["matricula"];

$mpdf = new \Mpdf\Mpdf();

ob_start();

echo "<!DOCTYPE html>";



echo"<html>";

echo"<head>";



echo"<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>";



echo '<script src="vendor/components/jquery/jquery.min.js" type="text/javascript"></script>';

echo '<script src="vendor/twitter/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>';

echo '<script src="vendor/wenzhixin/bootstrap-table/src/bootstrap-table.js" type="text/javascript"></script>';



echo '<link href="vendor/wenzhixin/bootstrap-table/src/bootstrap-table.css" rel="stylesheet" type="text/css"/>';

echo '<link href="vendor/twitter/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>';

echo '<style>

#etiqueta {

    font-family: Lato;

    font-size:14px;

    border: 2px solid #000;

    border-radius: 10px;

    width: 360px;

    height: 120px;

    margin: 0px 2px 2px 2px;

    padding: 10px;

}

.boxL {
  float: left;
  width: 275px;
  height: 50px;
  padding: 1px 1px 1px 1px;
  border:
}
.box1 {
  float: left;
  width: 70px;
  height: 50px;
  padding: 1px 1px 1px 1px;
}
.box2 {
  float: left;
  width: 200px;
  height: 50px;
  padding: 1px 1px 1px 1px;
}
.box3 {
  background-color: #e5e5e5;
  float: left;
  width: 80px;
  height: 50px;
  margin-right:5px;
  margin-left:5px;
  padding-top:5px;
  text-align: center;
  border-radius: 5px;
}
.boxR {
  float: left;
  width: 240px;
  height: 120px;
  margin-top: 10px;
  padding-left: 4px;
  border-left: 1px solid #3f3f3f;
}
.bor {
  margin-bottom: 10px;
  border-bottom: 1px dashed #3f3f3f;
}

#foto{
    float: left;
}

#texto {
    float: right;
}

td, th {

    padding: 12px;

}

</style>';

echo '</head>';

echo '<body>';



$sql = 'SELECT tipoLog, logradouro, complemento, numero, bairro, cidade, cep, estado, nome, idUsuario, fk_idSituacao FROM associado as a, usuario as u WHERE a.fk_idUsuario = u.idUsuario and a.fk_idSituacao = 1 and a.bairro NOT LIKE "" and logradouro NOT LIKE "" ORDER BY bairro, logradouro;';

$result = $con->query($sql);

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {



        $socio = ucwords($row['nome']);

        if ($row['complemento'] == null){

            $logradouro = ucwords($row['tipoLog'] . " " . $row['logradouro']) . ", " . $row['numero'];

        }else{

            $logradouro = ucwords($row['tipoLog'] . " " . $row['logradouro']) . ", " . $row['numero'] . " (" . $row['complemento'] . ")";

        }

        $bairro = ucwords($row['bairro']);

        $cidade = ucwords($row['cidade']);

        $estado = ucwords($row['estado']);

        $cep = ucwords($row['cep']);

        $idUsuario = ucfirst($row['idUsuario']);



        echo '<div id="etiqueta">
                <div class="bor">
                    <div class="boxL">
                        <div class="box1">
                        <img src="img/aaalogo.png" width="70" height="35">
                        </div>
                        <div class="box2">
                        <p>Associação dos Aposentados e Pensionistas de Ouro Branco</p>
                        </div>
                    </div>
                </div>';

                echo '<table><tr><td><p><h4>' . $socio . '</h4>';

                echo $logradouro . ' - ';

                echo $bairro . '<br>';

                echo $cidade . ' - ';

                echo $estado . ' ';

                echo '<br>';

                echo $cep . '<br></td>';

                echo '<td></td><td>';

                  include 'exibirImgUsuarioCarteira.php';

                echo '</td>';

               
        echo '</tr></table></div>';

    }

}



echo '</body>';

echo '</html>';



$html = ob_get_contents();

ob_end_clean();



// send the captured HTML from the output buffer to the mPDF class for processing

$mpdf->AddPage('L', '', '', '', '', 5, 5, 3, 3, 0, 0);

$mpdf->WriteHTML($html);

$mpdf->Output();

?>