  
<?php
	//session_start();
	//Parâmetros de conexão
	$servername = "localhost";
	$username = "";
	$password = "";
	$dbname = "site_academico_ifmg";
	// Cria a conexão
    $con = new mysqli($servername, $dbname);
	// Check a conexão
	if ($con->connect_error) {
		die("Falha na conexão: " . $con->connect_error);
	}
?>