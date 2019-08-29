<?php



require 'conexao.php';



$sql = "SELECT d.idDependente, u.idUsuario, u.nome, u.cpf, a.idAssociado, d.dataNascimento, d.fk_idGenero, d.email, d.fk_idParentesco, d.agregado

FROM dependente AS d Join usuario AS u Join associado AS a

WHERE d.fk_idAssociado = a.idAssociado and d.fk_idUsuario = u.idUsuario ORDER BY u.nome;";



$result = $con->query($sql);

$var = "[";

$i = 0;



if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {



        $idDependente = $row['idDependente'];

        $idUsuario = $row['idUsuario'];

        $nome = ucwords($row['nome']);

        $cpf = $row['cpf'];

        $idAssociado = $row['idAssociado'];

        $dataNascimento = $row['dataNascimento'];

        $genero = $row['fk_idGenero'];

        $parentesco = $row['fk_idParentesco'];

        $agregado = $row['agregado'];

        $email = $row['email'];

        $telefone = array();

        

        

        if (!isset($errMSG)) {

            $sql = "select parentesco from parentesco where idParentesco = '" . $parentesco . "';";

            $resulta = $con->query($sql) or die($con->error);



            if ($resulta->num_rows > 0) {

                while ($rows = $resulta->fetch_assoc()) {

                    $parentesco = $rows['parentesco'];

                }

            }

        }

        

        if (!isset($errMSG)) {

            $sql = "select genero from genero where idGenero = '" . $genero . "';";

            $resulta = $con->query($sql) or die($con->error);



            if ($resulta->num_rows > 0) {

                while ($rows = $resulta->fetch_assoc()) {

                    $genero = $rows['genero'];

                }

            }

        }



        

        

        

        $sql = "SELECT t.telefone, t.telefone2 FROM telefone AS t WHERE t.fk_idUsuario = '" . $idUsuario . "';";

        $resulta = $con->query($sql);

        if ($resulta->num_rows > 0) {

            // output data of each row

            while ($rows = $resulta->fetch_assoc()) {

                $telefone[0] = $rows["telefone"];

                $telefone[1] = $rows["telefone2"];

            }

        }

        $nomeAssociado = "";

        $sql = "SELECT u.nome FROM usuario AS u, associado AS a WHERE a.fk_idUsuario = u.idUsuario AND a.idAssociado ='" . $idAssociado . "';";

        $results = $con->query($sql);

        if ($results->num_rows > 0) {

            // output data of each row

            while ($rows = $results->fetch_assoc()) {

                $nomeAssociado = ucwords($rows['nome']);

            }

        }

        if ($agregado == 0) {

            $tipoDependente = "dependente";

        } else {

            $tipoDependente = "dependente-agregado";

        }

        $matricula = "";

        $ativo = "";

        $sql = "SELECT a.matriculaAAA, a.ativo FROM associado AS a, dependente as d WHERE d.fk_idAssociado = a.idAssociado and d.fk_idUsuario = '" . $idUsuario . "';";

        $resulta = $con->query($sql);

        if ($resulta->num_rows > 0) {

            // output data of each row

            while ($rows = $resulta->fetch_assoc()) {

                $matricula = $rows["matriculaAAA"];

                $ativo = $rows["ativo"];

            }

        }

        if ($i != 0) {

            $var = $var . ",";

        }

        $var = $var . '{' .

            '"matricula" : "' . $matricula . '",' .

            '"ativo" : "' . $ativo . '",' .

            '"idDependente" : "' . $idDependente . '",' .

            '"idUsuario" : "' . $idUsuario . '",' .

            '"nome" : "' . $nome . '",' .

            '"cpf" : "' . $cpf . '",' .

            '"idAssociado" : "' . $idAssociado . '",' .

            '"nomeAssociado" : "' . $nomeAssociado . '",' .

            '"dataNascimento" : "' . $dataNascimento . '",' .

            '"genero" : "' . $genero . '",' .

            '"parentesco" : "' . $parentesco . '",' .

            '"tipoDependente" : "' . $tipoDependente . '",' .

            '"email" : "' . $email . '",' .

            '"telefone": {' . '"TEL":"' . $telefone[0] . '",' . '"TEL2":"' .

            $telefone[1] . '"' .

            '}' .

            '}';

        $i++;

    }

}

$var = $var . ']';

$fp = fopen('data/dependente.json', 'w');

$aux = json_encode($var);

$string = json_decode($aux);

fwrite($fp, $string);

fclose($fp);

?> 



