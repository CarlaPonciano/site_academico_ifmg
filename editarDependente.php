<?php
include("include/headerAdm.php");
require __DIR__ . '/vendor/autoload.php';
if (isset($_SESSION['login'])){
  $matricula = $_GET["matricula"];
  $idDependente = $_GET["id"];

  $sql = "SELECT u.idUsuario, u.nome, u.cpf, d.dataNascimento, d.fk_idGenero, d.fk_idParentesco, d.email, d.agregado
           FROM usuario AS u, associado AS a, dependente AS d 
           WHERE u.idUsuario = d.fk_idUsuario 
           AND d.idDependente = " . $idDependente . ";";

  $result = $con->query($sql);

  if ($result->num_rows > 0) {

      while ($row = $result->fetch_assoc()) {
          $idUsuario = $row["idUsuario"];
          $nome = ucwords($row['nome']);
          $cpf = $row['cpf'];
          $dataNascimento = $row['dataNascimento'];
          $idGenero = $row['fk_idGenero'];
          $idParentesco = $row['fk_idParentesco'];
          $email = $row['email'];
          $agregado = $row['agregado'];
      }
  }

  $telefone = array();

  $sqlTel = "SELECT t.telefone,t.telefone2 FROM telefone AS t WHERE t.fk_idUsuario = '" . $idUsuario . "';";
  $resultTel = $con->query($sqlTel);
  if ($resultTel->num_rows > 0) {
    while ($rows = $resultTel->fetch_assoc()) {
      $telefone[0] = $rows["telefone"];
      $telefone[1] = $rows["telefone2"];
    }
  }
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
  <li class="breadcrumb-item active">Consultar</li>
  <li class="breadcrumb-item">
    <a href="exibirSocios.php" style="color: #0056C0;">Associados</a>
  </li>
  <li class="breadcrumb-item">
    <a href="exibirSocio.php?matricula=<?php echo $matricula; ?>" style="color: #0056C0;">Visualizar Sócio</a>
  </li>
  <li class="breadcrumb-item active">Editar Dados do Dependente</li>
</ol>

<form enctype="multipart/form-data" role="form" data-toggle="validator" action="atualizarDependente.php?idDependente=<?php echo $idDependente; ?>&matricula=<?php echo $matricula; ?>" method="post">

    <div class="card mb-3">
      <a href="#dados" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="dados">
        <i class="fas fa-user"></i>
        Dados Pessoais
      </a>

      <div id="dados">
        <div class="card-body">

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="nome">
                Nome <span title="obrigatório">*</span>
              </label>
              <input type="text" class="form-control" id="nome" placeholder="Nome completo" name="nome" required value="<?php echo $nome; ?>">
            </div>

            <div class="form-group col-md-6">
              <label for="dataNascimento">Data de Nascimento</label>
              <input type="date" class="form-control" id="dataNascimento" max="<?php echo date("Y-m-d"); ?>" min="1900-01-01" placeholder="dd/mm/aaaa" name="dataNascimento" value="<?php echo $dataNascimento; ?>">
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
                        if ($idGenero == $id) { 
                          echo '<option selected value="' . $id . '">' . $name . '</option>';
                        }else{
                          echo '<option value="' . $id . '">' . $name . '</option>';
                        }
                    }
                ?>
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="cpf">
                CPF 
                <span href="#" title="Somente Números" data-toggle="popover" data-placement="left" data-content="Content"><i class="fas fa-question-circle"></i></span>
              </label>
              <input minlength="5" maxlength="14" type="text" class="form-control" id="cpf" placeholder="00000000000" name="cpf" value="<?php echo $cpf; ?>">
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
                        if ($idParentesco == $id) { 
                          echo '<option selected value="' . $id . '">' . $name . '</option>';
                        }else{
                          echo '<option value="' . $id . '">' . $name . '</option>';
                        }
                    }
                ?>
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="agregado">Tipo</label>
              <select id="agregado" name="agregado" class="form-control">
                <?php
                    if ($agregado == 0) {
                ?>
                    <option value=0 selected>Dependente</option>
                    <option value=1>Depentende-Agregado</option>
                <?php
                    }else{
                ?>
                    <option value=0>Dependente</option>
                    <option value=1 selected>Depentende-Agregado</option>
                <?php
                    }
                ?>
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

              <input type="text" class="form-control" id="telefone" maxlength="14" placeholder="Telefone" name="telefone" value="<?php echo $telefone[0]; ?>">

            </div>

            <div class="form-group col-md-6">
              <label for="email">
                E-mail
              </label>
              <input type="email" class="form-control" id="email" placeholder="E-mail" value="<?php echo $email; ?>" name="email">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <div class="collapse" id="collapseTelefone2">
                <input type="text" class="form-control" id="telefone2" maxlength="14" placeholder="Telefone" name="telefone2" value="<?php echo $telefone[1]; ?>">
              </div>
            </div>

          </div>
          
        </div>
      </div>
    </div>

    <button type="submit" name="atualizarDependente" class="btn btn-primary">Atualizar</button>

</form>

<script src="js\buscaSocio.js"></script>

<?php
include("include/footerAdm.php");

}else{
  echo "<script>window.location.href='index.php';</script>";
}
?>