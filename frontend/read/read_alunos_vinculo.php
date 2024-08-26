<?php
require_once('../connect.php');

session_start();
if (isset($_SESSION['email'])) {
	$mysqli = connect();
	
	$turma = isset($_GET['turma']) ? $_GET['turma'] : 'adm1';
	$query = isset($_GET['query']) ? $_GET['query'] : '';

	try {
		$consulta = $mysqli->prepare("SELECT 
            aluno.id AS id_aluno,
            aluno.nome AS nome_aluno,
            turma.turma AS turma
        FROM 
            aluno
        JOIN 
            turma ON aluno.turma_id = turma.id
        WHERE 
            turma.turma = ? AND aluno.nome LIKE ?
        ORDER BY 
            aluno.nome
		LIMIT 5;");
		$likeQuery = '%' . $query . '%';
		$consulta->bind_param("ss", $turma, $likeQuery);
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