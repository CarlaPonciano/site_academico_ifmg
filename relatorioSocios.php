<?php
include("include/headerAdm.php");
if (isset($_SESSION['login'])){
?>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="indexAdmin.php">Página Inicial</a>
  </li>
  <li class="breadcrumb-item active">Relatórios</li>
  <li class="breadcrumb-item active">Associados</li>
</ol>

<!-- DataTables Example -->
<div class="card mb-3">
  <div class="card-header">
    <i class="fas fa-user"></i>
    Associados por Vínculo</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Vínculo</th>
            <th>Quantidade de Associados</th>
            <th>%</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Vínculo</th>
            <th>Quantidade de Associados</th>
            <th>%</th>
          </tr>
        </tfoot>
        <tbody>

          <?php
            $sqlNumSocios = "SELECT COUNT(*) AS 'qtdSocios' 
                              FROM associado;";
            $resultNumSocios = $con->query($sqlNumSocios);
            if ($resultNumSocios->num_rows > 0){
              while ($exibirNumSocios = $resultNumSocios->fetch_assoc()){
                $numSocios = $exibirNumSocios["qtdSocios"];
              } //fim while
            } //fim if

            $sqlNumSociosAtivos = "SELECT COUNT(*) AS 'qtdSociosAtivos' 
                                      FROM associado
                                      WHERE ativo = 1;";
            $resultNumSociosAtivos = $con->query($sqlNumSociosAtivos);
            if ($resultNumSociosAtivos->num_rows > 0){
              while ($exibirNumSociosAtivos = $resultNumSociosAtivos->fetch_assoc()){
                $numSociosAtivos = $exibirNumSociosAtivos["qtdSociosAtivos"];
              } //fim while
            } //fim if

            $sqlNumSociosInativos = "SELECT COUNT(*) AS 'qtdSociosInativos' 
                                      FROM associado
                                      WHERE ativo = 0;";
            $resultNumSociosInativos = $con->query($sqlNumSociosInativos);
            if ($resultNumSociosInativos->num_rows > 0){
              while ($exibirNumSociosInativos = $resultNumSociosInativos->fetch_assoc()){
                $numSociosInativos = $exibirNumSociosInativos["qtdSociosInativos"];
              } //fim while
            } //fim if

            $pSociosAtivos = round((($numSociosAtivos * 100) / $numSocios), 1);
            $pSociosInativos = round((($numSociosInativos * 100) / $numSocios), 1);
          ?>

          <tr>
            <td>Ativo</td>
            <td><?php echo $numSociosAtivos; ?></td>
            <td><?php echo $pSociosAtivos; ?>%</td>
          </tr>
          <tr>
            <td>Inativo</td>
            <td><?php echo $numSociosInativos; ?></td>
            <td><?php echo $pSociosInativos; ?>%</td>
          </tr>
          <tr class="table-active">
            <td><strong>Total</strong></td>
            <td><strong><?php echo $numSocios; ?></strong></td>
            <td><strong>100%</strong></td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- DataTables Example -->
<div class="card mb-3">
  <div class="card-header">
    <i class="fas fa-user"></i>
    Associados Ativos por Situação</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Situação</th>
            <th>Quantidade de Associados</th>
            <th>%</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Situação</th>
            <th>Quantidade de Associados</th>
            <th>%</th>
          </tr>
        </tfoot>
        <tbody>

          <?php
            $sqlNumSociosRegulares = "SELECT COUNT(*) AS 'qtdSociosRegulares' FROM associado
                                          WHERE ativo = 1 
                                          AND fk_idSituacao = 1;";
            $resultNumSociosRegulares = $con->query($sqlNumSociosRegulares);
            if ($resultNumSociosRegulares->num_rows > 0){
              while ($exibirNumSociosRegulares = $resultNumSociosRegulares->fetch_assoc()){
                $numSociosRegulares = $exibirNumSociosRegulares["qtdSociosRegulares"];
              } //fim while
            } //fim if

            $sqlNumSociosAtraso = "SELECT COUNT(*) AS 'qtdSociosAtraso' FROM associado
                                      WHERE ativo = 1
                                      AND fk_idSituacao = 2;";
            $resultNumSociosAtraso = $con->query($sqlNumSociosAtraso);
            if ($resultNumSociosAtraso->num_rows > 0){
              while ($exibirNumSociosAtraso = $resultNumSociosAtraso->fetch_assoc()){
                $numSociosAtraso = $exibirNumSociosAtraso["qtdSociosAtraso"];
              } //fim while
            } //fim if

            $sqlNumSociosInadimplentes = "SELECT COUNT(*) AS 'qtdSociosInadimplentes' FROM associado
                                      WHERE ativo = 1
                                      AND fk_idSituacao = 3;";
            $resultNumSociosInadimplentes = $con->query($sqlNumSociosInadimplentes);
            if ($resultNumSociosInadimplentes->num_rows > 0){
              while ($exibirNumSociosInadimplentes = $resultNumSociosInadimplentes->fetch_assoc()){
                $numSociosInadimplentes = $exibirNumSociosInadimplentes["qtdSociosInadimplentes"];
              } //fim while
            } //fim if

            $pSociosRegulares = round((($numSociosRegulares * 100) / $numSociosAtivos), 1);
            $pSociosAtraso = round((($numSociosAtraso * 100) / $numSociosAtivos), 1);
            $pSociosInadimplentes = round((($numSociosInadimplentes * 100) / $numSociosAtivos), 1);
          ?>

          <tr> 
            <td>Regular</td>
            <td><?php echo $numSociosRegulares; ?></td>
            <td><?php echo $pSociosRegulares; ?>%</td>
          </tr>
          <tr>
            <td>Em Atraso</td>
            <td><?php echo $numSociosAtraso; ?></td>
            <td><?php echo $pSociosAtraso; ?>%</td>
          </tr>
          <tr>
            <td>Inadimplente</td>
            <td><?php echo $numSociosInadimplentes; ?></td>
            <td><?php echo $pSociosInadimplentes; ?>%</td>
          </tr>
          <tr class="table-active">
            <td><strong>Total</strong></td>
            <td><strong><?php echo $numSociosAtivos; ?></strong></td>
            <td><strong>100%</strong></td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- DataTables Example -->
<div class="card mb-3">
  <div class="card-header">
    <i class="fas fa-user"></i>
    Associados Ativos por Idade</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Idade</th>
            <th>Quantidade de Associados</th>
            <th>%</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Idade</th>
            <th>Quantidade de Associados</th>
            <th>%</th>
          </tr>
        </tfoot>
        <tbody>

          <?php
            //sócios com idade menor que 10 anos
            $sqlAte10 = "SELECT COUNT(TIMESTAMPDIFF(YEAR, dataNascimento, NOW())) AS 'qtdAte10' 
                          FROM associado 
                          WHERE TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) < 10 
                          AND ativo = 1;";
            $resultAte10 = $con->query($sqlAte10);
            if ($resultAte10->num_rows > 0){
              while ($exibirAte10 = $resultAte10->fetch_assoc()){
                $qtdAte10 = $exibirAte10["qtdAte10"];
              } //fim while
            } //fim if

            //sócios com idade de 10 a 20 anos
            $sql10a20 = "SELECT COUNT(TIMESTAMPDIFF(YEAR, dataNascimento, NOW())) AS 'qtd10a20' 
                          FROM associado 
                          WHERE TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) >= 10 
                          AND TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) < 20 
                          AND ativo = 1;";
            $result10a20 = $con->query($sql10a20);
            if ($result10a20->num_rows > 0){
              while ($exibir10a20 = $result10a20->fetch_assoc()){
                $qtd10a20 = $exibir10a20["qtd10a20"];
              } //fim while
            } //fim if

            //sócios com idade de 20 a 30 anos
            $sql20a30 = "SELECT COUNT(TIMESTAMPDIFF(YEAR, dataNascimento, NOW())) AS 'qtd20a30' 
                          FROM associado 
                          WHERE TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) >= 20 
                          AND TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) < 30 
                          AND ativo = 1;";
            $result20a30 = $con->query($sql20a30);
            if ($result20a30->num_rows > 0){
              while ($exibir20a30 = $result20a30->fetch_assoc()){
                $qtd20a30 = $exibir20a30["qtd20a30"];
              } //fim while
            } //fim if

            //sócios com idade de 30 a 40 anos
            $sql30a40 = "SELECT COUNT(TIMESTAMPDIFF(YEAR, dataNascimento, NOW())) AS 'qtd30a40' 
                          FROM associado 
                          WHERE TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) >= 30 
                          AND TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) < 40 
                          AND ativo = 1;";
            $result30a40 = $con->query($sql30a40);
            if ($result30a40->num_rows > 0){
              while ($exibir30a40 = $result30a40->fetch_assoc()){
                $qtd30a40 = $exibir30a40["qtd30a40"];
              } //fim while
            } //fim if

            //sócios com idade de 40 a 50 anos
            $sql40a50 = "SELECT COUNT(TIMESTAMPDIFF(YEAR, dataNascimento, NOW())) AS 'qtd40a50' 
                          FROM associado 
                          WHERE TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) >= 40 
                          AND TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) < 50 
                          AND ativo = 1;";
            $result40a50 = $con->query($sql40a50);
            if ($result40a50->num_rows > 0){
              while ($exibir40a50 = $result40a50->fetch_assoc()){
                $qtd40a50 = $exibir40a50["qtd40a50"];
              } //fim while
            } //fim if

            //sócios com idade de 50 a 60 anos
            $sql50a60 = "SELECT COUNT(TIMESTAMPDIFF(YEAR, dataNascimento, NOW())) AS 'qtd50a60' 
                          FROM associado 
                          WHERE TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) >= 50 
                          AND TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) < 60 
                          AND ativo = 1;";
            $result50a60 = $con->query($sql50a60);
            if ($result50a60->num_rows > 0){
              while ($exibir50a60 = $result50a60->fetch_assoc()){
                $qtd50a60 = $exibir50a60["qtd50a60"];
              } //fim while
            } //fim if

            //sócios com idade de 60 a 70 anos
            $sql60a70 = "SELECT COUNT(TIMESTAMPDIFF(YEAR, dataNascimento, NOW())) AS 'qtd60a70' 
                          FROM associado 
                          WHERE TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) >= 60 
                          AND TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) < 70 
                          AND ativo = 1;";
            $result60a70 = $con->query($sql60a70);
            if ($result60a70->num_rows > 0){
              while ($exibir60a70 = $result60a70->fetch_assoc()){
                $qtd60a70 = $exibir60a70["qtd60a70"];
              } //fim while
            } //fim if

            //sócios com idade de 70 a 80 anos
            $sql70a80 = "SELECT COUNT(TIMESTAMPDIFF(YEAR, dataNascimento, NOW())) AS 'qtd70a80' 
                          FROM associado 
                          WHERE TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) >= 70 
                          AND TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) < 80 
                          AND ativo = 1;";
            $result70a80 = $con->query($sql70a80);
            if ($result70a80->num_rows > 0){
              while ($exibir70a80 = $result70a80->fetch_assoc()){
                $qtd70a80 = $exibir70a80["qtd70a80"];
              } //fim while
            } //fim if

            //sócios com idade de 80 a 90 anos
            $sql80a90 = "SELECT COUNT(TIMESTAMPDIFF(YEAR, dataNascimento, NOW())) AS 'qtd80a90' 
                          FROM associado 
                          WHERE TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) >= 80 
                          AND TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) < 90 
                          AND ativo = 1;";
            $result80a90 = $con->query($sql80a90);
            if ($result80a90->num_rows > 0){
              while ($exibir80a90 = $result80a90->fetch_assoc()){
                $qtd80a90 = $exibir80a90["qtd80a90"];
              } //fim while
            } //fim if

            //sócios com idade de 90 a 100 anos
            $sql90a100 = "SELECT COUNT(TIMESTAMPDIFF(YEAR, dataNascimento, NOW())) AS 'qtd90a100' 
                          FROM associado 
                          WHERE TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) >= 90 
                          AND TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) < 100 
                          AND ativo = 1;";
            $result90a100 = $con->query($sql90a100);
            if ($result90a100->num_rows > 0){
              while ($exibir90a100 = $result90a100->fetch_assoc()){
                $qtd90a100 = $exibir90a100["qtd90a100"];
              } //fim while
            } //fim if

            //sócios com idade maior que 100 anos
            $sqlAcima100 = "SELECT COUNT(TIMESTAMPDIFF(YEAR, dataNascimento, NOW())) AS 'qtdAcima100' 
                          FROM associado 
                          WHERE TIMESTAMPDIFF(YEAR, dataNascimento, NOW()) >= 100 
                          AND ativo = 1;";
            $resultAcima100 = $con->query($sqlAcima100);
            if ($resultAcima100->num_rows > 0){
              while ($exibirAcima100 = $resultAcima100->fetch_assoc()){
                $qtdAcima100 = $exibirAcima100["qtdAcima100"];
              } //fim while
            } //fim if

            //sócios com idade diferente de nula
            $sqlIdadeNotNull = "SELECT count(*) AS 'qtdIdadeNotNull'
                              FROM associado 
                              WHERE dataNascimento != '0000-00-00' 
                              AND ativo = 1;";
            $resultIdadeNotNull = $con->query($sqlIdadeNotNull);
            if ($resultIdadeNotNull->num_rows > 0){
              while ($exibirIdadeNotNull = $resultIdadeNotNull->fetch_assoc()){
                $qtdIdadeNotNull = $exibirIdadeNotNull["qtdIdadeNotNull"];
              } //fim while
            } //fim if

            $pAte10 = round((($qtdAte10 * 100) / $qtdIdadeNotNull), 1);
            $p10a20 = round((($qtd10a20 * 100) / $qtdIdadeNotNull), 1);
            $p20a30 = round((($qtd20a30 * 100) / $qtdIdadeNotNull), 1);
            $p30a40 = round((($qtd30a40 * 100) / $qtdIdadeNotNull), 1);
            $p40a50 = round((($qtd40a50 * 100) / $qtdIdadeNotNull), 1);
            $p50a60 = round((($qtd50a60 * 100) / $qtdIdadeNotNull), 1);
            $p60a70 = round((($qtd60a70 * 100) / $qtdIdadeNotNull), 1);
            $p70a80 = round((($qtd70a80 * 100) / $qtdIdadeNotNull), 1);
            $p80a90 = round((($qtd80a90 * 100) / $qtdIdadeNotNull), 1);
            $p90a100 = round((($qtd90a100 * 100) / $qtdIdadeNotNull), 1);
            $pAcima100 = round((($qtdAcima100 * 100) / $qtdIdadeNotNull), 1);
          ?>

          <tr>
            <td>Até 10 anos</td>
            <td><?php echo $qtdAte10; ?></td>
            <td><?php echo $pAte10; ?>%</td>
          </tr>
          <tr>
            <td>10 a 20 anos</td>
            <td><?php echo $qtd10a20; ?></td>
            <td><?php echo $p10a20; ?>%</td>
          </tr>
          <tr>
            <td>20 a 30 anos</td>
            <td><?php echo $qtd20a30; ?></td>
            <td><?php echo $p20a30; ?>%</td>
          </tr>
          <tr>
            <td>30 a 40 anos</td>
            <td><?php echo $qtd30a40; ?></td>
            <td><?php echo $p30a40; ?>%</td>
          </tr>
          <tr>
            <td>40 a 50 anos</td>
            <td><?php echo $qtd40a50; ?></td>
            <td><?php echo $p40a50; ?>%</td>
          </tr>
          <tr>
            <td>50 a 60 anos</td>
            <td><?php echo $qtd50a60; ?></td>
            <td><?php echo $p50a60; ?>%</td>
          </tr>
          <tr>
            <td>60 a 70 anos</td>
            <td><?php echo $qtd60a70; ?></td>
            <td><?php echo $p60a70; ?>%</td>
          </tr>
          <tr>
            <td>70 a 80 anos</td>
            <td><?php echo $qtd70a80; ?></td>
            <td><?php echo $p70a80; ?>%</td>
          </tr>
          <tr>
            <td>80 a 90 anos</td>
            <td><?php echo $qtd80a90; ?></td>
            <td><?php echo $p80a90; ?>%</td>
          </tr>
          <tr>
            <td>90 a 100 anos</td>
            <td><?php echo $qtd90a100; ?></td>
            <td><?php echo $p90a100; ?>%</td>
          </tr>
          <tr>
            <td>100 anos ou mais</td>
            <td><?php echo $qtdAcima100; ?></td>
            <td><?php echo $pAcima100; ?>%</td>
          </tr>
          <tr class="table-active">
            <td><strong>Total</strong></td>
            <td><strong><?php echo $qtdIdadeNotNull; ?></strong></td>
            <td><strong>100%</strong></td>
          </tr>

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