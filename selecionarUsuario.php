<?php

$var = "[";
$i = 0;
$array = array();

$sql = "SELECT u.idUsuario,u.nome,u.cpf,u.tipo FROM usuario AS u ORDER BY u.nome;";


$result = $con->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $idUsuario = $row['idUsuario'];
        $nome = ucwords($row['nome']);
        $cpf = $row['cpf'];
        $tipo = $row['tipo'];
        $matricula = "";
        $ativo = "";

        if ($tipo == "socio") {
            $sql = "SELECT a.matriculaAAA, a.ativo FROM associado AS a WHERE a.fk_idUsuario = '" . $idUsuario . "';";
            $resulta = $con->query($sql);
            if ($resulta->num_rows > 0) {
                // output data of each row
                while ($rows = $resulta->fetch_assoc()) {
                    $matricula = $rows["matriculaAAA"];
                    $ativo = $rows["ativo"];
                }
            }
        } else {

            if (($tipo == "dependente")or ( $tipo == "dependente-agregado")) {
                $sql = "SELECT a.matriculaAAA, a.ativo FROM associado AS a, dependente as d WHERE d.fk_idAssociado = a.idAssociado and d.fk_idUsuario = '" . $idUsuario . "';";
                $resulta = $con->query($sql);
                if ($resulta->num_rows > 0) {
                    // output data of each row
                    while ($rows = $resulta->fetch_assoc()) {
                        $matricula = $rows["matriculaAAA"];
                        $ativo = $rows["ativo"];
                    }
                }
            } ELSE {
                $matricula = "-";
                $ativo = "-";
            }
        }

        $telefone[0] = "";
        $telefone[1] = "";
        $sql = "SELECT t.telefone,t.telefone2 FROM telefone AS t WHERE t.fk_idUsuario = '" . $idUsuario . "';";
        $resulta = $con->query($sql);
        if ($resulta->num_rows > 0) {
            // output data of each row
            while ($rows = $resulta->fetch_assoc()) {
                $telefone[0] = $rows["telefone"];
                $telefone[1] = $rows["telefone2"];
            }
        }

        if ($i != 0) {
            $var = $var . ",";
        }
        $var = $var . '{' .
            '"matricula" : "' . $matricula . '",' .
            '"idUsuario" : "' . $idUsuario . '",' .
            '"nome" : "' . $nome . '",' .
            '"cpf" : "' . $cpf . '",' .
            '"tipo" : "' . $tipo . '",' .
            '"telefone": {' . '"TEL":"' . $telefone[0] . '",' . '"TEL2":"' .
            $telefone[1] . '"' .
            '},' .
            '"ativo" : "' . $ativo . '"' .
            '}';
        $i++;
    }
}
$var = $var . ']';
$fp = fopen('data/usuarios.json', 'w');
$aux = json_encode($var);
$string = json_decode($aux);
fwrite($fp, $string);
fclose($fp);
?> 
