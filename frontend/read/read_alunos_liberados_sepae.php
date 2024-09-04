<?php
require_once('../connect.php');

if (isset($_POST['idAluno'])) {
	$idAluno = $_POST['idAluno'];
} else {
	$idAluno = '7';
}

session_start();
if (isset($_SESSION['email'])) {
	$mysqli = connect();
	try {
		$consulta = $mysqli->prepare("SELECT 
		aluno.id AS id_aluno,
        aluno.nome AS aluno,
        turma.turma AS turma,
        motivo.motivo AS motivo,
        sepae_libera_aluno.sepae_email AS servidor,
		sepae_libera_aluno.data as data
    FROM
        (((sepae_libera_aluno
        JOIN aluno)
        JOIN turma)
        JOIN motivo)
    WHERE
        ((aluno.id = sepae_libera_aluno.aluno_id)
            AND (CAST(sepae_libera_aluno.data AS DATE) = CURDATE())
            AND (sepae_libera_aluno.horario_saida IS NULL)
            AND (turma.id = aluno.turma_id)
            AND (motivo.id = sepae_libera_aluno.motivo_id));");
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
