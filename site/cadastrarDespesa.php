<?php
include("include/headerAdm.php");
if (isset($_SESSION['login'])){
?>

<style>
  a{
    color: #212529;
  }
</style>

<!--início do modal para tipos de despesa-->
<div class="modal fade bd-example-modal-sm" id="editarTiposDespesa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title" id="exampleModalLabel">Tipos de Despesa</h3>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    
    <div class="modal-body">
      <?php
      $sqlTipoDespesa = "SELECT idTipoConta, tipo 
                          FROM tipoconta
                          WHERE despesa = 1 
                          ORDER BY tipo;";

      $resultTipoDespesa = $con->query($sqlTipoDespesa);

      if ($resultTipoDespesa->num_rows > 0) { // Exibindo cada linha retornada com a consulta
        while ($exibirTipoDespesa = $resultTipoDespesa->fetch_assoc()){
          $idTipoDespesa = $exibirTipoDespesa["idTipoConta"];
          $tipo = $exibirTipoDespesa["tipo"];

      ?>
          <label class="control-label col-sm-12">
            <?php echo $tipo; ?>
            <a style="color: #0056C0;" href="" data-toggle="modal" data-target="#editarTipoDespesa-<?php echo $idTipoDespesa; ?>">
              <i class="far fa-edit"></i>
            </a>
          </label>

          <!-- Modal - Editar tipo de despesa-->
          <div class="modal fade" id="editarTipoDespesa-<?php echo $idTipoDespesa; ?>" tabindex="-1" role="dialog" aria-labelledby="editarTipoDespesa-<?php echo $idTipoDespesa; ?>" aria-hidden="true">

          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="secaoPaginasLabel">Editar Tipo de Despesa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
              <form class="form-horizontal" action="atualizarTipoConta.php?id=<?php echo $idTipoDespesa; ?>" method="post" data-toggle="validator">

                  <div class="form-group">
                    <label class="control-label col-sm-12" for="tipoDespesa">Tipo de Despesa:</label>
                    <div class="col-sm-12">
                      <input required type="text" class="form-control" id="tipoDespesa" name="tipo" value="<?php echo $tipo; ?>">
                    </div>
                  </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <input type="submit" class="btn btn-primary" value="Atualizar" name="atualizar"></input>
              </div>

              </form>

            </div>
          </div>
          </div>
      <?php
          } // fim while 
        } // fim if
      ?>

      <div class="col-md-12"> 
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#cadastrarTipoDespesa">
          <i class="fas fa-plus"></i>  
          Cadastrar Novo Tipo de Despesa
        </button>
      </div>

    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    </div>

  </div>
  </div>
</div>
<!--fim do modal para tipos de despesa-->

<!-- Modal - Cadastrar tipo de despesa-->
<div class="modal fade" id="cadastrarTipoDespesa" tabindex="-1" role="dialog" aria-labelledby="cadastrarTipoDespesa" aria-hidden="true">

<div class="modal-dialog" role="document">
  <div class="modal-content">

    <div class="modal-header">
      <h5 class="modal-title" id="secaoPaginasLabel">Cadastrar Tipo de Despesa</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <div class="modal-body">
    <form class="form-horizontal" action="inserirTipoConta.php?despesa=1" method="post" data-toggle="validator">

        <div class="form-group">
          <label class="control-label col-sm-12" for="tipoDespesa">Tipo de Despesa:</label>
          <div class="col-sm-12">
            <input required type="text" class="form-control" id="tipoDespesa" name="tipo">
          </div>
        </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      <input type="submit" class="btn btn-primary" value="Cadastrar" name="cadastrar"></input>
    </div>

    </form>

  </div>
</div>
</div>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="indexAdmin.php" style="color: #0056C0;">Página Inicial</a>
  </li>
  <li class="breadcrumb-item active">Financeiro</li>
  <li class="breadcrumb-item active">Cadastrar Despesa</li>
</ol>

<div class="card mb-2">
  <div class="card-body" style="padding:1%;">
    <div class="float-right">
      <a class="btn btn-primary" href="" data-toggle="modal" data-target="#editarTiposDespesa">
        <i class="far fa-edit"></i> 
        Editar Tipos de Despesa
      </a>
    </div>
  </div>
</div>

<form enctype="multipart/form-data" role="form" data-toggle="validator" action="inserirConta.php" method="post">

    <div class="card mb-3">
      <a href="#dados" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="dados">
        <i class="fas fa-coins"></i>
        Despesa
      </a>

      <div id="dados">
        <div class="card-body">

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="tipo">
                Tipo de Despesa <span title="obrigatório">*</span>
              </label>
              <select class="form-control" id="tipo" required="required" name="tipo">
                <?php
                  $result = $con->query("SELECT idTipoConta, tipo 
                                          FROM tipoconta
                                          WHERE despesa = 1 
                                          ORDER BY tipo;");
                  while ($row = $result->fetch_assoc()) {
                    unset($id, $name);
                    $id = $row['idTipoConta'];
                    $name = $row['tipo'];
                    echo '<option value="' . $id . '">' . $name . '</option>';
                  }
                ?>
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="valor">
                Valor <span title="obrigatório">*</span>
              </label>
              <input class="form-control" type="number" pattern="^[\d.]+$" min="0" step="any" id="valor" name="valor">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="mesReferencia">
                Mês de Referência <span title="obrigatório">*</span>
              </label>
              <input required lang="pt" type="month" value="aaaa-mm" class="form-control" onkeypress="mascara(this,ref)" minlength=7 maxlength="7" min="7" id="mesReferencia" name="mesReferencia">
            </div>

            <div class="form-group col-md-6">
              <label for="dataPagamento">
                Data do Pagamento
              </label>
              <input type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" id="dataPagamento"  name="dataPagamento">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-12">
              <label for="obs">
                Observação
              </label>
              <textarea rows="4" id="observacao" name="observacao" maxlength="500" placeholder="Digite alguma observação" class="form-control"></textarea>
            </div>

          </div>

        </div>
      </div>
    </div>

    <button type="submit" name="cadastrar" class="float-center btn btn-primary">Cadastrar</button>

</form>

<?php
include("include/footerAdm.php");

}else{
  echo "<script>window.location.href='index.php';</script>";
}
?>