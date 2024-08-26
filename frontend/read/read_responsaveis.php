<?php
require_once('../connect.php');

session_start();
if (isset($_SESSION['email'])) {
	$mysqli = connect();
	try {
		$consulta = $mysqli->prepare("SELECT 
        `responsavel`.`email` AS `email`,
        `usuario`.`nome` AS `nome`,
        `responsavel`.`telefone` AS `telefone`
    FROM
        (`usuario`
        JOIN `responsavel`)
    WHERE
        (`usuario`.`email` = `responsavel`.`email`)
    ORDER BY `responsavel`.`email`");
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
} else {
	echo json_encode(0);
}
