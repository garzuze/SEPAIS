<?php 
require_once('connect.php');

if (ISSET($_GET['turma'])) {
	$turma = $_GET['turma'];
} else {
	$turma = 'adm1';
}

try {
	$mysqli = connect();
	$consulta = $mysqli->prepare("SELECT aluno.id as 'id_aluno', aluno.nome as 'nome_aluno', responsavel.nome as 'nome_responsavel', responsavel.email as 'email_responsavel', turma.turma as 'turma'
    from responsavel_has_aluno, responsavel, aluno, turma
    where (responsavel.email = responsavel_has_aluno.responsavel_email)
    and (aluno.id = responsavel_has_aluno.aluno_id) and (turma.id = aluno.turma_id) and (turma.turma = ?)
	order by aluno.nome;");
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
?>