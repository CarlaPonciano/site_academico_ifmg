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
        <!--<a class="fb-ic">
          <i class="fa fa-facebook white-text mr-4"> </i>
        </a>-->
        <!-- Twitter -->
        <!--<a class="tw-ic" href="https://www.instagram.com/sistemasifmgob/?hl=pt-br">
          <i class="fa fa-twitter white-text mr-4"> </i>
        </a>-->
        <!-- Google +-->
        <!--<a class="gplus-ic">
          <i class="fa fa-google-plus white-text mr-4"> </i>
        </a>-->
        <!--Linkedin -->
        <!--<a class="li-ic">
          <i class="fa fa-linkedin white-text mr-4"> </i>
        </a>-->
        <!--Instagram-->
        <a class="ins-ic" href="https://www.instagram.com/sistemasifmgob/?hl=pt-br" target="_blank"><i class="fa fa-instagram white-text"> </i></a>

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
  <!-- Janela para Login -->
  <br><br>
  <form class="form-horizontal" method="POST" action="login.php" enctype="multipart/form-data" data-toggle="validator">
    <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
      aria-hidden="true" style="color:black">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header text-center">
            <h4 class="modal-title w-100 font-weight-bold">Fazer Login</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body mx-3">
            <div class="md-form mb-5">
              <i class="fas fa-envelope prefix grey-text"></i>
              <input type="email" id="email" name = "email" class="form-control validate" placeholder="Seu e-mail">
            </div>
    
            <div class="md-form mb-4">
              <i class="fas fa-lock prefix grey-text"></i>
              <input type="password" id="senha" name = "senha" class="form-control validate" placeholder="Sua senha">
            </div>
    
          </div>
          <div class="modal-footer d-flex justify-content-center">
            <input type="submit" class="btn btn-success" name="login" value="Entrar"></input>
          </div>
        </div>
      </div>
    </div>
  </form>

  <?php
      if (isset($_SESSION["email"])) {
  ?>
<div class="text-center">
        <style>
          button{
            background: #e60000;
            color: white;
          }
        </style>
        <a href="logout.php"><button name="button" class="btn btn-secundary">Sair</button></a>
  
</div>
<?php   
      }else{
  ?>
  <div class="text-center">
  <a href="" class="btn btn-primary btn-rounded " data-toggle="modal" data-target="#modalLoginForm" 
  >Login para Professores</a>
</div>
<?php   
      }
  ?>
  <!-- Fim da Janela do Login -->
  <div class="container">
    <!-- Call to action -->
    <ul class="list-unstyled list-inline text-center py-4">
      <!--<li class="list-inline-item">
        <h6 class="mb-1">Login para Professores</h6>
      </li>
      <li class="list-inline-item">
        <a href="login/index.html" class="btn btn-secondary btn-rounded">Login</a>
      </li>-->
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
<script src="vendor-main-website/jquery/jquery.min.js"></script>
<script src="vendor-main-website/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
