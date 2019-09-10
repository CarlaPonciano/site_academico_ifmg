<?php

require_once ("conexao.php");
$idSocio = $_GET["idSocio"];
$idUser = $_GET["idUser"];

//verifica se foi enviado algum valor
if (isset($_POST["atualizeSocio"])) {
//recebe os valores enviados pelo formulário
    $nome = addslashes(strtolower($_POST['nome']));
    $dataNascimento = addslashes($_POST['dataNascimento']);
    $mae = addslashes(strtolower($_POST['mae']));
    $pai = addslashes(strtolower($_POST['pai']));
    $genero = $_POST['genero'];
    $nacionalidade = strtoupper($_POST['nacionalidade']);
    $naturalidade = addslashes(strtoupper($_POST['naturalidade']));
    $estadoCivil = $_POST['estadoCivil'];
    $rg = addslashes($_POST['rg']);
    $grupoSanguineo = $_POST['grupoSanguineo'];
    $telefone = addslashes($_POST['telefone']);
    $telefone2 = addslashes($_POST['telefone2']);
    $email = strtolower($_POST['email']);
    $pais = $_POST['pais'];
    $cep = addslashes($_POST['cep']);
    $estado = addslashes(strtoupper($_POST['estado']));
    $cidade = addslashes(ucwords($_POST['cidade']));
    $bairro = addslashes(ucwords($_POST['bairro']));
    $tipoLog = addslashes(ucwords($_POST['tipoLog']));
    $logradouro = addslashes(ucwords($_POST['logradouro']));
    $numero = $_POST['numero'];
    $complemento = addslashes($_POST['complemento']);
    $inss = addslashes($_POST['inss']);
    $carteiraTrabalho = addslashes($_POST['carteiraTrabalho']);
    $serie = addslashes($_POST['serie']);
    $empresa = addslashes($_POST['empresa']);
    $profissao = addslashes($_POST['profissao']);
    $escolaridade = $_POST['escolaridade'];
    $dataAposentadoria = addslashes($_POST['dataAposentadoria']);
    $matricula = $_POST["matricula"];

    if (!isset($errMSG)) {

        $sql = 'UPDATE usuario SET nome="' . $nome . 
        '" WHERE idUsuario =' . $idUser . ';';

        if ($con->query($sql) === true) {
        } else {
            $errMSG = "1 error while inserting....2";
            echo $errMSG;
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }

        $sql = 'UPDATE associado SET dataNascimento="' . $dataNascimento . '", mae = "' . $mae . '", pai = "' . $pai . '", fk_idGenero="' . $genero . '",fk_idNacionalidade="' . $nacionalidade . '",naturalidade="' . $naturalidade . '",'
        . 'fk_idEstadoCivil = "' . $estadoCivil . '",rg = "' . $rg . '",fk_idGrupoSanguineo = "' . $grupoSanguineo . '",email = "' . $email . '",'
        . 'fk_idPais = "' . $pais . '",cep = "' . $cep . '",estado = "' . $estado . '",cidade = "' . $cidade . '",'
        . 'bairro = "' . $bairro . '", tipoLog = "' . $tipoLog . '", logradouro = "' . $logradouro . '",numero = "' . $numero . '",complemento = "' . $complemento . '",'
        . 'inss = "' . $inss . '",carteiraTrabalho = "' . $carteiraTrabalho . '",serieCT = "' . $serie . '", empresa = "' . $empresa . '", profissao = "' . $profissao . '", fk_idEscolaridade = ' . $escolaridade . ', dataAposentadoria = "' . $dataAposentadoria . '" WHERE idAssociado = ' . $idSocio . ';';

        if ($con->query($sql) === true) {
        } else {
            $errMSG = "2 error while inserting....2";
            echo $errMSG;
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }

        $sql = "UPDATE `telefone` SET `telefone` = '" . $telefone . "' ,`telefone2` = '" . $telefone2 . "' WHERE `fk_idUsuario` = '" . $idUser . "';";
        if ($con->query($sql) == true) {

        } else {
            $errMSG = "3 error while inserting....2";
            echo $errMSG;
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }

        $imgUsuario = $_FILES["imgUsuario"];

        $update = false;
        $SQL = "SELECT i.imgUsuario FROM imgUsuario as i WHERE fk_idUsuario ='" . $idUser . "';";
        $result = $con->query($SQL);

        $folder = "imgUsuario";

        if ($result->num_rows > 0) {
            $update = true;
            while ($row = $result->fetch_assoc()) {
                $im = $row["imgUsuario"];
                //echo $im;
            }
        }

        //define os tipos suportados de arquivos enviados
        $permite = array("tif", "jpg", "jpeg", "png", "pdf");
        $maxSize = 1024 * 1024 * 5;
        //Mensagens
        $msg = array(); //cria um array vazio
        //cria um array e já atribui valores das mensagens a ele.
        $erroMsg = array(
        1 => "O arquivo é maior que o limite definido no max_filesize",
        2 => "O aquivo ultrapassa o limite de tamanho permitido no MAX_FILE_SIZE",
        3 => "O upload do arquivo foi feito parcialmente",
        4 => "Não foi feito o upload do arquivo"
        );

        $name = $imgUsuario["name"][0]; //pega o nome
        $type = $imgUsuario["type"][0]; //pega o tipo do arquivo
        $size = $imgUsuario["size"][0]; //pega o tamanho
        $error = $imgUsuario["error"][0]; //pega os erros
        $tmp = $imgUsuario["tmp_name"][0]; //pega o nome temporário do arquivo quando ele está sendo passado do cliente para o servidor

        $extensao = @end(explode(".", $name)); //pega extensão de cada arquivo
        //var_dump($extensao); //para debugar e ver se está pegando a extensão dos arquivos

        $novoNome = $idUser . "_" . "imgUsuario" . ".$extensao"; //gerando um novo nome para os arquivos
        //abaixo estamos tratando as mensagens a serem exibidas para o usuário, em casos de erro ou sucesso no upload
        if ($error != 0) { //se não houver erro ao carregar a imagem
            $msg[] = "<b>$name: </b>" . $erroMsg[$error];
        } else if (!in_array($extensao, $permite)) {
            $msg[] = "<b>$name: </b> Erro - Tipo de arquivo não suportado. Escolha arquivo do tipo .jpg, .png e .pdf.";
        } else if ($size > $maxSize) {
            $msg[] = "<b>$name: </b>Erro - Tamanho do arquivo é maior que o permitido.";
        } else {
            //move o arquivo para a pasta definida 

            $bool = move_uploaded_file($tmp, $folder . "/" . $novoNome);
            if ($bool) {
                if($update){

                }else{

                    $SQL = "INSERT INTO imgUsuario (fk_idUsuario, imgUsuario) VALUES ('" . $idUser . "','" . $novoNome . "');";
                    if ($con->query($SQL) === TRUE) { //verifica se o comando foi executado com sucesso
                    $msg[] = "<b>$name: </b> Upload realizado com sucesso.";
                    } else {
                    //mensagem exibida caso ocorra algum erro na execução do comando sql
                    $msg[] = "<b>$name: </b> Erro - " . $con->error;
                    }
                }
            }
        }

        $imgDoc = $_FILES["imgDoc"];

        $SQL = "SELECT * FROM imgDoc;";
        $result = $con->query($SQL);

        $j = 0;

        while($row = $result->fetch_assoc()){
            $j = $row['idImgDoc'];
            //echo "$j";
            //echo $j;
        }

        $numFile = count(array_filter($imgDoc['name']));
        //define qual pasta a imagem será salva
        $folder = "imgDoc";
        //define os tipos suportados de arquivos enviados
        $permite = array("tif", "jpg", "jpeg", "png", "pdf");
        $maxSize = 1024 * 1024 * 5;
        //Mensagens
        $msg = array(); //cria um array vazio
        //cria um array e já atribui valores das mensagens a ele.
        $erroMsg = array(
          1 => "O arquivo é maior que o limite definido no max_filesize",
          2 => "O aquivo ultrapassa o limite de tamanho permitido no MAX_FILE_SIZE",
          3 => "O upload do arquivo foi feito parcialmente",
          4 => "Não foi feito o upload do arquivo"
        );

        for ($i = 0; $i < $numFile; $i++) {
        //echo "come";
            $name = $imgDoc["name"][$i]; //pega o nome
            $type = $imgDoc["type"][$i]; //pega o tipo do arquivo
            $size = $imgDoc["size"][$i]; //pega o tamanho
            $error = $imgDoc["error"][$i]; //pega os erros
            $tmp = $imgDoc["tmp_name"][$i]; //pega o nome temporário do arquivo quando ele está sendo passado do cliente para o servidor

            $extensao = @end(explode(".", $name)); //pega extensão de cada arquivo
            //var_dump($extensao); //para debugar e ver se está pegando a extensão dos arquivos


            $j++;
            $novoNome = $idUser . "_" . $j . ".$extensao"; //gerando um novo nome para os arquivos
            //abaixo estamos tratando as mensagens a serem exibidas para o usuário, em casos de erro ou sucesso no upload

            if ($error != 0) { //se não houver erro ao carregar a imagem
                $msg[] = "<b>$name: </b>" . $erroMsg[$error];
            } else if (!in_array($extensao, $permite)) {
                $msg[] = "<b>$name: </b> Erro - Tipo de arquivo não suportado. Escolha arquivo do tipo .jpg, .png e .pdf.";
            } else if ($size > $maxSize) {
                $msg[] = "<b>$name: </b>Erro - Tamanho do arquivo é maior que o permitido.";
            } else {
                //move o arquivo para a pasta definida 
                if (move_uploaded_file($tmp, $folder . "/" . $novoNome)) {
                    $SQL = "INSERT INTO imgDoc (fk_idUsuario, imgDoc) VALUES ('" . $idUser . "','" . $novoNome . "')";
                    if ($con->query($SQL) === TRUE) { //verifica se o comando foi executado com sucesso
                        $msg[] = "<b>$name: </b> Upload realizado com sucesso.";
                    } else {
                        //mensagem exibida caso ocorra algum erro na execução do comando sql
                        $msg[] = "<b>$name: </b> Erro - " . $con->error;
                    }
                } else {
                    $msg[] = "<b>$name: </b> Desculpe! Ocorreu um erro ao fazer upload do arquivo.";
                }
            }
        }

    }

echo "<script language='javascript' type='text/javascript'>alert('Atualização realizada com sucesso!');window.location.href='exibirSocio.php?matricula=" . $matricula . "';</script>";
die();
}
?>
