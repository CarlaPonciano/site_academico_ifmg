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
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="https://example.com" id="navLink" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Institucional</a>
            <div class="dropdown-menu" aria-labelledby="dropdown09">
              <a class="dropdown-item" href="#">Sobre o Curso</a>
              <a class="dropdown-item" href="#">Horário de Aulas</a>
              <a class="dropdown-item" href="#">Matriz Curricular</a>
              <a class="dropdown-item" href="#">Ementa</a>
            </div>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="#" id="navLink">Corpo Docente</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" id="navLink">Projetos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" id="navLink">Galeria</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#" id="navLink">Eventos</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="#" id="navLink">Notícias</a>
          </li>
          <?php
              if($_SESSION['tipo'] == 2){
          ?>
            <li class="nav-item">
              <a class="nav-link" href="admin.php" id="navLink">Área Administrativa</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#" id="navLink">Cadastrar Seção</a>
            </li>
          <?php   
            }else{
              if($_SESSION['tipo'] == 1){
          ?>
                <li class="nav-item">
                  <a class="nav-link" href="#" id="navLink">Cadastrar Seção</a>
                </li>
          <?php   
              }
            }
          ?>
        </ul>
        <!--<form class="form-inline my-2 my-md-0">
          <input class="form-control mr-sm-2" type="Search" placeholder="Pesquisar..." aria-label="Search">
          <button class="btn btn-outline-default my-2 my-sm-0" type="submit" class="btn btn-info">
            <i class="fas fa-search"></i>
          </button>
        </form>-->
      </div>
    </nav>

    <header class="py-1 bg-image-full" style="background-image: url('logoSI.jpeg');">
      <div style="height:20cm; width:10c"></div>
    </header>

    <hr>

    <!-- Page Content -->
    <div class="container">

      <h3 class="my-4">Bem-vindo(a) ao Curso Bacharelado de Sistemas de Informação!</h3>

      <!-- Marketing Icons Section -->
      <div class="row">
        <div class="col-lg-4 mb-4">
          <div class="card h-100">
            <h4 class="card-header">Sobre o Curso</h4>
            <div class="card-body">
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
            </div>
            <div class="card-footer">
              <style>
                button{
                  background: red;
                }
              </style>
              <a href="sobre.html" class="btn btn-primary" >Editar</a>
              <button name="button" class="btn btn-secundary">Excluir</button>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-4">
          <div class="card h-100">
            <h4 class="card-header">Horário de Aulas</h4>
            <div class="card-body">
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis ipsam eos, nam.</p>
            </div>
            <div class="card-footer">
              <a href="sobre.html" class="btn btn-primary" >Editar</a>
              <button name="button" class="btn btn-secundary">Excluir</button>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-4">
          <div class="card h-100">
            <h4 class="card-header">Matriz Curricular</h4>
            <div class="card-body">
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
            </div>
            <div class="card-footer">
              <a href="sobre.html" class="btn btn-primary" >Editar</a>
              <button name="button" class="btn btn-secundary">Excluir</button>
            </div>
          </div>
        </div>
      <div class="col-lg-4 mb-4">
        <div class="card h-100">
          <h4 class="card-header">Ementa</h4>
          <div class="card-body">
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
          </div>
          <div class="card-footer">
            <a href="sobre.html" class="btn btn-primary" >Editar</a>
            <button name="button" class="btn btn-secundary">Excluir</button>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
          <div class="card h-100">
            <h4 class="card-header">Outra</h4>
            <div class="card-body">
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
            </div>
            <div class="card-footer">
              <a href="sobre.html" class="btn btn-primary" >Editar</a>
              <button name="button" class="btn btn-secundary">Excluir</button>
            </div>
          </div>
        </div>
  
    </div>
      <!-- /.row -->

      <hr>
      <br>

      <!-- Features Section -->
    <div class="row">
        <div class="col-lg-6">
          <h2>Corpo Docente</h2>
          <p>O Instituto Federal de Minas Gerais<i>Campus</i> Ouro Branco, oferece ao Curso 
            Bacharelado em Sistemas de Informção um Corpo Docente Altamente especializado.</p>
          <ul>
            <li>
              <strong>Exemplo</strong>
            </li>
            <li>Exemplo</li>
            <li>Exemplo</li>
            <li>Exemplo</li>
            <li>Exemplo</li>
          </ul>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis, omnis doloremque non cum id reprehenderit, quisquam totam aspernatur tempora minima unde aliquid ea culpa sunt. Reiciendis quia dolorum ducimus unde.</p>
        </div>
        <div class="col-lg-6">
          <img class="img-fluid rounded" src="http://placehold.it/700x450" alt="">
        </div>
    </div>
      <!-- /.row -->

      <hr>
      <!-- Portfolio Section -->
      <div class="row">
        <div class="col-lg-8 col-sm-6 ">
          <h2>Projetos</h2>
        </div>
        <div class="col-lg-4 col-sm-6">
          <a class="float-right" href="projetos .html">Editar Projetos</a>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Exemplo</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat sequi itaque deserunt, dolores in, nesciunt, illum tempora ex quae? Nihil, dolorem!</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Saiba Mais</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Exemplo</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Saiba Mais</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Exemplo</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos quisquam, error quod sed cumque, odio distinctio velit nostrum temporibus necessitatibus et facere atque iure perspiciatis mollitia recusandae vero vel quam!</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Saiba Mais</a>
            </div>
          </div>
        </div>
                
      </div>
      <!-- /.row -->
      <!-- Portfolio Section -->
      <div class="row">
        <div class="col-lg-8 col-sm-6 ">
          <h2>Galeria</h2>
        </div>
        <div class="col-lg-4 col-sm-6">
          <a class="float-right" href="eventos.html">Editar Galeria</a>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Exemplo</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat sequi itaque deserunt, dolores in, nesciunt, illum tempora ex quae? Nihil, dolorem!</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Saiba Mais</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Exemplo</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Saiba Mais</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Exemplo</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos quisquam, error quod sed cumque, odio distinctio velit nostrum temporibus necessitatibus et facere atque iure perspiciatis mollitia recusandae vero vel quam!</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Saiba Mais</a>
            </div>
          </div>
        </div>

      </div>
      <!-- /.row -->
      <!-- Portfolio Section -->
      <div class="row">
        <div class="col-lg-8 col-sm-6 ">
          <h2>Eventos</h2>
        </div>
        <div class="col-lg-4 col-sm-6">
          <a class="float-right" href="eventos.html">Editar Eventos</a>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Exemplo</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat sequi itaque deserunt, dolores in, nesciunt, illum tempora ex quae? Nihil, dolorem!</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Saiba Mais</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Exemplo</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Saiba Mais</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Exemplo</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos quisquam, error quod sed cumque, odio distinctio velit nostrum temporibus necessitatibus et facere atque iure perspiciatis mollitia recusandae vero vel quam!</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Saiba Mais</a>
            </div>
          </div>
        </div>

      </div>
      <!-- /.row -->

      <!-- Portfolio Section -->
      <div class="row">
        <div class="col-lg-8 col-sm-6 ">
          <h2>Notícias</h2>
        </div>
        <div class="col-lg-4 col-sm-6">
          <a class="float-right" href="eventos.html">Editar Notícias</a>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Exemplo</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat sequi itaque deserunt, dolores in, nesciunt, illum tempora ex quae? Nihil, dolorem!</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Saiba Mais</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Exemplo</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Saiba Mais</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Exemplo</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos quisquam, error quod sed cumque, odio distinctio velit nostrum temporibus necessitatibus et facere atque iure perspiciatis mollitia recusandae vero vel quam!</p>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-primary">Saiba Mais</a>
            </div>
          </div>
        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="page-footer font-small footerAaa" style="background-color: #16561e;">

        <div style="background-color: #2a9d38;">
          <div class="container">

            <!-- Grid row-->
            <div class="row py-4 d-flex align-items-center">

              <!-- Grid column -->
              <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
                <h6 class="mb-0">Acesse também as nossas redes sociais!</h6>
              </div>
              <!-- Grid column -->

              <!-- Grid column -->
              <div class="col-md-6 col-lg-7 text-center text-md-right">

                <!-- Facebook -->
                <a class="fb-ic">
                  <i class="fa fa-facebook white-text mr-4"> </i>
                </a>
                <!-- Twitter -->
                <a class="tw-ic">
                  <i class="fa fa-twitter white-text mr-4"> </i>
                </a>
                <!-- Google +-->
                <a class="gplus-ic">
                  <i class="fa fa-google-plus white-text mr-4"> </i>
                </a>
                <!--Linkedin -->
                <a class="li-ic">
                  <i class="fa fa-linkedin white-text mr-4"> </i>
                </a>
                <!--Instagram-->
                <a class="ins-ic">
                  <i class="fa fa-instagram white-text"> </i>
                </a>

              </div>
              <!-- Grid column -->

            </div>
            <!-- Grid row-->

          </div>
        </div>

        <!-- Footer Links -->
        <div class="container text-center text-md-left mt-5">

          <!-- Grid row -->
          <div class="row mt-3">

            <!-- Grid column -->
            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">

              <!-- Content -->
              <h6 class="text-uppercase font-weight-bold">Sobre</h6>
              <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
              <p>O Instituto Federal de Educação, Ciência e Tecnologia de Minas Gerais (IFMG) é uma
                 instituição que oferece educação básica, profissional e superior.</p>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

              <!-- Links -->
              <h6 class="text-uppercase font-weight-bold">Links</h6>
              <hr class="white accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
              <p>
                <a href="#!">Link 1</a>
              </p>
              <p>
                <a href="#!">Link 2</a>
              </p>
              <p>
                <a href="#!">Link 3</a>
              </p>
              <p>
                <a href="#!">Link 4</a>
              </p>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">

              <!-- Links -->
              <h6 class="text-uppercase font-weight-bold">Links</h6>
              <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
              <p>
                <a href="#!">Link 1</a>
              </p>
              <p>
                <a href="#!">Link 2</a>
              </p>
              <p>
                <a href="#!">Link 3</a>
              </p>
              <p>
                <a href="#!">Link 4</a>
              </p>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

              <!-- Links -->
              <h6 class="text-uppercase font-weight-bold">Contato</h6>
              <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
              <p>
                <i class="fa fa-home mr-3"></i> R. Afonso Sardinha, 90 - Pioneiros, Ouro Branco - MG, 36420-000</p>
              <p>
                <i class="fa fa-envelope mr-3"></i>gabinete.ourobranco@ifmg.edu.br</p>
              <p>
                <i class="fa fa-phone mr-3"></i> (31) 3938-1200</p>

            </div>
            <!-- Grid column -->

          </div>
          <!-- Grid row -->

        </div>
        <!-- Footer Links -->

        <div style="background-color: #2a9d38;">
          
          <div class="container">
            <!-- Call to action -->
            <ul class="list-unstyled list-inline text-center py-4">
              <li class="list-inline-item">
                <style>
                  button{
                    background: red;
                  }
                </style>
                <a href="index.html"><button name="button" class="btn btn-secundary">Sair</button></a>
              </li>
            </ul>
            <!-- Call to action -->
          </div>

        </div>

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
