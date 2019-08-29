<?php
include("include/headerAdm.php");
if (isset($_SESSION['login'])){
  $matricula = $_GET["matricula"];

  // excluir documento
  if (isset($_GET['delete_id'])) {
    $dl = $_GET['delete_id'];
    unlink("imgDoc/" . $dl);

    // it will delete an actual record from db
    $sql = 'DELETE FROM imgDoc WHERE imgDoc.imgDoc = "'.$dl.'"';
    if ($con->query($sql) == TRUE) {
      echo"<script language='javascript' type='text/javascript'>alert('Documento excluído com sucesso!');window.location.href='editarSocio.php?matricula=".$matricula."'</script>";
    } else {
      echo"<script language='javascript' type='text/javascript'>alert('Erro ao excluir o documento ".$dl."'!);window.location.href='editarSocio.php?matricula=".$matricula."'</script>";
    }
  }

  //selecionando dados
  $matricula = $_GET["matricula"];

  //selecionando img de perfil
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

  //selecionando imgs de documentos
  $imgDoc = array();
  $i = 0;

  $sqlID = "SELECT ID.imgDoc 
            FROM imgDoc as ID, associado AS A 
            WHERE ID.fk_idUsuario = A.fk_idUsuario 
            AND A.matriculaAAA = '" . $matricula . "';";

  $resultID = $con->query($sqlID);
  if ($resultID->num_rows > 0) {
    while ($rows = $resultID->fetch_assoc()) {
      $imgDoc[$i] = $rows["imgDoc"];
      $i++;
    }
  }else{            
    $imgDoc = null;
  }

  $sqlDados = "SELECT A.idAssociado, U.nome, U.cpf, A.mae, A.pai, A.dataNascimento, A.fk_idGenero, A.fk_idNacionalidade, A.naturalidade, A.fk_idEstadoCivil, A.rg, A.fk_idGrupoSanguineo, U.idUsuario
                FROM usuario AS U, associado AS A
                WHERE U.tipo = 'socio'
                AND U.idUsuario = A.fk_idUsuario
                AND A.matriculaAAA = " . $matricula;

  $resultDados = $con->query($sqlDados);

  if ($resultDados->num_rows > 0) { // Exibindo cada linha retornada com a consulta
    while ($exibirDados = $resultDados->fetch_assoc()){
      $idAssociado = $exibirDados["idAssociado"];
      $idUsuario = $exibirDados["idUsuario"];
      $nome = ucwords($exibirDados["nome"]);
      $mae = ucwords($exibirDados["mae"]);
      $pai = ucwords($exibirDados["pai"]);
      $cpf = $exibirDados["cpf"];
      $rg = strtoupper($exibirDados["rg"]);
      $dataNascimento = $exibirDados["dataNascimento"];
      $idGenero = $exibirDados["fk_idGenero"];
      $idNacionalidade = $exibirDados["fk_idNacionalidade"];
      $naturalidade = ucwords(strtolower($exibirDados["naturalidade"]));
      $idEstadoCivil = $exibirDados["fk_idEstadoCivil"];
      $idGrupoSanguineo = $exibirDados["fk_idGrupoSanguineo"];
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
  <li class="breadcrumb-item active">Editar Dados do Sócio</li>
</ol>

<form class="form-horizontal" enctype="multipart/form-data" role="form" data-toggle="validator" action="atualizarSocio.php?idSocio=<?php echo $idAssociado; ?>&idUser=<?php echo $idUsuario; ?>" method="post">

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
              <label for="mae">
                Mãe
              </label>
              <input type="text" class="form-control" id="mae" placeholder="Nome completo" name="mae" value="<?php echo $mae; ?>">
            </div>

            <div class="form-group col-md-6">
              <label for="pai">
                Pai
              </label>
              <input type="text" class="form-control" id="pai" placeholder="Nome completo" name="pai" value="<?php echo $pai; ?>">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-4">
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

            <div class="form-group col-md-4">
              <label for="estadoCivil">Estado Civil</label>
              <select id="estadoCivil" name="estadoCivil" class="form-control">
                <?php
                    $resEstadoCivil = $con->query("SELECT idEstadoCivil, estadoCivil 
                                            FROM estadoCivil");

                    while ($rowEstadoCivil = $resEstadoCivil->fetch_assoc()) {
                        unset($id, $name);
                        $id = $rowEstadoCivil['idEstadoCivil'];
                        $name = ucwords(strtolower($rowEstadoCivil['estadoCivil']));
                        if ($idEstadoCivil == $id) { 
                          echo '<option selected value="' . $id . '">' . $name . '</option>';
                        }else{
                          echo '<option value="' . $id . '">' . $name . '</option>';
                        }
                    }
                ?>
              </select>
            </div>

            <div class="form-group col-md-4">
              <label for="grupoSanguineo">Grupo Sanguíneo</label>
              <select id="grupoSanguineo" name="grupoSanguineo" class="form-control">
                <?php
                    $resGrupoSanguineo = $con->query("SELECT idGrupoSanguineo, grupoSanguineo 
                                            FROM grupoSanguineo
                                            ORDER BY idGrupoSanguineo");

                    while ($rowGrupoSanguineo = $resGrupoSanguineo->fetch_assoc()) {
                        unset($id, $name);
                        $id = $rowGrupoSanguineo['idGrupoSanguineo'];
                        $name = ucwords($rowGrupoSanguineo['grupoSanguineo']);
                        if ($idGrupoSanguineo == $id) { 
                          echo '<option selected value="' . $id . '">' . $name . '</option>';
                        }else{
                          echo '<option value="' . $id . '">' . $name . '</option>';
                        }
                    }
                ?>
              </select>
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="cpf">
                CPF <span title="obrigatório">*</span> 
                <span href="#" title="Somente Números" data-toggle="popover" data-placement="left" data-content="Content"><i class="fas fa-question-circle"></i></span>
              </label>
              <input minlength="5" maxlength="14" type="text" class="form-control" id="cpf" placeholder="00000000000" name="cpf" required value="<?php echo $cpf; ?>" readonly>
            </div>

            <div class="form-group col-md-6">
              <label for="rg">
                RG
              </label>
              <input minlength="5" maxlength="12" type="text" class="form-control" id="rg" placeholder="MG00000000" name="rg" value="<?php echo $rg; ?>">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="nacionalidade">Nacionalidade</label>
              <select id="nacionalidade" name="nacionalidade" class="form-control">
                <?php
                    $resNacionalidade = $con->query("SELECT idPais, nomePT 
                                                        FROM pais 
                                                        ORDER BY idPais ASC");

                    while ($rowNacionalidade = $resNacionalidade->fetch_assoc()) {
                        unset($id, $name);
                        $id = $rowNacionalidade['idPais'];
                        $name = ucwords($rowNacionalidade['nomePT']);
                        if ($idNacionalidade == $id) { 
                          echo '<option selected value="' . $id . '">' . $name . '</option>';
                        }else{
                          echo '<option value="' . $id . '">' . $name . '</option>';
                        }
                    }
                ?>
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="naturalidade">
                Naturalidade
              </label>
              <input type="text" class="form-control" id="naturalidade" placeholder="Naturalidade" name="naturalidade" value="<?php echo $naturalidade; ?>">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="imgUsuario">Imagem de Perfil <br>
                <?php
                  if ($img) {
                ?>
                    <img src=imgUsuario/<?php echo $imgUsuario;?> style='max-width: 100px;'>
                <?php
                  } else {
                ?>
                    <img src=imgUsuario/padrao.png style='max-width: 100px;'>
                <?php
                  }
                ?>
              </label>
              <input class="input-group" id="imgUsuario" type="file" name="imgUsuario[]" />
            </div>

            <div class="form-group col-md-6">
              <label for="imgDoc">Anexar Documentos (no máximo 10) <br>
                <?php
                  if ($imgDoc != null){
                    $i = count($imgDoc) - 1;
                    while ($i >= 0) {
                ?>
                      <img src=imgDoc/<?php echo $imgDoc[$i];?> style='max-width: 100px;'></img>
                      <br>
                      <a style="text-decoration: none; color: red;" class="float-center" href="?delete_id=<?php echo $imgDoc[$i]; ?>&matricula=<?php echo $matricula; ?>" title="Excluir Documento" onclick="return confirm('Deseja excluir o documento?')">
                        <i class="fas fa-times"></i> Excluir
                      </a>
                      <br><br>
                <?php
                      $i--;
                    }
                  }
                ?>
              </label>
              <input type="file" name="imgDoc[]" id="imgDoc" multiple="multiple" />
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
                $telefone = $exibirContato["telefone"];
                $telefone2 = $exibirContato["telefone2"];
              }
            }
          ?>

          <div class="form-row">

            <div class="form-group col-md-6">

              <label for="telefone">
                Telefone
                <span href="#" title="Somente Números" data-toggle="popover" data-placement="left" data-content="Content"><i class="fas fa-question-circle" value=""></i></span>
                <i class="fas fa-plus" title="Adicionar Novo Telefone" data-toggle="collapse" data-target="#collapseTelefone2" aria-expanded="false" aria-controls="collapseExample"></i>
              </label>

              <input type="text" class="form-control" id="telefone" maxlength="14" placeholder="Telefone" name="telefone" value="<?php echo $telefone; ?>">

            </div>

            <div class="form-group col-md-6">
              <label for="email">
                E-mail
              </label>
              <input type="email" class="form-control" id="email" placeholder="E-mail" name="email" value="<?php echo $email; ?>">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <div class="collapse" id="collapseTelefone2">
                <input type="text" class="form-control" id="telefone2" maxlength="14" placeholder="Telefone" name="telefone2" value="<?php echo $telefone2; ?>">
              </div>
            </div>

          </div>
          
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <a href="#endereco" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="endereco">
        <i class="fas fa-map-marker-alt"></i>
        Endereço
      </a>

      <div id="endereco">
        <div class="card-body">

          <?php 

            $sqlEndereco = "SELECT A.tipoLog, A.logradouro, A.numero, A.bairro, A.complemento, A.cidade, A.estado, A.cep, A.fk_idPais
                          FROM usuario AS U, associado AS A, pais AS P
                          WHERE U.tipo = 'socio'
                          AND U.idUsuario = A.fk_idUsuario
                          AND A.matriculaAAA = " . $matricula;

            $resultEndereco = $con->query($sqlEndereco);

            if ($resultEndereco->num_rows > 0) { // Exibindo cada linha retornada com a consulta
              while ($exibirEndereco = $resultEndereco->fetch_assoc()){
                $tipoLog = $exibirEndereco["tipoLog"];
                $logradouro = rtrim($exibirEndereco["logradouro"]);
                $numero = $exibirEndereco["numero"];
                $complemento = $exibirEndereco["complemento"];
                $bairro = ucwords($exibirEndereco["bairro"]);
                $cidade = ucwords(strtolower($exibirEndereco["cidade"]));
                $estado = $exibirEndereco["estado"];
                $cep = $exibirEndereco["cep"];
                $idPais = $exibirEndereco["fk_idPais"];
              }
            }
          ?>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="tipoLog">Tipo</label>
              <select class="form-control" id="tipoLog" name="tipoLog">
                <option value="Rua" <?php if ($tipoLog == "Rua"){echo "selected"; }else{} ?>>Rua</option>
                <option value="Avenida" <?php if ($tipoLog == "Avenida"){echo "selected"; }else{} ?>>Avenida</option>
                <option value="Praca" <?php if ($tipoLog == "Praca"){echo "selected"; }else{} ?>>Praça</option>
                <option value="Alameda" <?php if ($tipoLog == "Alameda"){echo "selected"; }else{} ?>>Alameda</option>
                <option value="Travessa" <?php if ($tipoLog == "Travessa"){echo "selected"; }else{} ?>>Travessa</option>
                <option value="Rodovia" <?php if ($tipoLog == "Rodovia"){echo "selected"; }else{} ?>>Rodovia</option>
                <option value="Chácara" <?php if ($tipoLog == "Chácara"){echo "selected"; }else{} ?>>Chácara</option>
                <option value="Sitio" <?php if ($tipoLog == "Sitio"){echo "selected"; }else{} ?>>Sítio</option>
                <option value="Condomínio" <?php if ($tipoLog == "Condomínio"){echo "selected"; }else{} ?>>Condomínio</option>
                <option value="Estrada" <?php if ($tipoLog == "Estrada"){echo "selected"; }else{} ?>>Estrada</option>
                <option value="" <?php if ($tipoLog == ""){echo "selected"; }else{} ?>>Outros</option>
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="logradouro">
                Logradouro
              </label>
              <input type="text" class="form-control" id="logradouro" placeholder="Logradouro" name="logradouro" value="<?php echo $logradouro; ?>">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-4">
              <label for="numero">Número</label>
              <input type="number" pattern="[0-9]*" class="form-control" id="numero" placeholder="Número" name="numero" value="<?php echo $numero; ?>">
            </div>

            <div class="form-group col-md-4">
              <label for="complemento">
                Complemento
              </label>
              <input type="text" class="form-control" id="complemento" placeholder="Complemento" name="complemento" value="<?php echo $complemento; ?>">
            </div>

            <div class="form-group col-md-4">
              <label for="bairro">
                Bairro
              </label>
              <input type="text" class="form-control" id="bairro" placeholder="Bairro" name="bairro" value="<?php echo $bairro; ?>">
            </div>
          
          </div>

          <div class="form-row">

            <div class="form-group col-md-3">
              <label for="cidade">Cidade</label>
              <input type="text" value="<?php echo $cidade; ?>" class="form-control" id="cidade" placeholder="Cidade" name="cidade">
            </div>

            <div class="form-group col-md-3">
              <label for="estado">
                Estado
              </label>
              <input type="text" value="<?php echo $estado; ?>" class="form-control" id="estado" placeholder="Estado" name="estado">
            </div>

            <div class="form-group col-md-3">
              <label for="pais">País</label>
              <select id="pais" name="pais" class="form-control">
                <?php
                    $resPais = $con->query("SELECT idPais, nomePT 
                                            FROM pais 
                                            ORDER BY idPais ASC");

                    while ($rowPais = $resPais->fetch_assoc()) {
                        unset($id, $name);
                        $id = $rowPais['idPais'];
                        $name = ucwords($rowPais['nomePT']);
                        if ($idPais == $id) { 
                          echo '<option selected value="' . $id . '">' . $name . '</option>';
                        }else{
                          echo '<option value="' . $id . '">' . $name . '</option>';
                        }
                    }
                ?>
              </select>
            </div>

            <div class="form-group col-md-3">
              <label for="cep">
                CEP
                <span href="#" title="Somente Números" data-toggle="popover" data-placement="left" data-content="Content"><i class="fas fa-question-circle"></i></span>
              </label>
              <input type="text" maxlength="9" value="<?php echo $cep; ?>" class="form-control" id="cep" placeholder="CEP" name="cep">
            </div>
          
          </div>

        </div>
      </div>
    </div>

    <div class="card mb-3">
      <a href="#apos" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="apos">
        <i class="fas fa-briefcase"></i>
        Aposentadoria
      </a>

      <div id="apos">
        <div class="card-body">

          <?php 

            $sqlApos = "SELECT A.inss, A.carteiraTrabalho, A.serieCT, A.empresa, A.profissao, A.dataAposentadoria, A.fk_idEscolaridade
                          FROM usuario AS U, associado AS A
                          WHERE U.tipo = 'socio'
                          AND U.idUsuario = A.fk_idUsuario
                          AND A.matriculaAAA = " . $matricula;

            $resultApos = $con->query($sqlApos);

            if ($resultApos->num_rows > 0) { // Exibindo cada linha retornada com a consulta
              while ($exibirApos = $resultApos->fetch_assoc()){
                $inss = $exibirApos["inss"];
                $carteiraTrabalho = $exibirApos["carteiraTrabalho"];
                $serieCT = $exibirApos["serieCT"];
                $empresa = $exibirApos["empresa"];
                $profissao = $exibirApos["profissao"];
                $dataAposentadoria = $exibirApos["dataAposentadoria"];
                $idEscolaridade = $exibirApos["fk_idEscolaridade"];
              }
            }
          ?>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="escolaridade">Escolaridade</label>
              <select class="form-control" id="escolaridade" name="escolaridade">
                <?php
                    $resEsc = $con->query("SELECT idEscolaridade, nivel, situacao 
                                            FROM escolaridade");
                    while ($rowEsc = $resEsc->fetch_assoc()) {
                        unset($id, $name);
                        $id = $rowEsc['idEscolaridade'];
                        $nivel = $rowEsc['nivel'];
                        $situacao = $rowEsc['situacao'];
                        if ($id == $idEscolaridade){
                          echo '<option value="' . $id . '" selected>' . $nivel . ' ' . $situacao . '</option>';
                        }else{
                          echo '<option value="' . $id . '">' . $nivel . ' ' . $situacao . '</option>';
                        }
                    }
                ?>
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="profissao">
                Profissão
              </label>
              <input type="text" class="form-control" id="profissao" placeholder="Profissão" name="profissao" value="<?php echo $profissao; ?>">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="carteiraTrabalho">
                Carteira de Trabalho
              </label>
              <input type="text" class="form-control" id="carteiraTrabalho" placeholder="Carteira de Trabalho" name="carteiraTrabalho" value="<?php echo $carteiraTrabalho; ?>">
            </div>

            <div class="form-group col-md-6">
              <label for="serie">
                Série
              </label>
              <input type="text" class="form-control" id="serie" placeholder="Série" name="serie" value="<?php echo $serieCT; ?>">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-4">
              <label for="empresa">
                Empresa
              </label>
              <input type="text" class="form-control" id="empresa" placeholder="Empresa" name="empresa" value="<?php echo $empresa; ?>">
            </div>

            <div class="form-group col-md-4">
              <label for="inss">
                INSS
              </label>
              <input type="text" class="form-control" id="inss" placeholder="INSS" name="inss" value="<?php echo $inss; ?>">
            </div>

            <div class="form-group col-md-4">
              <label for="dataAposentadoria">Data de Aposentadoria</label>
              <input type="date" class="form-control" id="dataAposentadoria" max="<?php echo date("Y-m-d"); ?>" min="1900-01-01" placeholder="dd/mm/aaaa" name="dataAposentadoria" value="<?php echo $dataAposentadoria; ?>">
            </div>

          </div>
          
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <a href="#aaa" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="aaa">
        <img class="img-fluid rounded" src="imagens/logo-aaa-preto.png" alt="" style="height: 15px;">
        Associação dos Aposentados e Pensionistas de Ouro Branco
      </a>

      <div id="aaa">
        <div class="card-body">

          <div class="form-row">

            <div class="form-group col-md-4">
              <label for="matricula">
                Matrícula <span title="obrigatório">*</span>
              </label>
              <input readonly required="required" pattern="^[0-9]{1,7}$" type="number" class="form-control" id="matricula" placeholder="Matrícula" name="matricula" value="<?php echo $matricula; ?>">
            </div>

          </div>
          
        </div>
      </div>
    </div>
    <button type="submit" name="atualizeSocio" class="float-center btn btn-primary">Atualizar</button>
</form>

<?php
include("include/footerAdm.php");

}else{
  echo "<script>window.location.href='index.php';</script>";
}
?>