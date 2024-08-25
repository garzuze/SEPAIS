<?php
require_once('../connect.php');

if (isset($_GET['turma'])) {
	$turma = $_GET['turma'];
} else {
	$turma = 'adm1';
}

session_start();
if (isset($_SESSION['email'])) {
	$mysqli = connect();
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
            turma.turma = ?
        ORDER BY 
            aluno.nome;");
		$consulta->bind_param("s", $turma);
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
