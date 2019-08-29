<?php
include("include/headerAdm.php");
if (isset($_SESSION['login'])){
?>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="index.php">Página Inicial</a>
  </li>
  <li class="breadcrumb-item active">Mensalidades</li>
  <li class="breadcrumb-item active">Quitações</li>
</ol>

<!-- DataTables Example -->
<div class="card mb-3">
  <div class="card-header">
    <i class="fas fa-money-check"></i>
    Quitações</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Matrícula</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Valor</th>
            <th>Data de Pagamento</th>
            <th>Meses de Referência</th>
            <th>Observação</th>
            <th>Aprovação</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Matrícula</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Valor</th>
            <th>Data de Pagamento</th>
            <th>Meses de Referência</th>
            <th>Observação</th>
            <th>Aprovação</th>
            <th>Ações</th>
          </tr>
        </tfoot>
        <tbody>

          <?php
            $MES[1] = "janeiro";
            $MES[2] = "fevereiro";
            $MES[3] = "março";
            $MES[4] = "abril";
            $MES[5] = "maio";
            $MES[6] = "junho";
            $MES[7] = "julho";
            $MES[8] = "agosto";
            $MES[9] = "setembro";
            $MES[10] = "outubro";
            $MES[11] = "novembro";
            $MES[12] = "dezembro";

            $sql = "SELECT A.matriculaAAA, U.nome, U.cpf, Q.valor, Q.idQuitacao, Q.dataPagamento, Q.dataReferenciaInicial, Q.dataReferenciaFinal, Q.observacao, Q.aprovacao
                    FROM quitacao as Q, associado AS A, usuario AS U
                    WHERE Q.fk_idAssociado = A.idAssociado 
                    AND A.fk_idUsuario = U.idUsuario;";

            $result = $con->query($sql);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $nome = ucwords($row['nome']);
                $cpf = $row['cpf'];
                $matricula = $row['matriculaAAA'];
                $idQuitacao = $row['idQuitacao'];
                $valor = $row['valor'];
                $valorExibido = str_replace(".", ",", $valor);
                $dataPagamento = $row['dataPagamento'];
                $dataReferenciaInicial = $row['dataReferenciaInicial'];
                $dataReferenciaFinal = $row['dataReferenciaFinal'];
                $observacao = $row['observacao'];
                $aprovacao = $row['aprovacao'];

                date_default_timezone_set('America/Sao_Paulo');
                $today = date("Y-m-d");
                $diaTd = date("d");
                $mesTd = date("n");
                $anoTd = date("Y");

                list($anoI, $mesI, $diaI) = explode('-', $dataReferenciaInicial);
                $mesI = (int) $mesI;
                $anoI = (int) $anoI;

                list($anoV, $mesV, $diaV) = explode('-', $dataReferenciaFinal);
                $mesV = (int) $mesV;
                $anoV = (int) $anoV;

                $diff = date_diff(date_create($dataReferenciaFinal), date_create($dataReferenciaInicial));
                $d = $diff->format('%m');
                $y = $diff->format('%y');
                $d = $d + (12 * $y);

                if ($d <= 1) {
                    $mesesReferencia = $MES[$mesI] . "/" . $anoI;
                } else {
                    $date = date_create($dataReferenciaFinal);
                    date_sub($date, date_interval_create_from_date_string("1 month"));
                    $mesesReferencia = $MES[$mesI] . "/" . $anoI . " a " . $MES[$date->format("n")] . "/" . $date->format("Y");
                }

                list($anoP, $mesP, $diaP) = explode('-', $dataPagamento);
                $dataPagamento = $diaP . "/" . $mesP . "/" . $anoP;

                $valor = number_format($valor, 2);

                if ($aprovacao) {
                  echo '<tr class="table-success">';
                }else{
                  echo '<tr>';
                }
                echo '<td>' . $matricula . '</td>';
                echo '<td>' . $nome . '</td>';
                echo '<td>' . $cpf . '</td>';
                echo '<td>' . $valorExibido . '</td>';
                echo '<td>' . $dataPagamento . '</td>';
                echo '<td>' . ucwords($mesesReferencia) . '</td>';
                echo '<td>' . $observacao . '</td>';

                if (!$aprovacao) {
                    $aprovacao = "Pendente";
                    if (($tipo == 4) || ($tipo == 6)) {
                      echo '<td> <a> <button class="btn btn-warning" onclick="pendente(' . $idQuitacao . ')">' . $aprovacao . '</button></a></td>';
                    }else{
                      echo '<td>' . $aprovacao . '</td>';
                    }
                } else {
                    $aprovacao = "Aprovado";
                    echo '<td>' . $aprovacao . '</td>';
                }

                if ((($tipo == 4) || ($tipo == 6)) && ($aprovacao == 'Pendente')) {
                    echo '<td><a title="Excluir Quitação" onclick="remove(' . $idQuitacao . ')"><i class="fas fa-trash-alt" style="color:red"></i></a></td>';
                }else{
                    echo '<td></td>';
                }
                echo '</tr>';
              }
            }
            ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  function pendente(idQuitacao) {
    var r = confirm("Deseja realmente registrar estes pagamentos?");
    if (r == true) {
      window.location.href = "inserirQuitacaoAprovada.php?idQuitacao=" + idQuitacao;
    } else {
    }
  }

  function remove(idQuitacao) {
    var r = confirm("Deseja realmente remover estes pagamentos?");
    if (r == true) {
      window.location.href = "deletarQuitacao.php?idQuitacao=" + idQuitacao;
    } else {
    }
  }
</script>

<?php
include("include/footerAdm.php");

}else{
  echo "<script>window.location.href='index.php';</script>";
}
?>