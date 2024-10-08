<?php
require_once('../connect.php');

session_start();
if (isset($_SESSION['email'])) {
	$mysqli = connect();
	try {
		$consulta = $mysqli->prepare("SELECT aluno.id as id_aluno, aluno.nome as nome_aluno, 
		turma.turma as turma, sepae_libera_aluno.data as data, 
		sepae_libera_aluno.horario_saida as saida, motivo.motivo as motivo, 
		sepae_libera_aluno.sepae_email as servidor  
		FROM sepae_libera_aluno, aluno, turma, motivo 
		where (aluno.id = sepae_libera_aluno.aluno_id) -- and (horario_saida is not null)
		and (turma.id = aluno.turma_id) and (motivo.id = sepae_libera_aluno.motivo_id)
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
	
}
