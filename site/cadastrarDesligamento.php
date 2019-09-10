<?php
include("include/headerAdm.php");
require __DIR__ . '/vendor/autoload.php';
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
  <li class="breadcrumb-item active">Mensalidade</li>
  <li class="breadcrumb-item active">Editar Vínculo</li>
</ol>

<form class="form-horizontal" enctype="multipart/form-data" role="form" data-toggle="validator" action="inserirDesligamento.php" method="post">

    <div class="card mb-3">
      <a href="#dados" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="dados">
        <i class="fas fa-user"></i>
        Vínculo
      </a>

      <div id="dados">
        <div class="card-body">

          <div class="form-row">

            <div class="form-group col-md-12">
              <label for="myInput">
                Procure pelo nome do sócio <span title="obrigatório">*</span>
              </label>
              <input type="text" maxlength="240" class="form-control" id="myInput" placeholder="Procure pelo nome do sócio" name="myInput" required>
            </div>

            <div class="col-12 col-sm-12 col-md-12  col-lg-12 col-xl-12">  
                <div class="col-12 col-sm-6 col-md-5 col-lg-5 col-xl-5" style="position: absolute;
                     z-index: 3;
                     background-color: #fff;
                     margin-left: 15px;
                     padding-top: 15px;">  
                    <div id="resultado" name="resultado">

                    </div>
                </div>
            </div>
          </div>

          <br>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="nomeAss">
                Sócio <span title="obrigatório">*</span>
              </label>
              <input readonly="readonly" type="text" maxlength="240" class="form-control" id="nomeAss" placeholder="Nome Completo" name="nomeAss" required>
            </div>

            <div class="form-group col-md-6">
              <label for="matricula">
                Matrícula <span title="obrigatório">*</span>
              </label>
              <input readonly="readonly" type="text" maxlength="240" class="form-control" id="matricula" placeholder="Matrícula" name="matricula" required>
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="dataDesligamento">
                Data <span title="obrigatório">*</span>
              </label>
              <input required type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" id="dataDesligamento" name="dataDesligamento">
            </div>

            <div class="form-group col-md-6">
              <label for="vinculo">
                Vínculo <span title="obrigatório">*</span>
              </label>
              <select class="form-control" id="vinculo" name="vinculo">
                     <option value="1">Ativo</option>
                     <option value="0">Inativo</option>
              </select>
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-12">
              <label for="obs">
                Observação
              </label>
              <textarea rows="4" id="obs" name="obs" maxlength="240" placeholder="Digite alguma observação" class="form-control"></textarea>
            </div>

          </div>

        </div>
      </div>
    </div>

    <button type="submit" name="insertDesligamento" class="btn btn-primary">Cadastrar</button>

</form>

<script src="js\buscaSocio.js"></script>

<?php
include("include/footerAdm.php");

}else{
  echo "<script>window.location.href='index.php';</script>";
}
?>