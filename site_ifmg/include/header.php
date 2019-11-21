<!DOCTYPE html>
<html lang="en">

<?php
  include("./conexao.php");
  include ("testaAdmin.php");
  session_start();
?>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistemas de Informação</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/modern-business.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" />

  <!-- Bootstrap core CSS -->
  <link href="vendor-main-website/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!--BOOTSTRAP-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  <!--EDITOR DE TEXTO CRKEDITOR-->
  <script type="text/javascript" src="ckeditor/ckeditor.js"></script>

  <!-- GALERIA -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css" />

  <style>

      @media (min-width: 800px) and (max-width: 850px) {
        .navbar:not(.top-nav-collapse) {
            background: #1C2331!important;
        }
      }

      .carousel,.carousel .carousel-inner,.carousel .carousel-inner .active,.carousel .carousel-inner .carousel-item,.view,body,html{
        height:98%
      }

      .page-footer,.top-nav-collapse{
        background-color:#1C2331
      }

    </style>
    <script src="//cdnjs.cloudflare.com/ajax/libs/wow/0.1.12/wow.min.js"></script><script>new WOW().init();</script>
    <script type="text/javascript">
          new WOW().init();
    </script>
</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">

    <a class="navbar-brand" href="index.php"><img class="img-fluid rounded" src="logoSI.png" alt="" style="height: 30px;"></a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample09">
      <ul class="navbar-nav mr-auto">
        <!-- seções de páginas -->
        <?php
        $sqlSecaoPaginas = "SELECT id, titulo FROM secao_pagina WHERE exibir = 1";

        $resultSecaoPaginas = $conn->query($sqlSecaoPaginas);

        if ($resultSecaoPaginas->num_rows > 0) { // Exibindo cada linha retornada com a consulta
          while ($exibirSecaoPaginas = $resultSecaoPaginas->fetch_assoc()) {
            $idSecaoPaginas = $exibirSecaoPaginas["id"];
            $nomeSecaoPaginas = $exibirSecaoPaginas["titulo"];
            ?>
            <li class="nav-item dropdown">
              <a style="font-size: 14px;" class="link-barra-nav nav-link dropdown-toggle" href="" id="navLink" id="dropdownSecao<?php echo $idSecaoPaginas; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $nomeSecaoPaginas; ?>
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownSecao<?php echo $idSecaoPaginas; ?>">

                <?php

                    $sqlPagina = "SELECT id, nome FROM pagina WHERE exibir = 1 AND id_secao_pag = " . $idSecaoPaginas;

                    $resultPagina = $conn->query($sqlPagina);

                    if ($resultPagina->num_rows > 0) { // Exibindo cada linha retornada com a consulta
                      while ($exibirPagina = $resultPagina->fetch_assoc()) {
                        $idPagina = $exibirPagina["id"];
                        $nomePagina = ucwords($exibirPagina["nome"]);
                        ?>

                    <a style="font-size: 14px;" class="dropdown-item" href="pagina.php?id=<?php echo $idPagina; ?>"><?php echo $nomePagina; ?>

                      <?php

                              if (isset($_SESSION["login"])) { //SE EXISTIR AUTENTICAÇÃO
                                if (isAdmin($_SESSION['tipo'])) { //SE O USUÁRIO LOGADO FOR DO TIPO ADMINISTRADOR

                                  $sqlPaginaAprov = "SELECT aprovacao FROM pagina_pendente WHERE aprovacao = 0 AND id_secao_pag = " . $idPagina;

                                  $resultPaginaAprov = $conn->query($sqlPaginaAprov);

                                  if ($resultPaginaAprov->num_rows > 0) { // Exibindo cada linha retornada com a consulta
                                    ?>
                            <span class="badge badge-danger">1</span>
                      <?php
                                  }
                                }
                              }
                              ?>

                    </a>

                <?php
                      } // fim while Pagina
                    } // fim if Pagina
                    ?>

              </div>

            </li>
        <?php
          } // fim while SecaoPaginas
        } // fim if SecaoPaginas
        ?>

        <!-- fim seções de páginas -->

        <!-- seções de postagens -->

        <?php

        $sqlPostagens = "SELECT id,titulo FROM secaoposts WHERE exibir = 1;";

        $result = $conn->query($sqlPostagens);

        if ($result->num_rows > 0) { // Exibindo cada linha retornada com a consulta
          while ($secaoPosts = $result->fetch_assoc()) {
            $idSecaoPosts = $secaoPosts["id"];
            ?>

            <li class="nav-item">
              <a style="font-size: 14px;" class="nav-link disabled" href="postagens.php?id=<?php echo $idSecaoPosts; ?>" id="navLink">
                <?php

                    echo $secaoPosts["titulo"];

                    /*if (isset($_SESSION['email'])){

                          if ($_SESSION['tipo'] == 2){

                            $sqlPostsPendentes = "SELECT aprovacao FROM postpendente WHERE aprovacao = 0 AND idSecaoPosts = " . $idSecaoPosts;

                            $resultPendentes = $conn->query($sqlPostsPendentes);

                            if ($resultPendentes->num_rows > 0) { // Exibindo cada linha retornada com a consulta  
                      ?>
                              <span class="badge badge-danger">1</span>
                    /* <?php
                            }
                          }
                        }*/
                    ?>
              </a>
            </li>
        <?php
          } // fim while
        }
        ?>

        <!-- fim seções de postagens -->
        <?php
          if (isset($_SESSION["email"])) {
            if ($_SESSION['tipo'] == 2) {
            ?>
            <li class="nav-item">
              <a style="font-size: 14px; background-color: gray; border:2px solid #5c5c3d;" class="nav-link" href="admin.php" id="navLink"><i class="fas fa-layer-group"></i> Área Administrativa</a>
            </li>
        <?php
            }
          }
        ?>

      </ul>
      <!-- configurações -->
      <?php
        if (isset($_SESSION["email"])) { //SE EXISTIR AUTENTICAÇÃO
          if ($_SESSION['tipo'] == 2 || $_SESSION['tipo'] == 1) { //SE O USUÁRIO LOGADO FOR DO TIPO ADMINISTRADOR 
      ?>

          <li class="nav-item dropdown">
            <a style="font-size: 14px;" class="nav-link dropdown-toggle" href="" id="navLink" id="dropdownConfiguracoes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Configurações</a>
            <div class="dropdown-menu" aria-labelledby="dropdownConfiguracoes">

              <a style="font-size: 14px;" class="dropdown-item" data-toggle="modal" data-target="#secao" href="">Seções</a>
              <a style="font-size: 14px;" class="dropdown-item" data-toggle="modal" data-target="#secaoPaginas" href="">Seções de Páginas</a>
              <a style="font-size: 14px;" class="dropdown-item" data-toggle="modal" data-target="#secaoPosts" href="">Seções de Postagens</a>

            </div>
          </li>

      <?php
          }
        }
      ?>
      <!-- fim configurações -->
        <!-- Modal - Seções -->
    <div class="modal fade bd-example-modal-sm" id="secao" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

<div class="modal-dialog" role="document">
  <div class="modal-content">

    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Seções</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
       <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <div class="modal-body">
      
      <?php

      $sqlSecaoModal = "SELECT idSecao, nome FROM secao";

      $resultSecaoModal = $conn->query($sqlSecaoModal);

      if ($resultSecaoModal->num_rows > 0) { // Exibindo cada linha retornada com a consulta
        while ($exibirSecaoModal = $resultSecaoModal->fetch_assoc()){
          $idSecao = $exibirSecaoModal["idSecao"];
          $nomeSecao = ucwords($exibirSecaoModal["nome"]);

      ?>
          <label class="control-label col-sm-12" for="nomeSecao">
            <?php echo $nomeSecao; ?>
            <a href="editarSecaoAdmin.php?id=<?php echo $idSecao; ?>">
              <i class="far fa-edit"></i>
            </a>
          </label>
      <?php
          } // fim while SecaoPaginas
        } // fim if SecaoPaginas
      ?>

      <div class="col-md-12"> 
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#cadastrarSecao">
          <i class="fas fa-plus"></i>  
          Cadastrar Nova Seção
        </button>
      </div>

    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    </div>

  </div>
</div>
</div>

<!-- Modal - Cadastrar Seção-->
<div class="modal fade" id="cadastrarSecao" tabindex="-1" role="dialog" aria-labelledby="cadastrarSecao" aria-hidden="true">

<div class="modal-dialog" role="document">
  <div class="modal-content">

    <div class="modal-header">
      <h5 class="modal-title" id="secaoPaginasLabel">Cadastrar Nova Seção</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <div class="modal-body">
    <form class="form-horizontal" action="inserirSecao.php" method="post" data-toggle="validator">

        <div class="form-group">
          <label class="control-label col-sm-12" for="titulo">Título:</label>
          <div class="col-sm-12">
            <input required type="text" class="form-control" id="titulo" name="titulo">
          </div>
        </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      <input type="submit" class="btn btn-primary" value="Cadastrar" name="cadastrar"></input>
    </div>

    </form>

  </div>
</div>
</div>
 <!-- fim cadastrar secao-->

  <!-- Modal - Seções de Páginas -->
  <div class="modal fade bd-example-modal-sm" id="secaoPaginas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

<div class="modal-dialog" role="document">
  <div class="modal-content">

    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Seções de Páginas</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <div class="modal-body">
      
      <?php

      $sqlSecaoPaginas = "SELECT id, titulo FROM secao_pagina";

      $resultSecaoPaginas = $conn->query($sqlSecaoPaginas);

      if ($resultSecaoPaginas->num_rows > 0) { // Exibindo cada linha retornada com a consulta
        while ($exibirSecaoPaginas = $resultSecaoPaginas->fetch_assoc()){
          $idSecaoPaginas = $exibirSecaoPaginas["id"];
          $nomeSecaoPaginas = ucwords($exibirSecaoPaginas["titulo"]);

      ?>
          <label class="control-label col-sm-12" for="nomeSecaoPaginas">
            <?php echo $nomeSecaoPaginas; ?>
            <a href="editarSecaoPaginas.php?id=<?php echo $idSecaoPaginas; ?>">
              <i class="far fa-edit"></i>
            </a>
          </label>
      <?php
          } // fim while SecaoPaginas
        } // fim if SecaoPaginas
      ?>

      <div class="col-md-12"> 
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#cadastrarSecaoPaginas">
          <i class="fas fa-plus"></i>  
          Cadastrar Nova Seção de Páginas
        </button>
      </div>

    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    </div>

  </div>
</div>
</div>

<!-- Modal - Cadastrar Seção de Páginas-->
<div class="modal fade" id="cadastrarSecaoPaginas" tabindex="-1" role="dialog" aria-labelledby="cadastrarSecaoPaginas" aria-hidden="true">

<div class="modal-dialog" role="document">
  <div class="modal-content">

    <div class="modal-header">
      <h5 class="modal-title" id="secaoPaginasLabel">Cadastrar Nova Seção de Páginas</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <div class="modal-body">
    <form class="form-horizontal" action="inserirSecaoPaginas.php" method="post" data-toggle="validator">

        <div class="form-group">
          <label class="control-label col-sm-12" for="titulo2">Título:</label>
          <div class="col-sm-12">
            <input required type="text" class="form-control" id="titulo2" name="titulo2">
          </div>
        </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      <input type="submit" class="btn btn-primary" value="Cadastrar" name="cadastrar"></input>
    </div>

    </form>

  </div>
</div>
</div>
<!-- fim cadastrar secao paginas -->
    </div>
  </nav>

  <header class="py-1 bg-image-full" style="background-image: url('logoSI.jpeg');">
    <div style="height:20cm; width:10c"></div>
  </header>

  <hr>