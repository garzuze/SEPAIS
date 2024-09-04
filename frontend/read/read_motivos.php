<?php
require_once('../connect.php');

session_start();

function read_motivos() {
	$mysqli = connect();
	try {
		$consulta = $mysqli->prepare("SELECT * from motivo;");
		$consulta->execute();

		$resultado = $consulta->get_result();
		$resultadoFormatado = $resultado->fetch_all(MYSQLI_ASSOC);
	} catch (Exception $e) {
		error_log($e->getMessage());
		print_r($mysqli->error);
		exit('Alguma coisa estranha aconteceu...');
	}
	return $resultadoFormatado;
	$consulta->close();
	$mysqli->close();
}

if (isset($_SESSION['email'])) {
	$motivos = read_motivos();
	echo json_encode($motivos);
} else {
	
}
