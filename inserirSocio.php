<?php

require_once ("conexao.php");

//verifica se foi enviado algum valor
if (isset($_POST["insertAssociado"])) {
//recebe os valores enviados pelo formulário
    $nome = addslashes(ucwords($_POST['nome']));
    $pai = addslashes(ucwords($_POST['pai']));
    $mae = addslashes(ucwords($_POST['mae']));
    $dataNascimento = addslashes($_POST['dataNascimento']);
    $genero = $_POST['genero'];
    $nacionalidade = ucwords($_POST['nacionalidade']);
    $naturalidade = addslashes(ucwords($_POST['naturalidade']));
    $estadoCivil = $_POST['estadoCivil'];
    $rg = addslashes($_POST['rg']);
    $cpf = addslashes($_POST['cpf']);
    $grupoSanguineo = $_POST['grupoSanguineo'];
    $telefone = addslashes($_POST['telefone']);
    $telefone2 = addslashes($_POST['telefone2']);
    $email = addslashes(strtolower($_POST['email']));
    $pais = $_POST['pais'];
    $cep = addslashes($_POST['cep']);
    $estado = addslashes(strtoupper($_POST['estado']));
    $cidade = addslashes(ucwords($_POST['cidade']));
    $bairro = addslashes(ucwords($_POST['bairro']));
    $tipo = addslashes(ucwords($_POST['tipoLog']));
    $logradouro = addslashes(ucwords($_POST['logradouro']));
    $numero = $_POST['numero'];
    $complemento = addslashes($_POST['complemento']);
    $inss = addslashes($_POST['inss']);
    $carteiraTrabalho = addslashes($_POST['carteiraTrabalho']);
    $serie = addslashes($_POST['serie']);
    $empresa = addslashes(ucwords($_POST['empresa']));
    $profissao = addslashes($_POST['profissao']);
    $escolaridade = addslashes($_POST['escolaridade']);
    $dataAposentadoria = addslashes($_POST['dataAposentadoria']);
    $matricula = $_POST['matricula'];

    $idUsuario = "";
    $idEstado = "";
    $idEndereco = "";
    $idAssociado = "";

    //>> Verifica se já não há usuário com o cpf ou número de matrícula
    if (!isset($errMSG)) {
        $sql = "select nome, cpf,matriculaAAA from usuario INNER JOIN associado on usuario.idUsuario = associado.fk_idUsuario where usuario.cpf = '" . $cpf . "' or matriculaAAA = '" . $matricula . "';";
        $result = $con->query($sql) or die($con->error);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo"<script language='javascript' type='text/javascript'>alert('O CPF ou a matrícula digitados já estão cadastrados como o usuário " . ucwords($row['nome']) . ".');window.location.href='cadastrarSocio.php';</script>";
                die();
            }
        }
    }

    if (!isset($errMSG)) {
        //>> Insere no BD o usuário base dados para login
        $sql = 'INSERT INTO usuario(nome,cpf, login, senha, tipo) VALUES("' . $nome . '","' . $cpf . '","' . $cpf . '","' . $matricula . '","socio" );';

        if ($con->query($sql) == true) {
            $sql = "select idUsuario from usuario WHERE cpf='" . $cpf . "';";
            $result = $con->query($sql) or die($con->error);
            while ($row = $result->fetch_assoc()) {
                unset($id, $name);
                $idUsuario = $row['idUsuario'];
            }
        } else {
            $errMSG = "error while inserting....1";
            echo $errMSG;
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }

        //>>Insere no BD valores de associado
        $sql = 'INSERT INTO associado(fk_idUsuario,pai,mae,dataNascimento,fk_idGenero,fk_idNacionalidade,naturalidade,fk_idEstadoCivil,rg,fk_idGrupoSanguineo,email,fk_idPais,cep,estado,cidade,bairro,tipoLog,logradouro,numero,complemento,inss,carteiraTrabalho,serieCT,empresa,profissao,fk_idEscolaridade,dataAposentadoria,matriculaAAA,fk_idSituacao,ativo) '
                . 'VALUES("' . $idUsuario . '","' . $pai . '","' . $mae . '","' . $dataNascimento . '","' . $genero . '","' . $nacionalidade . '","' . $naturalidade . '","' . $estadoCivil . '","' . $rg . '","' . $grupoSanguineo . '","' . $email . '","' . $pais . '","' . $cep . '","' . $estado . '","' . $cidade . '","' . $bairro . '","' . $tipo . '","' . $logradouro . '","' . $numero . '","' . $complemento . '","' . $inss . '","' . $carteiraTrabalho . '","' . $serie . '","' . $empresa . '","' . $profissao . '","' . $escolaridade . '","' . $dataAposentadoria . '","' . $matricula . '",3,true)';

        if ($con->query($sql) === true) {
            $sql = "select idAssociado from associado WHERE fk_idUsuario='" . $idUsuario . "';";
            $result = $con->query($sql) or die($con->error);
            while ($row = $result->fetch_assoc()) {
                unset($id, $name);
                //>>Guarda o idAssociado para próximas inserções
                $idAssociado = $row['idAssociado'];
            }
        } else {
            $errMSG = "error while inserting....2";
            echo $errMSG;
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }

        //Insere no BD os telefones de acordo com idAssociado
        $sql = 'INSERT INTO telefone(fk_idUsuario, telefone, telefone2) '
                . 'VALUES("' . $idUsuario . '","' . $telefone . '","' . $telefone2 . '")';

        if ($con->query($sql) === true) {

        } else {
            $errMSG = "error while inserting....3";
            echo $errMSG;
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }

        /* >>Guarda na hospedagem as imagens de documentos anexos. */
        $SQL = "SELECT * FROM imgDoc;";
        $result = $con->query($SQL);

        $j = 0;

        while ($row = $result->fetch_assoc()) {
            $j = $row['idImgDoc'];
            //echo "$j";
            //echo $j;
        }

        //recebe os valores enviados pelo formulário
        $imgDoc = $_FILES["imgDoc"];

        //conta quantas imagens foram enviadas
        $numFile = count(array_filter($imgDoc['name']));

        //define qual pasta a imagem será salva
        $folder = "imgDoc";

        //define os tipos suportados de arquivos enviados
        $permite = array("tif", "jpg", "jpeg", "png", "pdf");

        //define o tamanho máximo
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
            $name = $imgDoc["name"][$i]; //pega o nome
            $type = $imgDoc["type"][$i]; //pega o tipo do arquivo
            $size = $imgDoc["size"][$i]; //pega o tamanho
            $error = $imgDoc["error"][$i]; //pega os erros
            $tmp = $imgDoc["tmp_name"][$i]; //pega o nome temporário do arquivo quando ele está sendo passado do cliente para o servidor

            $extensao = @end(explode(".", $name)); //pega extensão de cada arquivo
            //var_dump($extensao); //para debugar e ver se está pegando a extensão dos arquivos

            $j++;

            $novoNome = $idUsuario . "_" . $j . ".$extensao"; //gerando um novo nome para os arquivos

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

                    /* >>Insere no BD onome do documento de acorod com idUsuario */
                    $SQL = "INSERT INTO imgDoc (fk_idUsuario, imgDoc) VALUES ('" . $idUsuario . "','" . $novoNome . "')";

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

        //>>Guarda imagem na hospedagem
        $imgUsuario = $_FILES["imgUsuario"];

        $folder = "imgUsuario";
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

        $novoNome = $idUsuario . "_" . "imgUsuario" . ".$extensao"; //gerando um novo nome para os arquivos

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

                //>> Insere nome da imagem no BD de acorso com o idUsuario
                $SQL = "INSERT INTO imgUsuario (fk_idUsuario, imgUsuario) VALUES ('" . $idUsuario . "','" . $novoNome . "')";

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

    include 'selecionarSocio.php';

    mysqli_close($con);
}

echo "<script language='javascript' type='text/javascript'>alert('Cadastro realizado com sucesso!');window.location.href='cadastrarSocio.php';</script>";

die();

?>

    