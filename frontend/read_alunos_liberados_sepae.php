<?php
require_once('connect.php');

if (ISSET($_POST['idAluno'])) {
	$idAluno = $_POST['idAluno'];
} else {
	$idAluno = '7';
}

try {
	$mysqli = connect();
	$consulta = $mysqli->prepare("SELECT aluno.id as id_aluno, aluno.nome as nome_aluno, 
    turma.turma as turma, motivo.motivo as motivo, 
    sepae_libera_aluno.sepae_username as Servidor  
    FROM sepaisdb.sepae_libera_aluno, aluno, turma, motivo 
    where (aluno.id = sepae_libera_aluno.aluno_id) and (data = CURDATE()) 
    and (horario_saida is null)
    and (turma.id = aluno.turma_id) and (motivo.id = sepae_libera_aluno.motivo_id)
	and (aluno.id = ?);");
	$consulta->bind_param("s", $idAluno);
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