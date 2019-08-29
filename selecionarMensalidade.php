<?php



require 'conexao.php';

$MES[1] = "janeiro";

$MES[2] = "fevereiro";

$MES[3] = "março";

$MES[4] = "abril";

$MES[5] = "maio";

$MES[6] = "junho";

$MES[7] = "julho";

$MES[8] = "agosto";

$MES[9] = "setembro";

$MES[10] = "outubro";

$MES[11] = "novembro";

$MES[12] = "dezembro";

$sql = "select a.matriculaAAA, u.nome, u.cpf, m.valor, m.idMensalidade, m.dataPagamento, m.dataReferenciaInicial, m.dataReferenciaFinal

FROM mensalidade as m, associado AS a, usuario AS u

WHERE m.fk_idAssociado = a.idAssociado AND a.fk_idUsuario = u.idUsuario ORDER BY u.nome;";

$result = $con->query($sql);

$var = "[";

$i = 0;



if ($result->num_rows > 0) {



    while ($row = $result->fetch_assoc()) {



        $nome = ucwords($row['nome']);

        $cpf = $row['cpf'];

        $matricula = $row['matriculaAAA'];

        $idMensalidade = $row['idMensalidade'];

        $valor = $row['valor'];

        $dataPagamento = $row['dataPagamento'];

        $dataReferenciaInicial = $row['dataReferenciaInicial'];

        $dataReferenciaFinal = $row['dataReferenciaFinal'];



        date_default_timezone_set('America/Sao_Paulo');

        $today = date("Y-m-d");

        $diaTd = date("d");

        $mesTd = date("n");

        $anoTd = date("Y");



        list($anoI, $mesI, $diaI) = explode('-', $dataReferenciaInicial);

        $mesI = (int) $mesI;

        $anoI = (int) $anoI;

        list($anoV, $mesV, $diaV) = explode('-', $dataReferenciaFinal);

        $mesV = (int) $mesV;

        $anoV = (int) $anoV;



        //descobre quantos meses foram pagos nesse cadastro

        $diff = date_diff(date_create($dataReferenciaFinal), date_create($dataReferenciaInicial));



            //dá nome aos meses pagos

        if ($diff->format("%m") == "1") {

            $mesesReferencia = $MES[$mesI] . "/" . $anoI;

        } else {

            $date = date_create($dataReferenciaFinal);

            date_sub($date, date_interval_create_from_date_string("1 month"));

            $mesesReferencia = $MES[$mesI] . "/" . $anoI . " a " . $MES[$date->format("n")] . "/" . $date->format("Y");

        }



// Descobre que dia é hoje e retorna a unix timestamp

        $hoje = mktime(0, 0, 0, $mesTd, $diaTd, $anoTd);

// Descobre a unix timestamp da data de nascimento do fulano

        $vencimento = mktime(0, 0, 0, $mesV, $diaV, $anoV);

        

        //calcula o atraso com base no vencimento da mensalidade paga e o dia atual

        $atraso = floor((((($hoje - $vencimento) / 60) / 60) / 24));

        $vencimento = $diaV . "/" . $mesV . "/" . $anoV;//transforma date em string



        list($anoP, $mesP, $diaP) = explode('-', $dataPagamento);

        $dataPagamento = $diaP . "/" . $mesP . "/" . $anoP;//transforma date em string

        

        $valor = number_format($valor,2);//formata o número com duas casas decimais

        

        //verifica se há consistência no cálculo do atraso 

        //(caso tenha pago parcelas adiantadas o valor do atraso será negativo o que na real não consiste em atraso)

        if ($atraso < 0) {

            $diaAtraso = 0;

        } else {

            $diaAtraso = $atraso;

        }

        

        //estrutura o mensalidade JSON

        if ($i != 0) {

            $var = $var . ",";

        }

        $var = $var . '{' .

            '"nome" : "' . $nome . '",' .

            '"cpf" : "' . $cpf . '",' .

            '"matricula" : "' . $matricula . '",' .

            '"valor" : "R$' . $valor . '",' .

            '"dataPagamento" : "' . $dataPagamento . '",' .

            '"mesesReferencia" : "' . $mesesReferencia . '",' .

            '"vencimento" : "' . $vencimento . '",' .

            '"atraso" : "' . $diaAtraso . '",' .

            '"idMensalidade" : "' . $idMensalidade . '"' .

            '}';

        $i++;

    }

}else{

    echo "sem resultados";

}

$var = $var . ']';

$fp = fopen('data/mensalidade.json', 'w');

$aux = json_encode($var);

$string = json_decode($aux);

fwrite($fp, $string);

fclose($fp);

?> 



