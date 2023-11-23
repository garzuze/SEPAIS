<?php
require_once('connect.php');

if (ISSET($_POST['emailResponsavel'])) {
	$emailResponsavel = $_POST['emailResponsavel'];
} else {
	$emailResponsavel = 'kratos@gmail.com';
}

try {
	$mysqli = connect();
	$consulta = $mysqli->prepare("SELECT responsavel.nome as nome_responsavel, responsavel.email as email_responsavel,
    aluno.id as id_aluno, aluno.nome as nome_aluno, turma.turma as turma
    from responsavel_has_aluno, responsavel, aluno, turma
    where (responsavel.email = responsavel_has_aluno.responsavel_email)
    and (aluno.id = responsavel_has_aluno.aluno_id) and (turma.id = aluno.turma_id)
    and (responsavel.email = ?);");
    $consulta->bind_param("s", $emailResponsavel);
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