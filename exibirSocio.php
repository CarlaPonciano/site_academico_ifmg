<?php
include("include/headerAdm.php");
if (isset($_SESSION['login'])){
  $tipoLogin = $_SESSION["tipo"];
  if (($tipoLogin == 'socio') || ($tipoLogin == 'dependente')) {
?>
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Meus Dados</li>
    </ol>
<?php
  }else{
?>
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="indexAdmin.php" style="color: #0056C0;">Página Inicial</a>
      </li>
      <li class="breadcrumb-item"><a style="color: #0056C0;" href="exibirSocios.php">Associados</a></li>
      <li class="breadcrumb-item active">Visualizar Sócio</li>
    </ol>
<?php
  }
?>

<style>
  a{
    color: #212529;
  }
</style>

<div class="card mb-3">
  <a href="#dados" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="dados">
    <i class="fas fa-user"></i>
    Dados Pessoais
  </a>

  <div class="collapse" id="dados">
    <div class="card-body">

      <?php 
        $matricula = $_GET["matricula"];

        $imgUsuario = ""; $img = false;

        $sqlIU = "SELECT IU.imgUsuario 
                  FROM imgUsuario AS IU, associado AS A 
                  WHERE IU.fk_idUsuario = A.fk_idUsuario 
                  AND A.matriculaAAA = '" . $matricula . "';";

        $resultIU = $con->query($sqlIU);
        if ($resultIU->num_rows > 0) {
          $img = true;
          while ($exibirIU = $resultIU->fetch_assoc()) {
            $imgUsuario = $exibirIU["imgUsuario"];
          }
        }

        $sqlDados = "SELECT A.idAssociado, U.nome, U.cpf, A.mae, A.pai, A.dataNascimento, TIMESTAMPDIFF(YEAR, A.dataNascimento, NOW()) AS 'idade', G.genero, P.nomePT, A.naturalidade, EC.estadoCivil, A.rg, GS.grupoSanguineo
                      FROM usuario AS U, associado AS A, genero AS G, pais AS P, estadoCivil AS EC, grupoSanguineo AS GS
                      WHERE U.tipo = 'socio'
                      AND U.idUsuario = A.fk_idUsuario
                      AND G.idGenero = A.fk_idGenero
                      AND P.idPais = A.fk_idNacionalidade
                      AND EC.idEstadoCivil = A.fk_idEstadoCivil
                      AND GS.idGrupoSanguineo = A.fk_idGrupoSanguineo
                      AND A.matriculaAAA = " . $matricula;

        $resultDados = $con->query($sqlDados);

        if ($resultDados->num_rows > 0) { // Exibindo cada linha retornada com a consulta
          while ($exibirDados = $resultDados->fetch_assoc()){
            $idAssociado = $exibirDados["idAssociado"];
            $nome = ucwords($exibirDados["nome"]);
            $mae = ucwords($exibirDados["mae"]);
            $pai = ucwords($exibirDados["pai"]);
            $cpf = $exibirDados["cpf"];
            $rg = strtoupper($exibirDados["rg"]);
            $dataNascimento = date("d/m/Y", strtotime($exibirDados["dataNascimento"]));
            $idade = $exibirDados["idade"];
            $genero = ucwords(strtolower($exibirDados["genero"]));
            $nacionalidade = $exibirDados["nomePT"];
            $naturalidade = ucwords(strtolower($exibirDados["naturalidade"]));
            $estadoCivil = ucwords(strtolower($exibirDados["estadoCivil"]));
            $grupoSanguineo = ucwords(strtolower($exibirDados["grupoSanguineo"]));
          }
        }

        if ($img) {
      ?>
          <img class="float-right" src=imgUsuario/<?php echo $imgUsuario;?> style='max-width: 100px;'>
      <?php
        } else {
      ?>
          <img class="float-right" src=imgUsuario/padrao.png style='max-width: 100px;'>
      <?php
        }
      ?>

      <b>Nome: </b><?php echo $nome; ?>
      <br>
      <b>Mãe: </b><?php echo $mae; ?>
      <br>
      <b>Pai: </b><?php echo $pai; ?>
      <br>
      <b>Data de Nascimento: </b><?php echo $dataNascimento; ?>
      <br>
      <b>Idade: </b><?php echo $idade; ?>
      <br>
      <b>Gênero: </b><?php echo $genero; ?>
      <br>
      <b>Estado Civil: </b><?php echo $estadoCivil; ?>
      <br>
      <b>Grupo Sanguíneo: </b><?php echo $grupoSanguineo; ?>
      <br>
      <b>CPF: </b><?php echo $cpf; ?>
      <br>
      <b>RG: </b><?php echo $rg; ?>
      <br>
      <b>Nacionalidade: </b><?php echo $nacionalidade; ?>
      <br>
      <b>Naturalidade: </b><?php echo $naturalidade; ?>
      <br>
      <b>Documentos: </b>
      <br>
      
      <?php
        $sqlDocs = "SELECT ID.imgDoc 
                    FROM imgDoc AS ID, associado AS A 
                    WHERE ID.fk_idUsuario = A.fk_idUsuario 
                    AND A.matriculaAAA = ".$matricula.";";

        $resultDocs = $con->query($sqlDocs);
        if ($resultDocs->num_rows > 0) {
          while ($rowsDocs = $resultDocs->fetch_assoc()) {
      ?>
            <img src=imgDoc/<?php echo $rowsDocs["imgDoc"]; ?> style='max-width: 100px;'></img>
      <?php 
          }        
        }  
      ?>
      
    </div>
  </div>
</div>

<div class="card mb-3">

  <a href="#contato" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="contato">
    <i class="fas fa-envelope"></i>
    Dados de Contato
  </a>

  <div class="collapse" id="contato">
    <div class="card-body">

      <?php 

        $sqlContato = "SELECT A.email, T.telefone, T.telefone2
                      FROM usuario AS U, associado AS A, telefone AS T
                      WHERE U.tipo = 'socio'
                      AND U.idUsuario = A.fk_idUsuario
                      AND U.idUsuario = T.fk_idUsuario
                      AND A.matriculaAAA = " . $matricula;

        $resultContato = $con->query($sqlContato);

        if ($resultContato->num_rows > 0) { // Exibindo cada linha retornada com a consulta
          while ($exibirContato = $resultContato->fetch_assoc()){
            $email = $exibirContato["email"];
            if ($exibirContato["telefone2"] != null) {
              $telefone = $exibirContato["telefone"] . " / " . $exibirContato["telefone2"];
            }else{
              $telefone = $exibirContato["telefone"];
            }
          }
        }
      ?>

      <b>E-mail: </b><?php echo $email; ?>
      <br>
      <b>Telefone: </b><?php echo $telefone; ?>
      
    </div>
  </div>
</div>

<div class="card mb-3">
  <a href="#endereco" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="endereco">
    <i class="fas fa-map-marker-alt"></i>
    Endereço
  </a>

  <div class="collapse" id="endereco">
    <div class="card-body">

      <?php 

        $sqlEndereco = "SELECT A.tipoLog, A.logradouro, A.numero, A.bairro, A.complemento, A.cidade, A.estado, A.cep, P.nomePT
                      FROM usuario AS U, associado AS A, pais AS P
                      WHERE U.tipo = 'socio'
                      AND U.idUsuario = A.fk_idUsuario
                      AND P.idPais = A.fk_idPais
                      AND A.matriculaAAA = " . $matricula;

        $resultEndereco = $con->query($sqlEndereco);

        if ($resultEndereco->num_rows > 0) { // Exibindo cada linha retornada com a consulta
          while ($exibirEndereco = $resultEndereco->fetch_assoc()){
            if ($exibirEndereco["complemento"] != null) {
              $logradouro = ucwords($exibirEndereco["tipoLog"] . " " . rtrim($exibirEndereco["logradouro"]) . ", " . $exibirEndereco["numero"] . ", " . $exibirEndereco["complemento"]);
            }else{
              $logradouro = ucwords($exibirEndereco["tipoLog"] . " " . rtrim($exibirEndereco["logradouro"]) . ", " . $exibirEndereco["numero"]);
            }
            $bairro = ucwords($exibirEndereco["bairro"]);
            $cidade = ucwords(strtolower($exibirEndereco["cidade"]));
            $estado = $exibirEndereco["estado"];
            $cep = $exibirEndereco["cep"];
            $pais = $exibirEndereco["nomePT"];
          }
        }
      ?>

      <b>Logradouro: </b><?php echo $logradouro; ?>
      <br>
      <b>Bairro: </b><?php echo $bairro; ?>
      <br>
      <b>Cidade: </b><?php echo $cidade; ?>
      <br>
      <b>Estado: </b><?php echo $estado; ?>
      <br>
      <b>País: </b><?php echo $pais; ?>
      <br>
      <b>CEP: </b><?php echo $cep; ?>
      
    </div>
  </div>
</div>



<div class="card mb-3">
  <a href="#apos" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="apos">
    <i class="fas fa-briefcase"></i>
    Aposentadoria
  </a>

  <div class="collapse" id="apos">
    <div class="card-body">

      <?php 

        $sqlApos = "SELECT A.inss, A.carteiraTrabalho, A.serieCT, A.empresa, A.profissao, A.dataAposentadoria, E.nivel, E.situacao
                      FROM usuario AS U, associado AS A, escolaridade AS E
                      WHERE U.tipo = 'socio'
                      AND U.idUsuario = A.fk_idUsuario
                      AND E.idEscolaridade = A.fk_idEscolaridade
                      AND A.matriculaAAA = " . $matricula;

        $resultApos = $con->query($sqlApos);

        if ($resultApos->num_rows > 0) { // Exibindo cada linha retornada com a consulta
          while ($exibirApos = $resultApos->fetch_assoc()){
            $inss = $exibirApos["inss"];
            $carteiraTrabalho = $exibirApos["carteiraTrabalho"];
            $serieCT = $exibirApos["serieCT"];
            $empresa = $exibirApos["empresa"];
            $profissao = $exibirApos["profissao"];
            $dataAposentadoria = date("d/m/Y", strtotime($exibirApos["dataAposentadoria"]));
            $escolaridade = $exibirApos["nivel"] . " " . $exibirApos["situacao"];
          }
        }
      ?>

      <b>INSS: </b><?php echo $inss; ?>
      <br>
      <b>Carteira de Trabalho: </b><?php echo $carteiraTrabalho; ?>
      <br>
      <b>Série: </b><?php echo $serieCT; ?>
      <br>
      <b>Empresa: </b><?php echo $empresa; ?>
      <br>
      <b>Profissão: </b><?php echo $profissao; ?>
      <br>
      <b>Escolaridade: </b><?php echo $escolaridade; ?>
      <br>
      <b>Data de Aposentadoria: </b><?php echo $dataAposentadoria; ?>
      
    </div>
  </div>
</div>

<div class="card mb-3">
  <a href="#aaa" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="aaa">
    <img class="img-fluid rounded" src="imagens/logo-aaa-preto.png" alt="" style="height: 15px;">
    Associação dos Aposentados e Pensionistas de Ouro Branco
  </a>

  <div class="collapse" id="aaa">
    <div class="card-body">

      <?php 

        $sqlAAA = "SELECT S.rotulo, A.ativo, A.fk_idSituacao
                      FROM usuario AS U, associado AS A, situacao AS S
                      WHERE U.tipo = 'socio'
                      AND U.idUsuario = A.fk_idUsuario
                      AND S.idSituacao = A.fk_idSituacao
                      AND A.matriculaAAA = " . $matricula;

        $resultAAA = $con->query($sqlAAA);

        if ($resultAAA->num_rows > 0) { // Exibindo cada linha retornada com a consulta
          while ($exibirAAA = $resultAAA->fetch_assoc()){
            $idSituacao = $exibirAAA["fk_idSituacao"];
            $situacao = ucwords(strtolower($exibirAAA["rotulo"]));
            if ($exibirAAA["ativo"] == 1) {
              $vinculo = "Ativo";
            }else{
              $vinculo = "Inativo";
            }
          }
        }
      ?>

      <b>Matrícula: </b><?php echo $matricula; ?>
      <br>
      <b>Situação: </b><?php echo $situacao; ?>
      <br>
      <b>Vínculo: </b><?php echo $vinculo; ?>
      
    </div>
  </div>
</div>

<div class="card mb-3">
  <a href="#dependentes" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="dependentes">
    <i class="fas fa-users"></i>
    Dependentes
  </a>

  <div class="collapse" id="dependentes">
    <div class="card-body">

      <?php 

        $sqlDep = "SELECT U.nome, U.cpf, D.dataNascimento, D.email, D.agregado, G.genero, P.parentesco
                      FROM usuario AS U, associado AS A, dependente AS D, genero AS G, parentesco AS P
                      WHERE U.tipo = 'dependente'
                      AND U.idUsuario = D.fk_idUsuario
                      AND A.idAssociado = D.fk_idAssociado
                      AND G.idGenero = D.fk_idGenero
                      AND P.idParentesco = D.fk_idParentesco
                      AND D.fk_idAssociado = " . $idAssociado;

        $resultDep = $con->query($sqlDep);

        if ($resultDep->num_rows > 0) { // Exibindo cada linha retornada com a consulta
          while ($exibirDep = $resultDep->fetch_assoc()){
            $nomeDep = ucwords(strtolower($exibirDep["nome"]));
            $dataNascimentoDep = date("d/m/Y", strtotime($exibirApos["dataNascimento"]));
            $cpfDep = $exibirDep["cpf"];
            $emailDep = $exibirDep["email"];
            $generoDep = ucwords(strtolower($exibirDep["genero"]));
            $parentesco = ucwords(strtolower($exibirDep["parentesco"]));
            if ($exibirDep["agregado"] == 1) {
              $tipo = "Dependente-Agregado";
            }else{
              $tipo = "Dependente";
            }
      ?>

            <b>Nome: </b><?php echo $nomeDep; ?>
            <br>
            <b>Data de Nascimento: </b><?php echo $dataNascimentoDep; ?>
            <br>
            <b>CPF: </b><?php echo $cpfDep; ?>
            <br>
            <b>Gênero: </b><?php echo $generoDep; ?>
            <br>
            <b>E-mail: </b><?php echo $emailDep; ?>
            <br>
            <b>Parentesco: </b><?php echo $parentesco; ?>
            <br>
            <b>Tipo: </b><?php echo $tipo; ?>
            <br><br>

      <?php
          }
        }
      ?>
      
    </div>
  </div>
</div>

<div class="card mb-3">
  <a href="#mensalidades" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="mensalidades">
    <i class="fas fa-money-check"></i>
    Mensalidades
  </a>

  <div class="collapse" id="mensalidades">
    <div class="card-body">

      <table class="table table-striped table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Mês de Referência</th>
            <th>Valor</th>
            <th>Data de Pagamento</th>
            <th>Vencimento</th>
            <th>Recibo</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Mês de Referência</th>
            <th>Valor</th>
            <th>Data de Pagamento</th>
            <th>Vencimento</th>
            <th>Recibo</th>
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

        $sqlMens = "SELECT M.valor, M.idMensalidade, M.dataPagamento, M.dataReferenciaInicial, M.dataReferenciaFinal
                    FROM mensalidade AS M, associado AS A
                    WHERE M.fk_idAssociado = A.idAssociado 
                    AND M.fk_idAssociado = " . $idAssociado . "
                    ORDER BY dataReferenciaInicial DESC";

        $resultMens = $con->query($sqlMens);
        
        if ($resultMens->num_rows > 0) {
          while ($row = $resultMens->fetch_assoc()) {
            $idMensalidade = $row['idMensalidade'];
            $valor = $row['valor'];
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
              <td><?php echo ucwords($mesesReferencia); ?></td>
              <td>R$ <?php echo $valor; ?></td>
              <td><?php echo $dataPagamento; ?></td>
              <td><?php echo $vencimento; ?></td>
              <td><a href='gerarRecibo.php?idMensalidade=<?php echo $idMensalidade; ?>' target='_blank'><i class="fas fa-money-check" style="color:#0069d9"></i></a></td>
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

<div class="card mb-3">
  <a href="#debitos" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="debitos">
    <i class="fas fa-money-check"></i>
    Débitos
  </a>

  <div class="collapse" id="debitos">
    <div class="card-body">

      <table class="table table-striped table-bordered table-responsive" id="dataTableDeb" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Mês de Referência</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Mês de Referência</th>
          </tr>
        </tfoot>
        <tbody>

      <?php 

          $diff1Month = new DateInterval('P1M');
          $today = new DateTime();
          $today->setTimezone(new DateTimeZone('America/Sao_Paulo'));
          $today->format('Y\-m\-d');

          $minInicial = new DateTime();
          $minInicial->setTimezone(new DateTimeZone('America/Sao_Paulo'));
          $minInicial->format('Y\-m\-d');

          //Seleciona o primeiro mês de pagamento da mensalidade.

          $sqlMes1Pgto = "SELECT MIN(dataReferenciaInicial), dataReferenciaFinal 
                          FROM mensalidade 
                          WHERE fk_idAssociado = '" . $idAssociado . "';";

          $res = $con->query($sqlMes1Pgto) or die($con->error);

          if ($res->num_rows > 0) {
              while ($r = $res->fetch_assoc()) {
                  if (!is_null($r['MIN(dataReferenciaInicial)'])) {
                      $minInicial = DateTime::createFromFormat('Y-m-d', $r['MIN(dataReferenciaInicial)']);
                  }
              }
          }

          $miss = false;
          $return = array();

          $interval = $today->diff($minInicial);
          $d = $interval->format('%m');
          $y = $interval->format('%y');
          $d = $d + (12 * $y);

          //Seleciona os meses NÃO pagos até a data atual.

          while ($d > 0) {
              $sqlMesesNaoPg = "SELECT dataReferenciaInicial 
                                FROM mensalidade 
                                WHERE dataReferenciaInicial = '" . $minInicial->format("Y-m-d") . "' 
                                AND fk_idAssociado = '" . $idAssociado . "';";

              $res = $con->query($sqlMesesNaoPg) or die($con->error);

              if ($res->num_rows > 0) {

              } else {
                  $return[] = ucwords($MES[$minInicial->format("n")]) . "/" . $minInicial->format("Y");
              }

              $minInicial = $minInicial->add($diff1Month);

              $d--;
          }

          if(isset($return)){
            $debito = "";

            if (count($return) > 0) {
              foreach ($return as $value) {
      ?>
                <tr>
                  <td><?php echo $value; ?></td>
                </tr>
      <?php
              }
            }
          }
      ?>

        </tbody>
      </table>
      
    </div>
  </div>
</div>

<div class="card mb-3">

  <a href="#desligamento" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="contato">
    <i class="fas fa-user-slash"></i>
    Histórico de Desligamento
  </a>

  <div class="collapse" id="desligamento">
    <div class="card-body">

      <table class="table table-striped table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Vínculo</th>
            <th>Data</th>
            <th>Observação</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Vínculo</th>
            <th>Data</th>
            <th>Observação</th>
          </tr>
        </tfoot>
        <tbody>

      <?php 

        $sqlDesligamento = "SELECT D.dataDesligamento, D.vinculo, D.observacao
                      FROM associado AS A, desligamento AS D
                      WHERE A.idAssociado = D.fk_idAssociado
                      AND A.matriculaAAA = " . $matricula;

        $resultDesligamento = $con->query($sqlDesligamento);

        if ($resultDesligamento->num_rows > 0) { // Exibindo cada linha retornada com a consulta
          while ($exibirDesligamento = $resultDesligamento->fetch_assoc()){
            $dataDesligamento = date("d/m/Y", strtotime($exibirDesligamento["dataDesligamento"]));
            $observacao = $exibirDesligamento["observacao"];
            if ($exibirDesligamento["vinculo"] == 1) {
              $vinculo = "Ativo";
            }else{
              $vinculo = "Inativo";
            }
      ?>
            <tr>
              <td><?php echo $vinculo; ?></td>
              <td><?php echo $dataDesligamento; ?></td>
              <td><?php echo $observacao; ?></td>
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
  if (($tipoLogin == "1") || ($tipoLogin == "3") || ($tipoLogin == "4")) {
    if ($idSituacao == 1) {
?>
      <div class="float-left">

        <a class="btn btn-info" href="#" data-toggle="modal" data-target="#gerarDeclaracao" target="_blank"><i class="fas fa-file"></i> Gerar declaração</a>

        <a href='gerarCarteira.php?matricula=<?php echo $matricula; ?>' target='_blank' class="btn btn-info"><i class="fas fa-address-card"></i> Gerar carteira</a>

      </div>
<?php
    }
?>
    <div class="float-right">

      <a href = "editarSocio.php?matricula=<?php echo $matricula; ?>" class="btn btn-primary"><i class="far fa-edit"></i> Editar dados do associado</a>

      <a href="" data-toggle="modal" data-target="#editarDependentes" class="btn btn-primary"><i class="far fa-edit"></i> Editar dependentes</a>

      <!--<a href="cadastrarDesligamento.php" class="btn btn-primary"><i class="fas fa-user-slash"></i> Editar vínculo</a>-->

    </div>
<?php
  }else if (($tipoLogin == 'socio') || ($tipoLogin == 'dependente')) {
?>
    <div class="float-right">

      <a href = "editarSocioUser.php?matricula=<?php echo $matricula; ?>" class="btn btn-primary"><i class="far fa-edit"></i> Editar meus dados</a>

      <a href="" data-toggle="modal" data-target="#editarDependentes" class="btn btn-primary"><i class="far fa-edit"></i> Editar meus dependentes</a>

    </div>
<?php
  }
?>

<!--início função apagar usuário-->
<script type="text/javascript">
    function apagar(dependente, matricula) {
        if (window.confirm('Deseja realmente apagar esse dependente? Essa ação não poderá ser desfeita.')) {
            window.location = 'excluirDependente.php?dependente=' + dependente + '&matricula=' + matricula;
        }
    }
</script>
<!--fim função apagar usuário-->

<!--início do modal para editar dependentes-->
<div class="modal fade bd-example-modal-sm" id="editarDependentes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title" id="exampleModalLabel">Editar Dependentes</h3>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">

      <table class="table table-striped table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>CPF</th>
            <th>Nome</th>
            <th>Parentesco</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>CPF</th>
            <th>Nome</th>
            <th>Parentesco</th>
            <th></th>
            <th></th>
          </tr>
        </tfoot>
        <tbody>

          <?php 

            $sqlDep = "SELECT U.nome, U.cpf, P.parentesco, D.idDependente
                          FROM usuario AS U, associado AS A, dependente AS D, parentesco AS P
                          WHERE U.tipo = 'dependente'
                          AND U.idUsuario = D.fk_idUsuario
                          AND A.idAssociado = D.fk_idAssociado
                          AND P.idParentesco = D.fk_idParentesco
                          AND D.fk_idAssociado = " . $idAssociado;

            $resultDep = $con->query($sqlDep);

            if ($resultDep->num_rows > 0) { // Exibindo cada linha retornada com a consulta
              while ($exibirDep = $resultDep->fetch_assoc()){
                $idDependente = $exibirDep["idDependente"];
                $nomeDep = ucwords(strtolower($exibirDep["nome"]));
                $cpfDep = $exibirDep["cpf"];
                $parentesco = ucwords(strtolower($exibirDep["parentesco"]));
          ?>  
                <tr>
                  <td><?php echo $cpfDep; ?></td>
                  <td><?php echo $nomeDep; ?></td>
                  <td><?php echo $parentesco; ?></td>
                  <?php
                    if (($tipoLogin != 'socio') && ($tipoLogin != 'dependente')){
                  ?>
                      <td>
                        <a title="Editar" href="editarDependente.php?id=<?php echo $idDependente; ?>&matricula=<?php echo $matricula; ?>">
                          <i class="far fa-edit" style="color:green"></i>
                        </a>
                      </td>
                      <td>
                        <a title="Excluir" href="#" onclick="apagar('<?php echo $idDependente; ?>','<?php echo $matricula; ?>');">
                          <i class="fas fa-trash-alt" style="color:red"></i>
                        </a>
                      </td>
                  <?php
                    }else{
                  ?>
                      <td>
                        <a title="Editar" href="editarDependenteUser.php?id=<?php echo $idDependente; ?>&matricula=<?php echo $matricula; ?>">
                          <i class="far fa-edit" style="color:green"></i>
                        </a>
                      </td>
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

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
    </div>

    </form>

  </div>
  </div>
</div>
<!--fim do modal para editar dependentes-->

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