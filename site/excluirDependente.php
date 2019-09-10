<?php
include 'conexao.php'; //incluir arquivo com conexão ao banco de dados
include 'include/headerAdm.php';

if (($_SESSION['tipo'] == '1') || ($_SESSION['tipo'] == '4')) {

	$matricula = $_GET["matricula"];

	$sql = "SELECT fk_idUsuario FROM dependente WHERE idDependente = '".$_GET["dependente"]."'";

	$result = $con->query($sql);

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            $idUsuario = $row['fk_idUsuario'];

        }

    }else{ //se o comando não funcionou
		echo "<script>alert('Erro ao excluir o dependente!');</script>";
		echo "<script>window.location = 'exibirSocio.php?matricula=" . $matricula . "';</script>";
		echo "Erro: ". $sql. "<br>" . $con->error;
	}

    $sql = "SELECT * FROM telefone WHERE fk_idUsuario = '".$idUsuario."'";

	$result = $con->query($sql);

    if ($result->num_rows > 0) {

        $sqlTel = "DELETE FROM telefone WHERE fk_idUsuario = '".$idUsuario."'";

		if ($con->query($sqlTel) === TRUE) { //se o comando funcionou

			$sqlDep = "DELETE FROM dependente WHERE idDependente = '".$_GET["dependente"]."'";

			if ($con->query($sqlDep) === TRUE) { //se o comando funcionou

				$sqlUsuario = "DELETE FROM usuario WHERE idUsuario = '".$idUsuario."'";

				if ($con->query($sqlUsuario) === TRUE) { //se o comando funcionou

					echo "<script>alert('O dependente foi excluído com sucesso.');</script>";
					echo "<script>window.location = 'exibirSocio.php?matricula=" . $matricula . "';</script>";

				}else{ //se o comando não funcionou
					echo "<script>alert('Erro ao excluir o dependente.');</script>";
					echo "<script>window.location = 'exibirSocio.php?matricula=" . $matricula . "';</script>";
					//echo "Erro: ". $sqlUsuario. "<br>" . $con->error;
				}
			}else{ //se o comando não funcionou
				echo "<script>alert('Erro ao excluir o dependente.');</script>";
				echo "<script>window.location = 'exibirSocio.php?matricula=" . $matricula . "';</script>";
				//echo "Erro: ". $sqlDep. "<br>" . $con->error;
			}
		}
		else{ //se o comando não funcionou
			echo "<script>alert('Erro ao excluir o dependente.');</script>";
			echo "<script>window.location = 'exibirSocio.php?matricula=" . $matricula . "';</script>";
			echo "Erro: ". $sqlTel. "<br>" . $con->error;
		}

    }
	
}else{
	echo "<script>window.location = 'index.php';</script>";
}


?>