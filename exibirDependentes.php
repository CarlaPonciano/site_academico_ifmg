<?php
include("include/headerAdm.php");
if (isset($_SESSION['login'])){
?>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="indexAdmin.php">Página Inicial</a>
  </li>
  <li class="breadcrumb-item active">Consultar</li>
  <li class="breadcrumb-item active">Dependentes</li>
</ol>

<!-- DataTables Example -->
<div class="card mb-3">
  <div class="card-header">
    <i class="fas fa-users"></i>
    Dependentes</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Ações</th>
            <th>Matrícula do Sócio</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>E-mail</th>
            <th>Parentesco</th>
            <th>Tipo</th>
            <th>Situação</th>
            <th>Vínculo</th>
            <th>Declaração</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Ações</th>
            <th>Matrícula do Sócio</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>E-mail</th>
            <th>Parentesco</th>
            <th>Tipo</th>
            <th>Situação</th>
            <th>Vínculo</th>
            <th>Declaração</th>
          </tr>
        </tfoot>
        <tbody>

          <?php

            $sqlDep = "SELECT A.matriculaAAA, U.nome, T.telefone, T.telefone2, U.cpf, D.idDependente, D.email, P.parentesco, D.agregado, S.rotulo, A.fk_idSituacao, A.ativo
                          FROM usuario AS U, associado AS A, telefone AS T, situacao AS S, dependente AS D, parentesco AS P
                          WHERE U.tipo = 'dependente'
                          AND U.idUsuario = D.fk_idUsuario
                          AND U.idUsuario = T.fk_idUsuario
                          AND A.idAssociado = D.fk_idAssociado
                          AND S.idSituacao = A.fk_idSituacao
                          AND P.idParentesco = D.fk_idParentesco
                          ORDER BY U.nome;";

            $resultDep = $con->query($sqlDep);

            if ($resultDep->num_rows > 0) { // Exibindo cada linha retornada com a consulta
              while ($exibirDep = $resultDep->fetch_assoc()){
                $matricula = $exibirDep["matriculaAAA"];
                $nome = ucwords(strtolower($exibirDep["nome"]));
                $cpf = $exibirDep["cpf"];
                $telefone = $exibirDep["telefone"] . "<br>" . $exibirDep["telefone2"];
                $idDependente = $exibirDep["idDependente"];
                $email = $exibirDep["email"];
                $parentesco = ucwords(strtolower($exibirDep["parentesco"]));
                if ($exibirDep["agregado"] == 1) {
                  $tipo = "Dependente-Agregado";
                }else{
                  $tipo = "Dependente";
                }
                $idSituacao = $exibirDep["fk_idSituacao"];
                $situacao = ucwords($exibirDep["rotulo"]);
                if ($exibirDep["ativo"] == 1) {
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
                  <td><?php echo $email; ?></td>
                  <td><?php echo $parentesco; ?></td>
                  <td><?php echo $tipo; ?></td>
                  <?php
                    if ($idSituacao == 1) {
                  ?>
                      <td class="table-success"><?php echo $situacao; ?></td>
                      <td><?php echo $vinculo; ?></td>
                      <td>
                        <a href='nomeAssinaturaDeclaracao.php?matricula=<?php echo $matricula; ?>' target='_blank'>
                          <i class="fas fa-file"></i> Gerar Declaração
                        </a>
                      </td>
                  <?php
                    }else if ($idSituacao == 2) {
                  ?>
                      <td class="table-warning"><?php echo $situacao; ?></td>
                      <td><?php echo $vinculo; ?></td>
                      <td></td>
                  <?php
                    }else if ($idSituacao == 3) {
                  ?>
                      <td class="table-danger"><?php echo $situacao; ?></td>
                      <td><?php echo $vinculo; ?></td>
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

<?php
include("include/footerAdm.php");

}else{
  echo "<script>window.location.href='index.php';</script>";
}
?>