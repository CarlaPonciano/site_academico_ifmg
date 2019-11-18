<?php



require_once __DIR__ . '/vendor/autoload.php';

include 'conexao.php';

$mpdf = new \Mpdf\Mpdf();

$today = date('d/m/y');

ob_start();

echo "<!DOCTYPE html>";



echo"<html>";

echo"<head>";



echo"<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>";



echo '<script src="vendor/components/jquery/jquery.min.js" type="text/javascript"></script>';

echo '<script src="vendor/twitter/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>';

echo '<script src="vendor/wenzhixin/bootstrap-table/src/bootstrap-table.js" type="text/javascript"></script>';



echo '<link href="vendor/wenzhixin/bootstrap-table/src/bootstrap-table.css" rel="stylesheet" type="text/css"/>';

echo '<link href="vendor/twitter/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>';

echo '<style>

table {

    font-family: Roboto, sans-serif;

    font-size:12px;

    border-collapse: collapse;

    width: 100%;

}



td, th {

    border: 1px solid #dddddd;

    text-align: left;

    padding: 8px;

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

</style>';

echo '</head>';

echo '<body><div class="bor">
                <div class="boxL">
                    <div class="box1">
                    <img src="img/aaalogo.png" width="70" height="35">
                    </div>
                    <div class="box2">
                    <p>Associação dos Aposentados e Pensionistas de Ouro Branco</p>
                    </div>
                </div>
            </div>';

if (isset($_POST["emitirRelatorio"]) ) {

  if ((isset($_POST['regular'])) && (isset($_POST['atraso'])) && (isset($_POST['inadimplente']))){

      $sql = 'SELECT tipoLog, logradouro, numero, bairro, nome, idUsuario FROM associado AS a, usuario AS u WHERE a.fk_idUsuario = u.idUsuario AND a.ativo = 1 AND a.cidade = "OURO BRANCO" AND NOT a.bairro = "" AND NOT a.logradouro = "" ORDER BY bairro, logradouro, numero;';

      echo '<h3>ENDEREÇOS - ASSOCIADOS ATIVOS E REGULARES/EM ATRASO/INADIMPLENTES- OURO BRANCO/MG - <space>' . $today . ' </h3>';

  } else if ((isset($_POST['regular'])) && (isset($_POST['atraso']))){

      $sql = 'SELECT tipoLog, logradouro, numero, bairro, nome, idUsuario FROM associado AS a, usuario AS u WHERE (a.fk_idSituacao = 1 OR a.fk_idSituacao = 2) AND a.fk_idUsuario = u.idUsuario AND a.ativo = 1 AND a.cidade = "OURO BRANCO" AND NOT a.bairro = "" AND NOT a.logradouro = "" ORDER BY bairro, logradouro, numero;';

      echo '<h3>ENDEREÇOS - ASSOCIADOS ATIVOS E REGULARES/EM ATRASO - OURO BRANCO/MG - <space>' . $today . ' </h3>';

  } else if ((isset($_POST['regular'])) && (isset($_POST['inadimplente']))){

      $sql = 'SELECT tipoLog, logradouro, numero, bairro, nome, idUsuario FROM associado AS a, usuario AS u WHERE (a.fk_idSituacao = 1 OR a.fk_idSituacao = 3) AND a.fk_idUsuario = u.idUsuario AND a.ativo = 1 AND a.cidade = "OURO BRANCO" AND NOT a.bairro = "" AND NOT a.logradouro = "" ORDER BY bairro, logradouro, numero;';

      echo '<h3>ENDEREÇOS - ASSOCIADOS ATIVOS E REGULARES/INADIMPLENTES - OURO BRANCO/MG - <space>' . $today . ' </h3>';

  } else if ((isset($_POST['atraso'])) && (isset($_POST['inadimplente']))){

      $sql = 'SELECT tipoLog, logradouro, numero, bairro, nome, idUsuario FROM associado AS a, usuario AS u WHERE (a.fk_idSituacao = 2 OR a.fk_idSituacao = 3) AND a.fk_idUsuario = u.idUsuario AND a.ativo = 1 AND a.cidade = "OURO BRANCO" AND NOT a.bairro = "" AND NOT a.logradouro = "" ORDER BY bairro, logradouro, numero;';

      echo '<h3>ENDEREÇOS - ASSOCIADOS ATIVOS E EM ATRASO/INADIMPLENTES - OURO BRANCO/MG - <space>' . $today . ' </h3>';

  } else if (isset($_POST['regular'])){

      $sql = 'SELECT tipoLog, logradouro, numero, bairro, nome, idUsuario FROM associado AS a, usuario AS u WHERE a.fk_idSituacao = 1 AND a.fk_idUsuario = u.idUsuario AND a.ativo = 1 AND a.cidade = "OURO BRANCO" AND NOT a.bairro = "" AND NOT a.logradouro = "" ORDER BY bairro, logradouro, numero;';

      echo '<h3>ENDEREÇOS - ASSOCIADOS ATIVOS E REGULARES - OURO BRANCO/MG - <space>' . $today . ' </h3>';

  } else if (isset($_POST['atraso'])){

      $sql = 'SELECT tipoLog, logradouro, numero, bairro, nome, idUsuario FROM associado AS a, usuario AS u WHERE a.fk_idSituacao = 2 AND a.fk_idUsuario = u.idUsuario AND a.ativo = 1 AND a.cidade = "OURO BRANCO" AND NOT a.bairro = "" AND NOT a.logradouro = "" ORDER BY bairro, logradouro, numero;';

      echo '<h3>ENDEREÇOS - ASSOCIADOS ATIVOS E EM ATRASO - OURO BRANCO/MG - <space>' . $today . ' </h3>';

  } else if (isset($_POST['inadimplente'])){

      $sql = 'SELECT tipoLog, logradouro, numero, bairro, nome, idUsuario FROM associado AS a, usuario AS u WHERE a.fk_idSituacao = 3 AND a.fk_idUsuario = u.idUsuario AND a.ativo = 1 AND a.cidade = "OURO BRANCO" AND NOT a.bairro = "" AND NOT a.logradouro = "" ORDER BY bairro, logradouro, numero;';

      echo '<h3>ENDEREÇOS - ASSOCIADOS ATIVOS E INADIMPLENTES - OURO BRANCO/MG - <space>' . $today . ' </h3>';

  } else {
      echo"<script language='javascript' type='text/javascript'>alert('ERRO: Preencha o formulário corretamente.');window.location.href='indexAdmin.php';</script>";

      die();
  }

  echo '<table id="table" data-toolbar="#toolbar" data-toggle="table" data-sort-name="nasc">';

  echo '<thead>';

  echo '<tr>';

  echo '<th data-field = "nome">LOGRADOURO</th>';

  echo '<th data-field = "nasc">BAIRRO</th>';

  echo '<th data-field = "tele">NOME</th>';

  echo '</tr>';

  echo '</thead>';

  echo '<tbody>';

  $result = $con->query($sql);

  if ($result->num_rows > 0) {

      while ($row = $result->fetch_assoc()) {    

          $socio = ucwords($row['nome']);

          $logradouro = ucwords($row['tipoLog'])." ".ucwords($row['logradouro']).", ".$row['numero'].$row['complemento'];

          $bairro = ucwords($row['bairro']);

          $idUsuario = ucfirst($row['idUsuario']);
              
          echo '<tr>';

          echo '<td>' . $logradouro . '</td>';

          echo '<td>' . $bairro . '</td>';

          echo '<td>' . $socio . '</td> ';  

      }

  }

}

echo '</tbody>';

echo '</table>';

echo '</body>';

echo '</html>';

$html = ob_get_contents();

ob_end_clean();

// send the captured HTML from the output buffer to the mPDF class for processing

$mpdf->WriteHTML($html);

$mpdf->Output();

?>