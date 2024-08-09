<?php
require_once('../connect.php');

function read_dependentes($email_responsavel)
{ {
	$mysqli = connect();
		try {
			$consulta = $mysqli->prepare("SELECT responsavel.email as email_responsavel,
			aluno.id as id_aluno, aluno.nome as nome_aluno, turma.turma as turma
			from responsavel_has_aluno, responsavel, aluno, turma
			where (responsavel.email = responsavel_has_aluno.responsavel_email)
			and (aluno.id = responsavel_has_aluno.aluno_id) and (turma.id = aluno.turma_id)
			and (responsavel.email = ?)");
			$consulta->bind_param("s", $email_responsavel);
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
}
if (!empty($_POST['emailResponsavel'])) {
	$emailResponsavel = $_POST['emailResponsavel'];
} else {
	$emailResponsavel = 'kratos@gmail.com';
}

session_start();
if (!empty($_SESSION['email'])) {
	read_dependentes($emailResponsavel);
} else {
	echo json_encode(0);
}
