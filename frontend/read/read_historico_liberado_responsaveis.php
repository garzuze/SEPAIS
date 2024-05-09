<?php
require_once('../connect.php');

session_start();
if(isset($_SESSION['email'])) {
	try {
		$mysqli = connect();
		$consulta = $mysqli->prepare("SELECT aluno.id as id_aluno, aluno.nome as nome_aluno, 
		turma.turma as turma, responsavel_libera_aluno.data as data, 
		responsavel_libera_aluno.horario_saida as saida, motivo.motivo as motivo, 
		responsavel.nome as responsavel  
		FROM sepaisdb.responsavel_libera_aluno, aluno, turma, motivo, responsavel
		where (aluno.id = responsavel_libera_aluno.aluno_id) 
        and (responsavel.email = responsavel_libera_aluno.responsavel_email)
		and (turma.id = aluno.turma_id) and (motivo.id = responsavel_libera_aluno.motivo_id)
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
} else{
	echo json_encode(0);
}
?>