<?php
include 'conexao.php'; //incluir arquivo com conexão ao banco de dados
include 'menu.php';

if (($_SESSION['tipo'] == '1') || ($_SESSION['tipo'] == '3') || ($_SESSION['tipo'] == '4')) {

	$sql = "SELECT fk_idUsuario FROM associado WHERE idAssociado = '".$_GET["associado"]."'";

	$result = $con->query($sql);

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            $idUsuario = $row['fk_idUsuario'];

        }

    }else{ //se o comando não funcionou
		echo "<script>alert('Erro ao excluir o associado! Por favor, assegure-se de que o associado não possui dependentes cadastrados.');</script>";
		echo "<script>window.location = 'consultarSocio.php';</script>";
		echo "Erro: ". $sql. "<br>" . $con->error;
	}

    $sql = "SELECT * FROM telefone WHERE fk_idUsuario = '".$idUsuario."'";

	$result = $con->query($sql);

    if ($result->num_rows > 0) {

        $sql = "DELETE FROM telefone WHERE fk_idUsuario = '".$idUsuario."'";

		if ($con->query($sql) === TRUE) { //se o comando funcionou

		}
		else{ //se o comando não funcionou
			echo "<script>alert('Erro ao excluir o associado! Por favor, assegure-se de que o associado não possui dependentes cadastrados.');</script>";
			echo "<script>window.location = 'consultarSocio.php';</script>";
			echo "Erro: ". $sql. "<br>" . $con->error;
		}

    }

    $sql = "SELECT * FROM imgUsuario WHERE fk_idUsuario = '".$idUsuario."'";

	$result = $con->query($sql);

    if ($result->num_rows > 0) {

        $sql = "DELETE FROM imgUsuario WHERE fk_idUsuario = '".$idUsuario."'";

		if ($con->query($sql) === TRUE) { //se o comando funcionou

		}
		else{ //se o comando não funcionou
			echo "<script>alert('Erro ao excluir o associado! Por favor, assegure-se de que o associado não possui dependentes cadastrados.');</script>";
			echo "<script>window.location = 'consultarSocio.php';</script>";
			echo "Erro: ". $sql. "<br>" . $con->error;
		}

    }

    $sql = "SELECT * FROM imgDoc WHERE fk_idUsuario = '".$idUsuario."'";

	$result = $con->query($sql);

    if ($result->num_rows > 0) {

        $sql = "DELETE FROM imgDoc WHERE fk_idUsuario = '".$idUsuario."'";

		if ($con->query($sql) === TRUE) { //se o comando funcionou

		}
		else{ //se o comando não funcionou
			echo "<script>alert('Erro ao excluir o associado! Por favor, assegure-se de que o associado não possui dependentes cadastrados.');</script>";
			echo "<script>window.location = 'consultarSocio.php';</script>";
			echo "Erro: ". $sql. "<br>" . $con->error;
		}

    }

	$sql = "DELETE FROM associado WHERE idAssociado = '".$_GET["associado"]."'";

	if ($con->query($sql) === TRUE) { //se o comando funcionou

	}
	else{ //se o comando não funcionou
		echo "<script>alert('Erro ao excluir o associado! Por favor, assegure-se de que o associado não possui dependentes cadastrados.');</script>";
		echo "<script>window.location = 'consultarSocio.php';</script>";
		echo "Erro: ". $sql. "<br>" . $con->error;
	}

	$sql = "DELETE FROM usuario WHERE idUsuario = '".$idUsuario."'";

	if ($con->query($sql) === TRUE) { //se o comando funcionou
		echo "<script>alert('O associado foi excluído com sucesso.');</script>";
		echo "<script>window.location = 'consultarSocio.php';</script>";
	}
	else{ //se o comando não funcionou
		echo "<script>alert('Erro ao excluir o associado! Por favor, assegure-se de que o associado não possui dependentes cadastrados.');</script>";
		echo "<script>window.location = 'consultarSocio.php';</script>";
		echo "Erro: ". $sql. "<br>" . $con->error;
	}

}else{
	echo "<script>window.location = 'index.php';</script>";
}
?>