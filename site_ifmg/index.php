<?php 
  include ("include/header.php");
  include("include/limitaTexto.php");
?>


    <!-- Page Content -->
    <div class="container">

      <h3 class="my-4">Bem-vindo(a) ao Curso Bacharelado de Sistemas de Informação!</h3>


      <!-- seções de páginas -->

      <?php

        $sqlSecaoPaginasIndex = "SELECT id, titulo FROM secao_pagina WHERE exibir = 1";

        $resultSecaoPaginasIndex = $conn->query($sqlSecaoPaginasIndex);

        if ($resultSecaoPaginasIndex->num_rows > 0) { // Exibindo cada linha retornada com a consulta
          while ($exibirSecaoPaginasIndex = $resultSecaoPaginasIndex->fetch_assoc()){
            $idSecaoPaginasIndex = $exibirSecaoPaginasIndex["id"];
            $nomeSecaoPaginasIndex = ucwords($exibirSecaoPaginasIndex["titulo"]);
      ?>
            <h3><?php echo $nomeSecaoPaginasIndex; ?></h3><br>
          
            <div class="row">
              
              <?php

                $sqlPaginaIndex = "SELECT id, nome, conteudo FROM pagina WHERE exibir = 1 AND id_secao_pag = " . $idSecaoPaginasIndex;

                $resultPaginaIndex = $conn->query($sqlPaginaIndex);

                if ($resultPaginaIndex->num_rows > 0) { // Exibindo cada linha retornada com a consulta
                  while ($exibirPaginaIndex = $resultPaginaIndex->fetch_assoc()){
                    $idPaginaIndex = $exibirPaginaIndex["id"];
                    $nomePaginaIndex = ucwords($exibirPaginaIndex["nome"]);
                    $conteudoPaginaIndex = $exibirPaginaIndex["conteudo"];
              ?>

                    <div class="col-lg-4 mb-4">
                      <div class="card h-100">
                        <h4 class="card-header"><?php echo $nomePaginaIndex; ?></h4>
                        <div class="card-body">
                          <p style="padding-top: -50px;" class="card-text"><?php echo limitarTexto($conteudoPaginaIndex, $limite=200);?></p>
                        </div>
                        <div class="card-footer">
                          <a href="pagina.php?id=<?php echo $idPaginaIndex; ?>" class="btn btn-primary">Saiba Mais</a>
                        </div>
                      </div>
                    </div>

              <?php
                  } // fim while pagina
                } // fim if pagina
              ?>
              
            </div>
            <!-- /.row -->
            <hr>

      <?php
          } // fim while SecaoPaginas
        } // fim if SecaoPaginas
      ?>

      <!-- fim seções de páginas -->

      

      <!-- seções de postagens -->

      <?php
        
        $sqlSecaoPosts = "SELECT id,titulo FROM secaoposts WHERE exibir = 1;";

        $resultSecaoPosts = $conn->query($sqlSecaoPosts);

        if ($resultSecaoPosts->num_rows > 0) { // Exibindo cada linha retornada com a consulta
          while ($exibirSecaoPosts = $resultSecaoPosts->fetch_assoc()){
            $idSecao = $exibirSecaoPosts["id"];
            $tituloSecao = $exibirSecaoPosts["titulo"];
      ?>
            <hr>

            <div class="row">
              <div class="col-lg-8 col-sm-6 ">
                <h2><?php echo $tituloSecao;?></h2>
              </div>
              <div class="col-lg-4 col-sm-6">
                <a class="float-right" href="postagens.php?id=<?php echo $idSecao;?>">Ver todas as postagens</a>
              </div>
            </div>

            <div class="row">

            <?php

              $sqlPosts = "SELECT idPost, titulo, conteudo, img FROM post WHERE cadastro = 1 AND SecaoPosts_id = " . $idSecao . " ORDER BY dataAprovacao DESC LIMIT 3;";

              $resultPosts = $conn->query($sqlPosts);

              if ($resultPosts->num_rows > 0) { // Exibindo cada linha retornada com a consulta
                while ($exibirPosts = $resultPosts->fetch_assoc()){
                  $idPost = $exibirPosts["idPost"];
                  $titulo = $exibirPosts["titulo"];
                  $conteudo = $exibirPosts["conteudo"];
                  $img = $exibirPosts["img"];
            ?>
                  <div class="col-lg-4 col-sm-6 portfolio-item">
                    <div class="card h-100">
                      <a href="post.php?id=<?php echo $idPost; ?>">
                        <img class="card-img-top crop-image-post-index" src="upload/img-post/<?php echo $img; ?>" alt="">
                      </a>
                      <div class="card-body">
                        <h4 class="card-title">
                          <a href="post.php?id=<?php echo $idPost; ?>"><?php echo $titulo; ?></a>
                        </h4>
                        <p class="card-text"><?php echo limitarTexto($conteudo, $limite=270); ?></p>
                      </div>
                      <div class="card-footer">
                        <a href="post.php?id=<?php echo $idPost; ?>" class="btn btn-primary">Saiba Mais</a>
                      </div>
                    </div>
                  </div>

            <?php

                } // fim while
              } // fim if

            ?>
                  
        </div>
        <!-- /.row -->

      <?php

          } // fim while
        } // fim if

      ?>

      <!-- fim seções de postagens -->

    </div>

    <?php
      include("include/footer.php");
    ?>