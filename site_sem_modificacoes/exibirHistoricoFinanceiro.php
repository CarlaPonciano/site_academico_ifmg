<?php
include("include/headerAdm.php");
if (isset($_SESSION['login'])){
?>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="index.php">Página Inicial</a>
  </li>
  <li class="breadcrumb-item active">Financeiro</li>
  <li class="breadcrumb-item active">Histórico</li>
</ol>

<!-- DataTables Example -->
<div class="card mb-3">
  <div class="card-header">
    <i class="fas fa-coins"></i>
    Histórico Financeiro</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th></th>
            <th>Tipo</th>
            <th>Mês de Referência</th>
            <th>Data de Pagamento/Recebimento</th>
            <th>Data de Cadastro</th>
            <th>Observações</th>
            <th>Valor</th>
            <th>Recibo</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th></th>
            <th>Tipo</th>
            <th>Mês de Referência</th>
            <th>Data de Pagamento/Recebimento</th>
            <th>Data de Cadastro</th>
            <th>Observações</th>
            <th>Valor</th>
            <th>Recibo</th>
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

            $sqlFinan = "SELECT TC.despesa, TC.tipo, C.idConta, C.valor, C.mesReferencia, C.dataPagamento, C.dataCadastro, C.observacao
                            FROM tipoconta AS TC, conta AS C
                            WHERE TC.idTipoConta = C.fk_idTipoConta;";

            $resultFinan = $con->query($sqlFinan);

            if ($resultFinan->num_rows > 0) {
              while ($row = $resultFinan->fetch_assoc()) {
                $idConta = $row['idConta'];
                $despesa = $row['despesa'];
                $tipo = $row['tipo'];
                $valor = $row['valor'];
                $valor = str_replace(".", ",", $valor);
                $mesReferencia = $row['mesReferencia'];
                $dataPagamento = date("d/m/Y", strtotime($row['dataPagamento']));
                if ($row['dataPagamento'] == '0000-00-00') {
                  $dataPagamento = "";
                }
                $dataCadastro = date("d/m/Y", strtotime($row['dataCadastro']));
                $observacao = $row['observacao'];

                list($ano, $mes, $dia) = explode('-', $mesReferencia);
                $mes = (int) $mes;
                $mesReferencia = $MES[$mes] . "/" . $ano;
          ?>
                <tr>
                  <?php
                    if ($despesa == 0) {
                  ?>
                        <td class="table-success"><b>RENDA</b>
                  <?php
                    }else{
                  ?>
                        <td class="table-danger"><b>DESPESA</b>
                  <?php
                    }
                  ?>
                        </td>
                  <td><?php echo $tipo; ?></td>
                  <td><?php echo ucwords($mesReferencia); ?></td>
                  <td><?php echo $dataPagamento; ?></td>
                  <td><?php echo $dataCadastro; ?></td>
                  <td><?php echo $observacao; ?></td>
                  <td>
                    <?php
                      if ($despesa == 0) {
                    ?>
                          <span style="color: green;">
                    <?php
                      }else{
                    ?>    
                          <span style="color: red;">-
                    <?php
                      }
                    ?>
                    R$ <?php echo $valor; ?></span>
                  </td>
                  <td><a title='Emitir Recibo' href='gerarReciboFinanceiro.php?id=<?php echo $idConta; ?>' target='_blank'><i class="fas fa-money-check" style="color:#0069d9"></i></a></td>
                  <td><a title='Excluir Registro' href='excluirConta.php?id=<?php echo $idConta; ?>'><i class="fas fa-trash-alt" style="color:red"></i></a></td>
                </tr>
          <?php
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php
include("include/footerAdm.php");

}else{
  echo "<script>window.location.href='index.php';</script>";
}
?>