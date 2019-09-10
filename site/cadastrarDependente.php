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
  <li class="breadcrumb-item active">Cadastrar</li>
  <li class="breadcrumb-item active">Dependente</li>
</ol>

<form name="form1" class="form-horizontal" enctype="multipart/form-data" role="form" data-toggle="validator" action="inserirDependente.php" method="post">

    <div class="card mb-3">
      <a href="#dados" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="dados">
        <i class="fas fa-user"></i>
        Dados Pessoais
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
              <label for="nome">
                Nome <span title="obrigatório">*</span>
              </label>
              <input type="text" class="form-control" id="nome" placeholder="Nome completo" name="nome" required>
            </div>

            <div class="form-group col-md-6">
              <label for="dataNascimento">Data de Nascimento</label>
              <input type="date" class="form-control" id="dataNascimento" max="<?php echo date("Y-m-d"); ?>" min="1900-01-01" placeholder="dd/mm/aaaa" name="dataNascimento">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="genero">Gênero</label>
              <select id="genero" name="genero" class="form-control">
                <?php
                    $resGenero = $con->query("SELECT idGenero, genero 
                                            FROM genero");

                    while ($rowGenero = $resGenero->fetch_assoc()) {
                        unset($id, $name);
                        $id = $rowGenero['idGenero'];
                        $name = ucwords(strtolower($rowGenero['genero']));
                        echo '<option value="' . $id . '">' . $name . '</option>';
                    }
                ?>
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="cpf">
                CPF 
                <span href="#" title="Somente Números" data-toggle="popover" data-placement="left" data-content="Content"><i class="fas fa-question-circle"></i></span>
              </label>
              <input minlength="5" maxlength="14" type="text" class="form-control" id="cpf" placeholder="00000000000" name="cpf">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="parentesco">Grau de Parentesco</label>
              <select id="parentesco" name="parentesco" class="form-control">
                <?php
                    $resParentesco = $con->query("SELECT idParentesco, parentesco 
                                            FROM parentesco");

                    while ($rowParentesco = $resParentesco->fetch_assoc()) {
                        unset($id, $name);
                        $id = $rowParentesco['idParentesco'];
                        $name = ucwords(strtolower($rowParentesco['parentesco']));
                        echo '<option value="' . $id . '">' . $name . '</option>';
                    }
                ?>
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="agregado">Tipo</label>
              <select id="agregado" name="agregado" class="form-control">
                <option value=0>Dependente</option>
                <option value=1>Depentende-Agregado</option>
              </select>
            </div>

          </div>

        </div>
      </div>
    </div>

    <div class="card mb-3">

      <a href="#contato" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="contato">
        <i class="fas fa-envelope"></i>
        Dados de Contato
      </a>

      <div id="contato">
        <div class="card-body">

          <div class="form-row">

            <div class="form-group col-md-6">

              <label for="telefone">
                Telefone
                <span href="#" title="Somente Números" data-toggle="popover" data-placement="left" data-content="Content"><i class="fas fa-question-circle"></i></span>
                <i class="fas fa-plus" title="Adicionar Novo Telefone" data-toggle="collapse" data-target="#collapseTelefone2" aria-expanded="false" aria-controls="collapseExample"></i>
              </label>

              <input type="text" class="form-control" id="telefone" maxlength="14" placeholder="Telefone" name="telefone">

            </div>

            <div class="form-group col-md-6">
              <label for="email">
                E-mail
              </label>
              <input type="email" class="form-control" id="email" placeholder="E-mail" name="email">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <div class="collapse" id="collapseTelefone2">
                <input type="text" class="form-control" id="telefone2" maxlength="14" placeholder="Telefone" name="telefone2">
              </div>
            </div>

          </div>
          
        </div>
      </div>
    </div>

    <button type="submit" name="insertDependente" class="btn btn-primary">Cadastrar</button>

</form>

<script src="js\buscaSocio.js"></script>

<?php
include("include/footerAdm.php");

}else{
  echo "<script>window.location.href='index.php';</script>";
}
?>