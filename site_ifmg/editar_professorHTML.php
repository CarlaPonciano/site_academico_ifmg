<!DOCTYPE html>
<html lang="en">

<?php 
  include ("include/header.php"); 
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
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="https://example.com" id="navLink" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Gerenciar Professores</a>
            <div class="dropdown-menu" aria-labelledby="dropdown09">
              <a class="dropdown-item" href="cadastrar_professorHTML.php">Cadastrar</a>
              <a class="dropdown-item" href="exibir_professorHTML.php">Exibir</a>
            </div>
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

      <h3 class="my-4">Editar Professor</h3>
             
      <form method="post" action="editar_professorPHP.php" id="formeditaprofessor" name="formeditaprofessor">
      <p>Insira os novos dados: </p>

      <?php
        include("conexao.php"); 
        $cpf = trim(strip_tags($_GET["cpf"]));

        $sql = "SELECT * FROM usuario WHERE cpf = '" . $cpf . "';";
        $resultado = $conn->query($sql);
        if ($resultado->num_rows > 0) {
        $exibir = $resultado->fetch_assoc()
      ?>

          <div class="form">
            <div class="form-label">
              <label for="nome">Nome: </label>
              <input type="text" name="nome" id="nome" class="form-group" value="<?php echo $exibir["nome"]?>" required="required" autofocus="autofocus" >
            </div>
          </div>
          <div class="form">
            <div class="form-label">
            <label for="nome">Email: </label>
              <input type="email" name="email" id="email" class="form-group" value="<?php echo $exibir["email"]?>" required="required" autofocus="autofocus" >
            </div>
          </div>
          <div class="form">
            <div class="form-label">
            <label for="nome">CPF: </label>
              <input type="email" name="cpf" id="cpf" class="form-group" value="<?php echo $cpf?>" required="required" autofocus="autofocus" readonly>
            </div>
          </div>

          <button class="btn btn-primary" type="submit">Alterar Dados</button>
        </form>
        <br>

      <?php
        }else{
          echo "Professor não cadastrado no sistema!"; ?> <br><br> <?php
        }
      ?>
          

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
