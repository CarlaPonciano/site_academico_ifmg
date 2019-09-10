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
  <li class="breadcrumb-item active">Histórico</li>
</ol>

<!-- DataTables Example -->
<div class="card mb-3">
  <div class="card-header">
    <i class="fas fa-money-check"></i>
    Mensalidades</div>
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
            <th>Mês de Referência</th>
            <th>Vencimento</th>
            <th>Recibo</th>
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
            <th>Mês de Referência</th>
            <th>Vencimento</th>
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

            $sqlMens = "SELECT M.valor, M.idMensalidade, M.dataPagamento, M.dataReferenciaInicial, M.dataReferenciaFinal, A.matriculaAAA, U.nome, U.cpf, A.idAssociado
                        FROM mensalidade AS M, associado AS A, usuario AS U
                        WHERE M.fk_idAssociado = A.idAssociado 
                        AND A.fk_idUsuario = U.idUsuario
                        ORDER BY U.nome";

            $resultMens = $con->query($sqlMens);

            if ($resultMens->num_rows > 0) {
              while ($row = $resultMens->fetch_assoc()) {
                $idAssociado = $row["idAssociado"];
                $nome = ucwords($row["nome"]);
                $matricula = $row["matriculaAAA"];
                $cpf = $row["cpf"];
                $idMensalidade = $row['idMensalidade'];
                $valor = $row['valor'];
                $valorExibido = str_replace(".", ",", $valor);
                $dataPagamento = $row['dataPagamento'];
                $dataReferenciaInicial = $row['dataReferenciaInicial'];
                $dataReferenciaFinal = $row['dataReferenciaFinal'];

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

                //descobre quantos meses foram pagos nesse cadastro
                $diff = date_diff(date_create($dataReferenciaFinal), date_create($dataReferenciaInicial));

                //dá nome aos meses pagos
                if ($diff->format("%m") == "1") {
                    $mesesReferencia = $MES[$mesI] . "/" . $anoI;
                } else {
                    $date = date_create($dataReferenciaFinal);
                    date_sub($date, date_interval_create_from_date_string("1 month"));
                    $mesesReferencia = $MES[$mesI] . "/" . $anoI . " a " . $MES[$date->format("n")] . "/" . $date->format("Y");
                }

                // Descobre que dia é hoje e retorna a unix timestamp
                $hoje = mktime(0, 0, 0, $mesTd, $diaTd, $anoTd);

                // Descobre a unix timestamp da data de nascimento do fulano
                $vencimento = mktime(0, 0, 0, $mesV, $diaV, $anoV);

                //calcula o atraso com base no vencimento da mensalidade paga e o dia atual
                $atraso = floor((((($hoje - $vencimento) / 60) / 60) / 24));
                $vencimento = $diaV . "/" . $mesV . "/" . $anoV; //transforma date em string

                list($anoP, $mesP, $diaP) = explode('-', $dataPagamento);
                $dataPagamento = $diaP . "/" . $mesP . "/" . $anoP;//transforma date em string

                $valor = number_format($valor,2);//formata o número com duas casas decimais

                //verifica se há consistência no cálculo do atraso 
                //(caso tenha pago parcelas adiantadas o valor do atraso será negativo o que na real não consiste em atraso)
                if ($atraso < 0) {
                    $diaAtraso = 0;
                } else {
                    $diaAtraso = $atraso;
                }
          ?>
                <tr>
                  <td><?php echo $matricula; ?></td>
                  <td><?php echo $nome; ?></td>
                  <td><?php echo $cpf; ?></td>
                  <td>R$ <?php echo $valorExibido; ?></td>
                  <td><?php echo $dataPagamento; ?></td>
                  <td><?php echo ucwords($mesesReferencia); ?></td>
                  <td><?php echo $vencimento; ?></td>
                  <td><a title='Emitir Recibo' href='gerarRecibo.php?idMensalidade=<?php echo $idMensalidade; ?>' target='_blank'><i class="fas fa-money-check" style="color:#0069d9"></i></a></td>
                  <td><a title='Excluir Mensalidade' href='deletarMensalidade.php?idMensalidade=<?php echo $idMensalidade; ?>&idAssociado=<?php echo $idAssociado; ?>'><i class="fas fa-trash-alt" style="color:red"></i></a></td>
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