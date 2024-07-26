<?php
require_once('../connect.php');

function read_recados()
{
	try {
		$mysqli = connect();
		$consulta = $mysqli->prepare("SELECT id, titulo, recado, data, validade, sepae_email from recado 
		where (CURDATE() < validade) or (validade is null) ORDER BY id DESC;");
		$consulta->execute();

		$resultado = $consulta->get_result();
		$resultadoFormatado = $resultado->fetch_all(MYSQLI_ASSOC);

		$consulta->close();
		$mysqli->close();
		return $resultadoFormatado;
	} catch (Exception $e) {
		error_log($e->getMessage());
		print_r($mysqli->error);
		exit('Alguma coisa estranha aconteceu...');
	}
}

session_start();
if (isset($_SESSION['email'])) {

	$recados = read_recados();

	echo json_encode($recados,  JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} else {
	echo json_encode(0);
}
