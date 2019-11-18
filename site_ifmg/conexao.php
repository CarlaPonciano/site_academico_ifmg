  
<?php
	//session_start();
	//Parâmetros de conexão
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "site_academico_ifmg";
	// Cria a conexão
    $conn = new mysqli($servername,$username,$password, $dbname);
	// Check a conexão
	if ($conn->connect_error) {
		die("Falha na conexão: " . $conn->connect_error);
    }
?>