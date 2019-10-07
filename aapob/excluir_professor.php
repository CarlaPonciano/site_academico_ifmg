<!DOCTYPE html>
<html lang="en">

<?php
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
        
      <a class="navbar-brand" href="index.php"><img class="img-fluid rounded" src="logoSI.png" alt="" style="height: 30px;"></a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample09">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="excluir_professor.php" id="navLink">Excluir Professor</a>
          </li>
        </ul>
        <!--<form class="form-inline my-2 my-md-0">
          <input class="form-control mr-sm-2" type="Search" placeholder="Pesquisar..." aria-label="Search">
          <button class="btn btn-outline-default my-2 my-sm-0" type="submit" class="btn btn-info">
            <i class="fas fa-search"></i>
          </button>
        </form>-->
      </div>
    </nav>

    <hr>

    <!-- Page Content -->
    <div class="container">

      <h3 class="my-4">Excluir Professor</h3>

      <form method="post" action="exc_prof.php" id="formexcluiprofessor" name="formexcluiprofessor">
          <div class="form">
            <div class="form-label">
              <input type="text" name="nome" id="nome" class="form-group" placeholder="Nome" required="required" autofocus="autofocus" >
            </div>
          </div>
          <div class="form">
            <div class="form-label">
              <input type="text" name="cpf" id="cpf" class="form-group" placeholder="CPF" required="required" autofocus="autofocus" >
            </div>
          </div>
          <button class="btn btn-primary" type="submit">Excluir Professor</button>
        </form>
        <br>

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="page-footer font-small footerAaa" style="background-color: #16561e;">
        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2018 Copyright:
          <a href="#"> Bacharelado em Sistemas de Informação</a>
        </div>
        <!-- Copyright -->

      </footer>
      <!-- Footer -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
