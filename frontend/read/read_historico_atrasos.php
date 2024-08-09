<?php
require_once('../connect.php');

session_start();
if (isset($_SESSION['email'])) {
	$mysqli = connect();
	try {
		$consulta = $mysqli->prepare("SELECT aluno.id as id_aluno, aluno.nome as nome_aluno, 
		turma.turma as turma, aluno_atrasado.data as data,  
		aluno_atrasado.portaria_email as servidor  
		FROM aluno_atrasado, aluno, turma
		where (aluno.id = aluno_atrasado.aluno_id)
		and (turma.id = aluno.turma_id)
		order by data desc;");
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
