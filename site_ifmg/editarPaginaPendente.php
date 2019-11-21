<?php
  include("conexao.php"); //incluir arquivo com conexão ao banco de dados
  include("include/header.php");

  if (isset($_SESSION["email"])) { //SE EXISTIR AUTENTICAÇÃO
    if ($_SESSION['tipo'] == 2){ //SE O USUÁRIO LOGADO FOR DO TIPO ADMINISTRADOR
    
      if (!isset($_GET['id'])) { //se não tiver nenhum id passado pela url deve-se redirecionar o usuário para a página inicial

        echo "<script>window.location = 'index.php';</script>";
        exit;

      } else {

        $id = $_GET['id']; 

        $sqlPagina = "SELECT * FROM pagina_pendente JOIN usuario ON pagina_pendente.id_autor = usuario.id WHERE id =" . $id;

        $resultPagina = $conn->query($sqlPagina);

        if ($resultPagina->num_rows > 0) { // Exibindo cada linha retornada com a consulta
          while ($exibirPagina = $resultPagina->fetch_assoc()){
            $nome = $exibirPagina["nome"];
            $conteudo = $exibirPagina["conteudo"];

            $autor = ucwords($exibirPagina["nome"]);
            $autorId = $exibirPagina["id"];

            $datetimeAlt = $exibirPagina["data_alteracao"];
            $datetime = new DateTime($datetimeAlt);
            $datetime = $datetime->format('d/m/Y H:i:s');
            $dataAlteracao = substr($datetime, 0, 10); 
            $horaAlteracao = substr($datetime, 11, 8); 
          } // fim while
        } else { //se não achar nenhum registro
          echo "<script>alert('Não há dados cadastrados com o id informado.');
                        window.location.href='index.php';
                </script>";
          exit;
        }

        //SE ATUALIZAR POST
        if (isset($_POST["atualizar"])) {

          $nomeAtualizado = addslashes($_POST["nome"]);
          $conteudoAtualizado = addslashes($_POST["conteudo"]);

          $autorAprovacao = $_SESSION['id'];

          $sqlAtualizarPagina = "UPDATE pagina SET nome = '".$nomeAtualizado."', conteudo = '".$conteudoAtualizado."', 
                                data_alteracao = '". $datetimeAlt ."', nome = '".$autorId."', data_aprovacao = CURRENT_TIME(), 
                                id_autor_aprovacao = '".$autorAprovacao."' WHERE id = ".$id;
          
          if ($conn->query($sqlAtualizarPagina) === TRUE) {

            $sqlAtualizarPaginaPendente = "UPDATE pagina_pendente SET aprovacao = 1 WHERE id = ".$id;
          
            if ($conn->query($sqlAtualizarPaginaPendente) === TRUE) {
              echo "<script>alert('Atualização realizada com sucesso!');</script>";
              echo "<script>window.location = 'pagina.php?id=" . $id . "';</script>";
            } else {
              echo "Erro: " . $sqlAtualizarPaginaPendente . "<br>" . $conn->error;
            }

          } else {
            echo "Erro: " . $sqlAtualizarPagina . "<br>" . $conn->error;
          }
          $conn->close();
              
        } //fim se atualizar post
    }

?>

<!-- Page Content -->
    <div class="container"> <!--início container do post-->
          <!--início grid do post-->
          <div class="row">
            <div class="col-md-12"> 
              <!-- início do post -->
              <div class = "post">
                <h1>Editar <?php echo ucwords($nome); ?></h1>
                <hr>
                <form class="form-horizontal" method="POST" action="editarPaginaPendente.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                
                  <!--início do campo do formulário-->
                  <div class="form-group">
                  <label class="control-label col-sm-3" for="nome">Título da página:</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome;?>" required>
                  </div> <!--fim col-sm-5-->
                  </div> <!--fim form'-group-->
                <!--fim do campo do formulário-->

                <!--início do campo do formulário-->
                  <div class="form-group">
                  <label class="control-label col-sm-3" for="nome">Autor(a):</label>
                  <div class="col-sm-12">
                    <input readonly type="text" class="form-control" id="autor" name="autor" value="<?php echo $autor;?>" required>
                  </div> <!--fim col-sm-5-->
                  </div> <!--fim form'-group-->
                <!--fim do campo do formulário-->

                <!--início do campo do formulário-->
                  <div class="form-group">
                  <label class="control-label col-sm-3" for="nome">Data de alteração:</label>
                  <div class="col-sm-12">
                    <input readonly type="text" class="form-control" id="dataAlteracao" name="dataAlteracao" value="<?php echo $dataAlteracao;?> às <?php echo $horaAlteracao;?>" required>
                  </div> <!--fim col-sm-5-->
                  </div> <!--fim form'-group-->
                <!--fim do campo do formulário-->
                
                <div class="form-group">
                  <label class="control-label col-sm-3" for="conteudo">Conteúdo:</label>
                  <div class="col-sm-12">
                    <textarea class="form-control" id="conteudo" name="conteudo"><?php echo $conteudo;?></textarea>
                    <!--início editor de texto-->
                    <script type="text/javascript">
                      CKEDITOR.replace('conteudo');
                    </script>
                    <!--fim editor de texto-->
                  </div> <!--fim col-sm-5-->
                </div> <!--fim form-group-->
                
                <br>
                
                <p>
                  <input type="submit" class="btn btn-primary" name="atualizar" value="Atualizar"></input>
                  <a href="javascript:window.history.go(-1)"><input type="button" class="btn btn-default" value="Cancelar"></input></a>
                </p>
                
                <br>

                </form>
                
              </div> <!-- fim da div post -->
              <!-- fim do post -->  
                
            </div><!--fim col-md-8-->
            
          </div> <!--fim row -->
    </div>

<?php
	include("include/footer.php");
  }else {
    echo "<script>window.location = 'index.php';</script>";
  }
} else {
  echo "<script>window.location = 'index.php';</script>";
}
?>