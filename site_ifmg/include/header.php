<!DOCTYPE html>
<html lang="en">

<?php 
  include ("./conexao.php"); 
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
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        
      <a class="navbar-brand" href="index.html"><img class="img-fluid rounded" src="logoSI.png" alt="" style="height: 30px;"></a>

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
              while ($exibirSecaoPaginas = $resultSecaoPaginas->fetch_assoc()){
                $idSecaoPaginas = $exibirSecaoPaginas["id"];
                $nomeSecaoPaginas = $exibirSecaoPaginas["titulo"];
          ?>
                <li class="nav-item dropdown">
                  <a style="font-size: 14px;" class="link-barra-nav nav-link dropdown-toggle" href="" id="navLink" 
                    id="dropdownSecao<?php echo $idSecaoPaginas; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $nomeSecaoPaginas; ?>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownSecao<?php echo $idSecaoPaginas; ?>">

                    <?php

                      $sqlPagina = "SELECT id, nome FROM pagina WHERE exibir = 1 AND id_secao_pag = " . $idSecaoPaginas;

                      $resultPagina = $conn->query($sqlPagina);

                      if ($resultPagina->num_rows > 0) { // Exibindo cada linha retornada com a consulta
                        while ($exibirPagina = $resultPagina->fetch_assoc()){
                          $idPagina = $exibirPagina["id"];
                          $nomePagina = ucwords($exibirPagina["nome"]);
                    ?>

                          <a style="font-size: 14px;" class="dropdown-item" href="pagina.php?id=<?php echo $idPagina; ?>"><?php echo $nomePagina; ?>

                          <?php

                            if (isset($_SESSION["login"])) { //SE EXISTIR AUTENTICAÇÃO
                              if (isAdmin($_SESSION['tipo'])){ //SE O USUÁRIO LOGADO FOR DO TIPO ADMINISTRADOR

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
                  while ($secaoPosts = $result->fetch_assoc()){
                    $idSecaoPosts = $secaoPosts["id"];
                ?>

                    <li class="nav-item">
                      <a style="font-size: 14px;" class="nav-link disabled" href="postagens.php?id=<?php echo $idSecaoPosts;?>" id="navLink">
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
                if($_SESSION['tipo'] == 2){
          ?>
            <li class="nav-item">
              <a class="nav-link" href="admin.php" id="navLink">Área Administrativa</a>
            </li>
          <?php   
              }else{
                if($_SESSION['tipo'] == 1 || $_SESSION['tipo'] == 2){
          ?>
                <li class="nav-item">
                  <a class="nav-link" href="#" id="navLink">Cadastrar Seção</a>
                </li>
          <?php   
                }
              }
           }
          ?>
        </ul>
        <form class="form-inline my-2 my-md-0">
          <input class="form-control mr-sm-2" type="Search" placeholder="Pesquisar..." aria-label="Search">
          <button class="btn btn-outline-default my-2 my-sm-0" type="submit" class="btn btn-info">
            <i class="fas fa-search"></i>
          </button>
        </form>
      </div>
    </nav>

    <header class="py-1 bg-image-full" style="background-image: url('logoSI.jpeg');">
      <div style="height:20cm; width:10c"></div>
    </header>

    <hr>