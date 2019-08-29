<?php

$sql = "select u.idUsuario, a.idAssociado, u.nome, u.cpf, a.pai, a.mae, a.dataNascimento, g.genero, a.fk_idGenero, a.fk_idNacionalidade, a.naturalidade, ec.estadoCivil, a.fk_idEstadoCivil, a.rg, gs.grupoSanguineo, a.fk_idGrupoSanguineo,

a.email, p.nomePT, a.fk_idPais, a.cep, a.estado, a.cidade, a.bairro, a.tipoLog, a.logradouro, a.numero, a.complemento, a.inss, a.carteiraTrabalho, a.serieCT, 

a.empresa, a.profissao, a.fk_idEscolaridade, a.dataAposentadoria, a.matriculaAAA, s.rotulo,  a.fk_idSituacao, a.ativo

FROM usuario AS u, associado AS a, genero AS g, estadoCivil AS ec, grupoSanguineo AS gs, pais AS p, situacao AS s

WHERE a.matriculaAAA = " . $matricula . " AND a.fk_idUsuario = u.idUsuario AND a.fk_idGenero = g.idGenero AND a.fk_idEstadoCivil = ec.idEstadoCivil 

AND a.fk_idGrupoSanguineo = gs.idGrupoSanguineo AND a.fk_idPais = p.idPais AND a.fk_idSituacao = s.idSituacao;";



$result = $con->query($sql);

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        $idUsuario = $row['idUsuario'];

        $idAssociado = $row['idAssociado'];

        $nome = ucwords($row['nome']);

        $pai = ucwords($row['pai']);

        $mae = ucwords($row['mae']);

        $cpf = $row['cpf'];

        $matricula = $row['matriculaAAA'];

        $dataNascimento = $row['dataNascimento'];

        $genero = $row['genero'];

        $idGenero = $row['fk_idGenero'];

        $idNacionalidade = $row['fk_idNacionalidade'];

        $naturalidade = $row['naturalidade'];

        $idEstadoCivil = $row['fk_idEstadoCivil'];

        $estadoCivil = $row['estadoCivil'];

        $rg = $row['rg'];

        $idGrupoSanguineo = $row['fk_idGrupoSanguineo'];

        $grupoSanguineo = $row['grupoSanguineo'];

        $email = $row['email'];

        $pais = $row['nomePT'];

        $idPais = $row['fk_idPais'];

        $cep = $row['cep'];

        $estado = $row['estado'];

        $cidade = $row['cidade'];

        $bairro = $row['bairro'];

        $tipoLog = $row['tipoLog'];

        $logradouro = $row['logradouro'];

        $numero = $row['numero'];

        $complemento = $row['complemento'];

        $inss = $row['inss'];

        $carteiraTrabalho = $row['carteiraTrabalho'];

        $serieCT = $row['serieCT'];

        $empresa = $row['empresa'];

        $profissao = $row['profissao'];

        $idEscolaridade = $row['fk_idEscolaridade'];

        $dataAposentadoria = $row['dataAposentadoria'];

        $idSituacao = $row['fk_idSituacao'];

        $situacao = $row['rotulo'];

        $ativo = $row['ativo'];



        $sql = "SELECT p.nomePT FROM pais as p WHERE p.idPais = '" . $idNacionalidade . "';";

        $resulta = $con->query($sql);

        if ($resulta->num_rows > 0) {

            // output data of each row

            while ($rows = $resulta->fetch_assoc()) {

                $nacionalidade = $rows["nomePT"];

            }

        }



        $sql = "SELECT esc.nivel, esc.situacao FROM escolaridade as esc WHERE esc.idEscolaridade = '" . $idEscolaridade . "';";

        $resulta = $con->query($sql);

        if ($resulta->num_rows > 0) {

            // output data of each row

            while ($rows = $resulta->fetch_assoc()) {

                $escolaridade = $rows["nivel"] . " " . $rows["situacao"];

            }

        }



        $telefone = array();

        $sql = "SELECT t.telefone,t.telefone2 FROM telefone AS t WHERE t.fk_idUsuario = '" . $idUsuario . "';";

        $resulta = $con->query($sql);

        if ($resulta->num_rows > 0) {

            // output data of each row

            while ($rows = $resulta->fetch_assoc()) {

                $telefone[0] = $rows["telefone"];

                $telefone[1] = $rows["telefone2"];

            }

        }



        date_default_timezone_set('America/Sao_Paulo');

        $today = date("Y-m-d");

        $diaTd = date("d");

        $mesTd = date("n");

        $anoTd = date("Y");



        list($ano, $mes, $dia) = explode('-', $dataNascimento);



        // Descobre que dia é hoje e retorna a unix timestamp

        $hoje = mktime(0, 0, 0, $mesTd, $diaTd, $anoTd);

                // Descobre a unix timestamp da data de nascimento do fulano

        $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);



        // Depois apenas fazemos o cálculo já citado :)

        $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);

        $aniversario = $dia . "/" . $mes;

        if ($complemento == null) {

            $endereco = $logradouro . "," . $numero . " - " . $bairro . ". " . $cidade . " - " . $estado . "/" . $cep . ". " . $pais;

        } else {

            $endereco = $logradouro . "," . $numero . "(" . $complemento . ") - " . $bairro . ". " . $cidade . " - " . $estado . "/" . $cep . ". " . $pais;

        }

     



        $imgUsuario = "0";

        $sql = "SELECT i.imgUsuario FROM imgUsuario as i WHERE i.fk_idUsuario = '" . $idUsuario . "';";

        $resulta = $con->query($sql);

        if ($resulta->num_rows > 0) {

            // output data of each row

            while ($rows = $resulta->fetch_assoc()) {

                $imgUsuario = $rows["imgUsuario"];

            }

        }else{            

            $imgUsuario = "0";

        }



        $imgDoc = array();

        $i = 0;

        $sql = "SELECT i.imgDoc FROM imgDoc as i WHERE i.fk_idUsuario = '" . $idUsuario . "';";

        $resulta = $con->query($sql);

        if ($resulta->num_rows > 0) {

            // output data of each row

            while ($rows = $resulta->fetch_assoc()) {

                $imgDoc[$i] = $rows["imgDoc"];

                $i++;

            }

        }else{            

            $imgDoc = null;

        }



        

    }

}



?>