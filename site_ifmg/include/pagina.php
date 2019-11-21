<?php
  include("include/header.php");

  $id = $_GET["id"];

  $sqlPagina = "SELECT nome, conteudo, data_alteracao, usuario.nome as usuario, id_autor_aprovacao, data_aprovacao 
                FROM pagina JOIN usuario ON usuario.id = id_autor WHERE id = " . $id;

  $resultPagina = $conn->query($sqlPagina);

  if ($resultPagina->num_rows > 0) { // Exibindo cada linha retornada com a consulta
    while ($exibirPagina = $resultPagina->fetch_assoc()){
      $nome = $exibirPagina["nome"];
      $conteudo = $exibirPagina["conteudo"];
      $autor = ucwords($exibirPagina["usuario"]);

      $datetimeAlt = $exibirPagina["data_alteracao"];
      $datetime = new DateTime($datetimeAlt);
      $datetime = $datetime->format('d/m/Y H:i:s');
      $dataAlteracao = substr($datetime, 0, 10); 
      $horaAlteracao = substr($datetime, 11, 2) . "h" . substr($datetime, 14, 2) . "min";

      $datetimeAlt = $exibirPagina["data_aprovacao"];
      $datetime = new DateTime($datetimeAlt);
      $datetime = $datetime->format('d/m/Y H:i:s');
      $dataAprovacao = substr($datetime, 0, 10); 
      $horaAprovacao = substr($datetime, 11, 2) . "h" . substr($datetime, 14, 2) . "min";

      $sqlAutorAprovacao = "SELECT nome FROM pagina JOIN tipo_perfil ON id_autor_aprovacao = id WHERE idPagina = " . $id;

      $resultAutorAprovacao = $conn->query($sqlAutorAprovacao);

      if ($resultAutorAprovacao->num_rows > 0) { // Exibindo cada linha retornada com a consulta
        while ($exibirAutorAprovacao = $resultAutorAprovacao->fetch_assoc()){
          $autorAprovacao = ucwords($exibirAutorAprovacao["nome"]);
        }
      }

    } // fim while
  }
?>

<!-- Page Content -->
    <br>
    <div class="container">
      <div class="row mb-4">
        <div class="col-md-8">
          <h1><?php echo $nome; ?></h1>

          <?php

          if (isset($_SESSION['email'])){

            if ($_SESSION['tipo'] != 2) { 

          ?>
            <small><i>Última alteração realizada por <?php echo $autor; ?> em <?php echo $dataAlteracao; ?> às <?php echo $horaAlteracao; ?></i></small>
            <br>
            <small><i>Aprovado por <?php echo $autorAprovacao; ?> em <?php echo $dataAprovacao; ?> às <?php echo $horaAprovacao; ?></i></small>
          <?php

            }

          } 

          ?>
          
        </div>

        <?php

          if (isset($_SESSION['email'])){

            if ($_SESSION['tipo'] != 2) { 

          ?>
            <div class="float-right col-md-4">
          <?php
              if (($_SESSION['tipo']) == 2){
          ?>
                <a class="btn btn-primary btn-block" href="editarPaginaAdmin.php?id=<?php echo $id; ?>"><i class="far fa-edit"></i> Editar</a>
          <?php     
              }else{
          ?>
                <a class="btn btn-primary btn-block" href="editarPaginaUser.php?id=<?php echo $id; ?>"><i class="far fa-edit"></i> Editar</a>
          <?php     
              }
          ?>      
            </div>
          <?php
            }
          }
          ?>
      </div>

      <!-- Page Heading/Breadcrumbs -->
      
      <!-- Intro Content -->

      <?php

        if (isset($_SESSION['email'])){

          if (($_SESSION['tipo'])==2){

            $sqlPaginaPendente = "SELECT aprovacao FROM pagina_pendente WHERE id = " . $id;

            $resultPaginaPendente = $conn->query($sqlPaginaPendente);

            if ($resultPaginaPendente->num_rows > 0) { // Exibindo cada linha retornada com a consulta
              while ($exibirPaginaPendente = $resultPaginaPendente->fetch_assoc()){
                $aprovacao = $exibirPaginaPendente["aprovacao"];
              } // fim while
            }

              if ($aprovacao == 0) {
      ?>

                <div class="alert alert-danger" role="alert">
                  Existem alterações nesta página com aprovação pendente. <a href="editarPaginaPendente.php?id=<?php echo $id; ?>" class="alert-link">Clique aqui</a> para acessá-las.
                </div>

      <?php
            }
          }
        }
      ?>

      <p style="text-align: justify;">
        <?php echo $conteudo; ?>
      </p>
    
    </div>
    <!-- /.container -->
    <br>
<?php
  include("include/footer.php");
?>