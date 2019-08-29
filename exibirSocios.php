<?php
include("include/headerAdm.php");
if (isset($_SESSION['login'])){
  include 'atualizar.php';
?>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="indexAdmin.php">Página Inicial</a>
  </li>
  <li class="breadcrumb-item active">Consultar</li>
  <li class="breadcrumb-item active">Associados</li>
</ol>

<!-- DataTables Example -->
<div class="card mb-3">
  <div class="card-header">
    <i class="fas fa-user"></i>
    Associados</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Ações</th>
            <th>Matrícula</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>Logradouro</th>
            <th>Bairro</th>
            <th>Cidade</th>
            <th>Situação</th>
            <th>Vínculo</th>
            <th>Declaração</th>
            <th>Carteira</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Ações</th>
            <th>Matrícula</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>Logradouro</th>
            <th>Bairro</th>
            <th>Cidade</th>
            <th>Situação</th>
            <th>Vínculo</th>
            <th>Declaração</th>
            <th>Carteira</th>
          </tr>
        </tfoot>
        <tbody>

          <?php

            $sqlSocios = "SELECT A.matriculaAAA, U.nome, T.telefone, T.telefone2, U.cpf, A.tipoLog, A.logradouro, A.numero, A.bairro, A.cidade, S.rotulo, A.fk_idSituacao, A.ativo
                          FROM usuario AS U, associado AS A, telefone AS T, situacao AS S
                          WHERE U.tipo = 'socio'
                          AND U.idUsuario = A.fk_idUsuario
                          AND U.idUsuario = T.fk_idUsuario
                          AND S.idSituacao = A.fk_idSituacao
                          ORDER BY U.nome;";

            $resultSocios = $con->query($sqlSocios);

            if ($resultSocios->num_rows > 0) { // Exibindo cada linha retornada com a consulta
              while ($exibirSocios = $resultSocios->fetch_assoc()){
                $matricula = $exibirSocios["matriculaAAA"];
                $nome = ucwords($exibirSocios["nome"]);
                $cpf = $exibirSocios["cpf"];
                $telefone = $exibirSocios["telefone"] . "<br>" . $exibirSocios["telefone2"];
                $logradouro = ucwords($exibirSocios["tipoLog"] . " " . rtrim($exibirSocios["logradouro"]) . ", " . $exibirSocios["numero"]);
                $bairro = ucwords($exibirSocios["bairro"]);
                $cidade = ucwords(strtolower($exibirSocios["cidade"]));
                $situacao = ucwords($exibirSocios["rotulo"]);
                $idSituacao = $exibirSocios["fk_idSituacao"];
                if ($exibirSocios["ativo"] == 1) {
                  $vinculo = "Ativo";
                }else{
                  $vinculo = "Inativo";
                }

                if ($vinculo == "Inativo") {
          ?>
                  <tr class="table-danger">
          <?php
                }else{
          ?>
                  <tr>
          <?php
                }
          ?>
                  <td><a href="exibirSocio.php?matricula=<?php echo $matricula; ?>" title="Visualizar Informações"><i style="font-size:20px;" class="fas fa-user"></i> </a></td>
                  <td><?php echo $matricula; ?></td>
                  <td><?php echo $nome; ?></td>
                  <td><?php echo $cpf; ?></td>
                  <td><?php echo $telefone; ?></td>
                  <td><?php echo $logradouro; ?></td>
                  <td><?php echo $bairro; ?></td>
                  <td><?php echo $cidade; ?></td>
                  <?php
                    if ($idSituacao == 1) {
                  ?>
                      <td class="table-success"><?php echo $situacao; ?></td>
                  <?php
                    }else if ($idSituacao == 2) {
                  ?>
                      <td class="table-warning"><?php echo $situacao; ?></td>
                  <?php
                    }else if ($idSituacao == 3) {
                  ?>
                      <td class="table-danger"><?php echo $situacao; ?></td>
                  <?php
                    }
                  ?>
                  <td><?php echo $vinculo; ?></td>
                  <?php
                    if ($idSituacao == 1) {
                  ?>
                      <td>
                        <a href="#" data-toggle="modal" data-target="#gerarDeclaracao" target='_blank'>
                          <i class="fas fa-file"></i> Gerar Declaração
                        </a>
                      </td>
                      <td>
                        <a href='gerarCarteira.php?matricula=<?php echo $matricula; ?>' target='_blank'>
                          <i class="fas fa-address-card"></i> Gerar Carteira
                        </a>
                      </td>
                  <?php
                    }else{
                  ?>
                      <td></td>
                      <td></td>
                  <?php
                    }
                  ?>
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

<!--inicio do modal para digitar o nome da assinatura na declaração-->
<div class="modal fade bd-example-modal-sm" id="gerarDeclaracao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title" id="exampleModalLabel">Gerar Declaração</h3>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">

      <form target="_blank" class="form" action="gerarDeclaracao.php?matricula=<?php echo $matricula; ?>" method="POST" data-toggle="validator">

        <div class="form-group">
          <label for="nome">
            Insira o nome completo do(a) responsável pela assinatura da declaração <span title="obrigatório">*</span>
          </label>
          <input required type="text" class="form-control" id="nome" name="nome"></input>
        </div>
         
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <button type="submit" class="btn btn-primary" name="emitir">Emitir Declaração</button>
    </div>

    </form>

  </div>
  </div>
</div>
<!--fim do modal para digitar o nome da assinatura na declaração-->

<?php
include("include/footerAdm.php");

}else{
  echo "<script>window.location.href='index.php';</script>";
}
?>