<?php
require_once('../connect.php');

try {
	$mysqli = connect();
	$consulta = $mysqli->prepare("SELECT titulo, recado, data, sepae_username from recado 
    where (CURDATE() < validade) or (validade is null);");
	$consulta->execute();

	$resultado = $consulta->get_result();
	$resultadoFormatado = $resultado->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
	error_log($e->getMessage());
	print_r($mysqli->error);
	exit('Alguma coisa estranha aconteceu...');
}

echo json_encode($resultadoFormatado);

$consulta->close();
$mysqli->close();
?>
