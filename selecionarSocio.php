<?php



require 'conexao.php';
set_time_limit(0);

$var = "[";

$i = 0;

$array = array();



$sql = "select u.idUsuario, a.idAssociado, u.nome, u.cpf, a.pai, a.mae, a.dataNascimento, g.genero, a.fk_idNacionalidade, a.naturalidade, ec.estadoCivil, a.rg, gs.grupoSanguineo,

a.email, p.nomePT, a.cep, a.estado, a.cidade, a.bairro, a.logradouro, a.tipoLog, a.numero, a.complemento, a.inss, a.carteiraTrabalho, a.serieCT, 

a.empresa, a.profissao, a.fk_idEscolaridade, a.dataAposentadoria, a.matriculaAAA, s.rotulo,a.ativo

FROM usuario AS u, associado AS a, genero AS g, estadoCivil AS ec, grupoSanguineo AS gs, pais AS p, situacao AS s

WHERE a.fk_idUsuario = u.idUsuario AND a.fk_idGenero = g.idGenero AND a.fk_idEstadoCivil = ec.idEstadoCivil 

AND a.fk_idGrupoSanguineo = gs.idGrupoSanguineo AND a.fk_idPais = p.idPais AND a.fk_idSituacao = s.idSituacao ORDER BY u.nome;";



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

        $nacionalidade = ucwords($row['fk_idNacionalidade']);

        $naturalidade = ucwords($row['naturalidade']);

        $estadoCivil = $row['estadoCivil'];

        $rg = $row['rg'];

        $grupoSanguineo = $row['grupoSanguineo'];

        $email = $row['email'];

        $pais = ucwords($row['nomePT']);

        $cep = $row['cep'];

        $estado = strtoupper($row['estado']);

        $cidade = strtoupper($row['cidade']);

        $bairro = ucwords($row['bairro']);

        $tipoLog = ucwords($row['tipoLog']);

        $logradouro = ucwords($row['logradouro']);

        $numero = $row['numero'];

        $complemento = $row['complemento'];

        $inss = $row['inss'];

        $carteiraTrabalho = $row['carteiraTrabalho'];

        $serieCT = $row['serieCT'];

        $empresa = ucwords($row['empresa']);

        $profissao = ucwords($row['profissao']);

        $escolaridade = $row['fk_idEscolaridade'];

        $dataAposentadoria = $row['dataAposentadoria'];

        $situacao = $row['rotulo'];

        $ativo = $row['ativo'];



        $telefone = array();

        $sql = "SELECT t.telefone,t.telefone2 FROM telefone AS t WHERE t.fk_idUsuario = '" . $idUsuario . "';";

        $resulta = $con->query($sql);

        if ($resulta->num_rows > 0) {

            // output data of each row

            while ($rows = $resulta->fetch_assoc()) {

                $telefone[0] = $rows["telefone"];

                $telefone[1] = $rows["telefone2"];

            }

        }else{

            $telefone[0] = "";

            $telefone[1] = "";

        }



        if (!isset($errMSG)) {

            $sql = "select nomePT from pais where idPais = '" . $nacionalidade . "';";

            $resulta = $con->query($sql) or die($con->error);



            if ($resulta->num_rows > 0) {

                while ($rows = $resulta->fetch_assoc()) {

                    $nacionalidade = $rows['nomePT'];

                }

            }

        }



        //Seleciona a quantidade de dependentes

        $dependente = 0;

        $sql = "SELECT * FROM usuario, dependente WHERE usuario.tipo = 'dependente' and usuario.idUsuario = dependente.fk_idUsuario and dependente.fk_idAssociado = '" . $idAssociado . "';";

        $resulta = $con->query($sql);

        if ($resulta->num_rows > 0) {

            // output data of each row

            while ($rows = $resulta->fetch_assoc()) {

                $dependente++;

            }

        }



        //Seleciona a quantidade de dependente-agregado.

        $dependenteSocio = 0;

        $sql = "SELECT * FROM usuario, dependente WHERE usuario.tipo = 'dependente-agregado' and usuario.idUsuario = dependente.fk_idUsuario and dependente.fk_idAssociado = '" . $idAssociado . "';";

        $resulta = $con->query($sql);

        if ($resulta->num_rows > 0) {

            // output data of each row

            while ($rows = $resulta->fetch_assoc()) {

                $dependenteSocio++;

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

            $endereco = $tipoLog . " " . $logradouro . ", " . $numero . ", " . $bairro . " - " . $cidade . " - " . $estado . "/" . $cep . " - " . $pais;

        } else {

            $endereco = $tipoLog . " " . $logradouro . ", " . $numero . "(" . $complemento . "), " . $bairro . " - " . $cidade . " - " . $estado . "/" . $cep . " - " . $pais;

        }



        if ($complemento == null) {

            $logCompleto = $tipoLog . " " . $logradouro . "," . $numero;

        } else {

            $logCompleto = $tipoLog . " " . $logradouro . "," . $numero . "(" . $complemento . ")";

        }



        $diff1Month = new DateInterval('P1M');

        $today = new DateTime();

        $today->setTimezone(new DateTimeZone('America/Sao_Paulo'));

        $today->format('Y\-m\-d');

        $minInicial = new DateTime();

        $minInicial->setTimezone(new DateTimeZone('America/Sao_Paulo'));

        $minInicial->format('Y\-m\-d');



        //Seleciona o primeiro mês de pagamento da mensalidade.

        $sql = "select min(dataReferenciaInicial), dataReferenciaFinal FROM mensalidade WHERE fk_idAssociado = '" . $idAssociado . "';";

        $res = $con->query($sql) or die($con->error);



        if ($res->num_rows > 0) {

            while ($r = $res->fetch_assoc()) {

                if (!is_null($r['min(dataReferenciaInicial)'])) {

                    $minInicial = DateTime::createFromFormat('Y-m-d', $r['min(dataReferenciaInicial)']);

                }

            }

        }







        $miss = false;

        $return = array();



        $interval = $today->diff($minInicial);

        $d = $interval->format('%m');

        $y = $interval->format('%y');

        $d = $d + (12 * $y);

        

        //Seleciona os meses NÃO pagos até a data atual.

        while ($d > 0) {

            $sql = "select dataReferenciaInicial FROM mensalidade WHERE dataReferenciaInicial = '" . $minInicial->format("Y-m-d") . "' and fk_idAssociado = '" . $idAssociado . "';";

            $res = $con->query($sql) or die($con->error);



            if ($res->num_rows > 0) {

                

            } else {

                $return[] = $minInicial->format("n") . "-" . $minInicial->format("Y") . ";";

            }

            $minInicial = $minInicial->add($diff1Month);

            $d--;

        }

        if(isset($return)){

            $retu = "";
            $retu = ', "debito" : "';

            if (count($return) > 0) {

                foreach ($return as $value) {

                    $retu .= $value;
                }

                $retu .= '"';

            } else {

                $retu = "";

            }
        }



        if ($i != 0) {

            $var = $var . ",";

        }

        //estrutura arquivo json

        $var = $var . '{' .

                '"idUsuario" : "' . $idUsuario . '",' .

                '"idAssociado" : "' . $idAssociado . '",' .

                '"nome" : "' . $nome . '",' .

                '"pai" : "' . $pai . '",' .

                '"mae" : "' . $mae . '",' .

                '"cpf" : "' . $cpf . '",' .

                '"matricula" : "' . $matricula . '",' .

                '"mat" : "' . $matricula . '",' .

                '"dataNascimento" : "' . $dataNascimento . '",' .

                '"genero" : "' . $genero . '",' .

                '"nacionalidade" : "' . $nacionalidade . '",' .

                '"naturalidade" : "' . $naturalidade . '",' .

                '"estadoCivil" : "' . $estadoCivil . '",' .

                '"grupoSanguineo" : "' . $grupoSanguineo . '",' .

                '"email" : "' . $email . '",' .

                '"pais" : "' . $pais . '",' .

                '"estado" : "' . $estado . '",' .

                '"cidade" : "' . $cidade . '",' .

                '"bairro" : "' . $bairro . '",' .

                '"logradouro" : "' . $logradouro . '",' .

                '"numero" : "' . $numero . '",' .

                '"complemento" : "' . $complemento . '",' .

                '"inss" : "' . $inss . '",' .

                '"carteiraTrabalho" : "' . $carteiraTrabalho . '",' .

                '"serieCT" : "' . $serieCT . '",' .

                '"empresa" : "' . $empresa . '",' .

                '"profissao" : "' . $profissao . '",' .

                '"escolaridade" : "' . $escolaridade . '",' .

                '"dataAposentadoria" : "' . $dataAposentadoria . '",' .

                '"situacao" : "' . $situacao . '",' .

                '"ativo" : "' . $ativo . '",' .

                '"telefone": {' . '"TEL":"' . $telefone[0] . '",' . '"TEL 2":"' .

                $telefone[1] . '"' .

                '},' .

                '"idade" : "' . $idade . '",' .

                '"aniversario" : "' . $aniversario . '",' .

                '"dependente" : "' . $dependente . '",' .

                '"dependenteSocio" : "' . $dependenteSocio . '",' .

                '"endereco" : "' . $endereco . '",' .

                '"logCompleto" : "' . $logCompleto . '"' .

                $retu .

                '}';



        $i++;

    }

}

$var = $var . ']';

//echo $var;

//salva data json;

$fp = fopen('data/associado.json', 'w');

$aux = json_encode($var);

$string = json_decode($aux);

fwrite($fp, $string);

fclose($fp);

?> 



