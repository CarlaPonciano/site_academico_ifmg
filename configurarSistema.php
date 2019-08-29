<?php
include("include/headerAdm.php");
if (isset($_SESSION['login'])){
?>

<style>
  a{
    color: #212529;
  }
</style>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="indexAdmin.php" style="color: #0056C0;">Página Inicial</a>
  </li>
  <li class="breadcrumb-item active">Configurações</li>
  <li class="breadcrumb-item active">Sistema</li>
</ol>

<form enctype="multipart/form-data" role="form" data-toggle="validator" action="atualizarConfiguracao.php" method="post">

    <div class="card mb-3">
      <a href="#situacao" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="situacao">
        <i class="fas fa-user"></i>
        Situação de Associados
      </a>

      <div id="situacao">
        <div class="card-body">

          <?php

            $sqlRegular = "SELECT rotulo, atraso FROM situacao WHERE idSituacao = 1;";

            $resultRegular = $con->query($sqlRegular);

            if ($resultRegular->num_rows > 0) { // Exibindo cada linha retornada com a consulta
              while ($exibirRegular = $resultRegular->fetch_assoc()){
                $rotuloRegular = $exibirRegular["rotulo"];
                $diasRegular = $exibirRegular["atraso"];
              } // fim while
            } else { //se não achar nenhum registro
              echo "Nada foi encontrado.";
              exit;
            }

            $sqlAtraso = "SELECT rotulo, atraso FROM situacao WHERE idSituacao = 2;";

            $resultAtraso = $con->query($sqlAtraso);

            if ($resultAtraso->num_rows > 0) { // Exibindo cada linha retornada com a consulta
              while ($exibirAtraso = $resultAtraso->fetch_assoc()){
                $rotuloAtraso = $exibirAtraso["rotulo"];
                $diasAtraso = $exibirAtraso["atraso"];
              } // fim while
            } else { //se não achar nenhum registro
              echo "Nada foi encontrado.";
              exit;
            }

            $sqlInadimplente = "SELECT rotulo, atraso FROM situacao WHERE idSituacao = 3;";

            $resultInadimplente = $con->query($sqlInadimplente);

            if ($resultInadimplente->num_rows > 0) { // Exibindo cada linha retornada com a consulta
              while ($exibirInadimplente = $resultInadimplente->fetch_assoc()){
                $rotuloInadimplente = $exibirInadimplente["rotulo"];
                $diasInadimplente = $exibirInadimplente["atraso"];
              } // fim while
            } else { //se não achar nenhum registro
              echo "Nada foi encontrado.";
              exit;
            }

            $sqlMensal = "SELECT valor FROM valorMensalidade WHERE idValor = 1;";

            $resultMensal = $con->query($sqlMensal);

            if ($resultMensal->num_rows > 0) { // Exibindo cada linha retornada com a consulta
              while ($exibirMensal = $resultMensal->fetch_assoc()){
                $valorMensal = $exibirMensal["valor"];
              } // fim while
            } else { //se não achar nenhum registro
              echo "Nada foi encontrado.";
              exit;
            }

            $sqlAnual = "SELECT valor FROM valorMensalidade WHERE idValor = 2;";

            $resultAnual = $con->query($sqlAnual);

            if ($resultAnual->num_rows > 0) { // Exibindo cada linha retornada com a consulta
              while ($exibirAnual = $resultAnual->fetch_assoc()){
                $valorAnual = $exibirAnual["valor"];
              } // fim while
            } else { //se não achar nenhum registro
              echo "Nada foi encontrado.";
              exit;
            }

          ?>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="regular">
                Rótulo <span title="obrigatório">*</span>
              </label>
              <input type="text" class="form-control" id="regular" placeholder="Situação" name="rotuloRegular" required value="<?php echo $rotuloRegular;?>">
            </div>

            <div class="form-group col-md-6">
              <label for="diasRegular">Dias de Atraso <span title="obrigatório">*</span>
              </label>
              <input type="number" class="form-control" id="diasRegular" placeholder="Dias de Atraso" name="diasRegular" value="<?php echo $diasRegular;?>" required>
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <input type="text" class="form-control" id="atraso" placeholder="Situação" name="rotuloAtraso" required value="<?php echo $rotuloAtraso;?>">
            </div>

            <div class="form-group col-md-6">
              <input type="number" class="form-control" id="diasAtraso" placeholder="Dias de Atraso" name="diasAtraso" required value="<?php echo $diasAtraso;?>">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <input type="text" class="form-control" id="inadimplente" placeholder="Situação" name="rotuloInadimplente" required value="<?php echo $rotuloInadimplente;?>">
            </div>

            <div class="form-group col-md-6">
              <input type="number" class="form-control" id="diasInadimplente" placeholder="Dias de Atraso" name="diasInadimplente" required value="<?php echo $diasInadimplente;?>">
            </div>

          </div>

        </div>
      </div>
    </div>

    <div class="card mb-3">
      <a href="#mensalidade" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="mensalidade">
        <i class="fas fa-money-check"></i>
        Valor da Mensalidade
      </a>

      <div id="mensalidade">
        <div class="card-body">

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="mensal">
                Mensal <span title="obrigatório">*</span>
              </label>
              <input type="text" class="form-control" id="mensal" placeholder="Valor Mensal" name="mensal" value="<?php echo $valorMensal; ?>" required>
            </div>

            <div class="form-group col-md-6">
              <label for="anual">
                Anual <span title="obrigatório">*</span>
              </label>
              <input type="text" class="form-control" id="anual" placeholder="Valor Anual" name="anual" value="<?php echo $valorAnual; ?>" required>
            </div>

          </div>

        </div>
      </div>
    </div>

    <button type="submit" name="atualizarConfiguracao" class="float-center btn btn-primary">Atualizar</button>
</form>

<?php
include("include/footerAdm.php");

}else{
  echo "<script>window.location.href='index.php';</script>";
}
?>