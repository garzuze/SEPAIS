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
		`sepaisdb`.`aluno`.`id` AS `id_aluno`,
        `sepaisdb`.`aluno`.`nome` AS `aluno`,
        `sepaisdb`.`turma`.`turma` AS `turma`,
        `sepaisdb`.`motivo`.`motivo` AS `motivo`,
        `sepaisdb`.`responsavel`.`nome` AS responsavel,
		sepaisdb.responsavel_libera_aluno.data as data
    FROM
        ((((sepaisdb.responsavel_libera_aluno
        JOIN sepaisdb.responsavel)
        JOIN sepaisdb.aluno)
        JOIN sepaisdb.motivo)
        JOIN sepaisdb.turma)
    WHERE
        ((sepaisdb.aluno.id = sepaisdb.responsavel_libera_aluno.aluno_id)
            AND (sepaisdb.motivo.id = sepaisdb.responsavel_libera_aluno.motivo_id)
            AND (sepaisdb.responsavel.email = sepaisdb.responsavel_libera_aluno.responsavel_email)
            AND (CAST(sepaisdb.responsavel_libera_aluno.data AS DATE) = CURDATE())
            AND (sepaisdb.responsavel_libera_aluno.horario_saida IS NULL)
            AND (sepaisdb.turma.id = sepaisdb.aluno.turma_id));");
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