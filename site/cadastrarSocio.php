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
  <li class="breadcrumb-item active">Cadastrar</li>
  <li class="breadcrumb-item active">Associado</li>
</ol>

<form enctype="multipart/form-data" role="form" data-toggle="validator" action="inserirSocio.php" method="post">

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
              <input type="text" class="form-control" id="nome" placeholder="Nome completo" name="nome" required>
            </div>

            <div class="form-group col-md-6">
              <label for="dataNascimento">Data de Nascimento</label>
              <input type="date" class="form-control" id="dataNascimento" max="<?php echo date("Y-m-d"); ?>" min="1900-01-01" placeholder="dd/mm/aaaa" name="dataNascimento">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="mae">
                Mãe
              </label>
              <input type="text" class="form-control" id="mae" placeholder="Nome completo" name="mae">
            </div>

            <div class="form-group col-md-6">
              <label for="pai">
                Pai
              </label>
              <input type="text" class="form-control" id="pai" placeholder="Nome completo" name="pai">
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
                        echo '<option value="' . $id . '">' . $name . '</option>';
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
                        echo '<option value="' . $id . '">' . $name . '</option>';
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
                        echo '<option value="' . $id . '">' . $name . '</option>';
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
              <input minlength="5" maxlength="14" type="text" class="form-control" id="cpf" placeholder="00000000000" name="cpf" required>
            </div>

            <div class="form-group col-md-6">
              <label for="rg">
                RG
              </label>
              <input minlength="5" maxlength="12" type="text" class="form-control" id="rg" placeholder="MG00000000" name="rg">
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
                        echo '<option value="' . $id . '">' . $name . '</option>';
                    }
                ?>
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="naturalidade">
                Naturalidade
              </label>
              <input type="text" class="form-control" id="naturalidade" placeholder="Naturalidade" name="naturalidade">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="imgUsuario">Imagem de Perfil</label>
              <input class="input-group" id="imgUsuario" type="file" name="imgUsuario[]" />
            </div>

            <div class="form-group col-md-6">
              <label for="imgDoc">Anexar Documentos (no máximo 10)</label>
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

    <div class="card mb-3">
      <a href="#endereco" style="text-decoration: none" class="d-block card-header" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="endereco">
        <i class="fas fa-map-marker-alt"></i>
        Endereço
      </a>

      <div id="endereco">
        <div class="card-body">

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="tipoLog">Tipo</label>
              <select class="form-control" id="tipoLog" name="tipoLog">
                <option value="Rua">Rua</option>
                <option value="Avenida">Avenida</option>
                <option value="Praca">Praça</option>
                <option value="Alameda">Alameda</option>
                <option value="Travessa">Travessa</option>
                <option value="Rodovia">Rodovia</option>
                <option value="Chácara">Chácara</option>
                <option value="Sitio">Sítio</option>
                <option value="Condomínio">Condomínio</option>
                <option value="Estrada">Estrada</option>
                <option value="">Outros</option>
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="logradouro">
                Logradouro
              </label>
              <input type="text" class="form-control" id="logradouro" placeholder="Logradouro" name="logradouro">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-4">
              <label for="numero">Número</label>
              <input type="number" pattern="[0-9]*" class="form-control" id="numero" placeholder="Número" name="numero">
            </div>

            <div class="form-group col-md-4">
              <label for="complemento">
                Complemento
              </label>
              <input type="text" class="form-control" id="complemento" placeholder="Complemento" name="complemento">
            </div>

            <div class="form-group col-md-4">
              <label for="bairro">
                Bairro
              </label>
              <input type="text" class="form-control" id="bairro" placeholder="Bairro" name="bairro">
            </div>
          
          </div>

          <div class="form-row">

            <div class="form-group col-md-3">
              <label for="cidade">Cidade</label>
              <input type="text" value="Ouro Branco" class="form-control" id="cidade" placeholder="Cidade" name="cidade">
            </div>

            <div class="form-group col-md-3">
              <label for="estado">
                Estado
              </label>
              <input type="text" value="MG" class="form-control" id="estado" placeholder="Estado" name="estado">
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
                        echo '<option value="' . $id . '">' . $name . '</option>';
                    }
                ?>
              </select>
            </div>

            <div class="form-group col-md-3">
              <label for="cep">
                CEP
                <span href="#" title="Somente Números" data-toggle="popover" data-placement="left" data-content="Content"><i class="fas fa-question-circle"></i></span>
              </label>
              <input type="text" maxlength="9" value="36420-000" class="form-control" id="cep" placeholder="CEP" name="cep">
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
                        echo '<option value="' . $id . '">' . $nivel . ' ' . $situacao . '</option>';
                    }
                ?>
              </select>
            </div>

            <div class="form-group col-md-6">
              <label for="profissao">
                Profissão
              </label>
              <input type="text" class="form-control" id="profissao" placeholder="Profissão" name="profissao">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
              <label for="carteiraTrabalho">
                Carteira de Trabalho
              </label>
              <input type="text" class="form-control" id="carteiraTrabalho" placeholder="Carteira de Trabalho" name="carteiraTrabalho">
            </div>

            <div class="form-group col-md-6">
              <label for="serie">
                Série
              </label>
              <input type="text" class="form-control" id="serie" placeholder="Série" name="serie">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-4">
              <label for="empresa">
                Empresa
              </label>
              <input type="text" class="form-control" id="empresa" placeholder="Empresa" name="empresa">
            </div>

            <div class="form-group col-md-4">
              <label for="inss">
                INSS
              </label>
              <input type="text" class="form-control" id="inss" placeholder="INSS" name="inss">
            </div>

            <div class="form-group col-md-4">
              <label for="dataAposentadoria">Data de Aposentadoria</label>
              <input type="date" class="form-control" id="dataAposentadoria" max="<?php echo date("Y-m-d"); ?>" min="1900-01-01" placeholder="dd/mm/aaaa" name="dataAposentadoria">
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
              <input required="required" pattern="^[0-9]{1,7}$" type="number" class="form-control" id="matricula" placeholder="Matrícula" name="matricula">
            </div>

          </div>
          
        </div>
      </div>
    </div>
    <button type="submit" name="insertAssociado" class="float-center btn btn-primary">Cadastrar</button>
</form>

<?php
include("include/footerAdm.php");

}else{
  echo "<script>window.location.href='index.php';</script>";
}
?>