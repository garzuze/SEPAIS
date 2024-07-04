<?php
require_once('../connect.php');

if (ISSET($_POST['idAluno'])) {
	$idAluno = $_POST['idAluno'];
} else {
	$idAluno = '7';
}

session_start();
if(isset($_SESSION['email'])) {
	try {
		$mysqli = connect();
		$consulta = $mysqli->prepare("SELECT 
		`aluno`.`id` AS `id_aluno`,
        `aluno`.`nome` AS `aluno`,
        `turma`.`turma` AS `turma`,
        `motivo`.`motivo` AS `motivo`,
        `responsavel`.`nome` AS responsavel,
		responsavel_libera_aluno.data as data
    FROM
        ((((responsavel_libera_aluno
        JOIN responsavel)
        JOIN aluno)
        JOIN motivo)
        JOIN turma)
    WHERE
        ((aluno.id = responsavel_libera_aluno.aluno_id)
            AND (motivo.id = responsavel_libera_aluno.motivo_id)
            AND (responsavel.email = responsavel_libera_aluno.responsavel_email)
            AND (CAST(responsavel_libera_aluno.data AS DATE) = CURDATE())
            AND (responsavel_libera_aluno.horario_saida IS NULL)
            AND (turma.id = aluno.turma_id));");
		// and (aluno.id = ?);
		// $consulta->bind_param("s", $idAluno);
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