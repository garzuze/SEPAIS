<?php
require_once('../connect.php');

if (ISSET($_POST['idAluno'])) {
	$idAluno = $_POST['idAluno'];
} else {
	$idAluno = '7';
}

date_default_timezone_set('America/Sao_Paulo');
session_start();
if(isset($_SESSION['email'])) {
	try {
	    $date = date('Y-m-d');
		$mysqli = connect();
		$consulta = $mysqli->prepare("SELECT 
        `aluno`.`id` AS `id_aluno`,
        `aluno`.`nome` AS `aluno`,
        `turma`.`turma` AS `turma`,
        `motivo`.`motivo` AS `motivo`,
        `sepae_libera_aluno`.`sepae_username` AS `liberador`,
        `sepae_libera_aluno`.`data` AS `data`
    FROM
        (((`sepae_libera_aluno`
        JOIN `aluno`)
        JOIN `turma`)
        JOIN `motivo`)
    WHERE
        ((`aluno`.`id` = `sepae_libera_aluno`.`aluno_id`)
            AND (CAST(`sepae_libera_aluno`.`data` AS DATE) = ?)
            AND (`sepae_libera_aluno`.`horario_saida` IS NULL)
            AND (`turma`.`id` = `aluno`.`turma_id`)
            AND (`motivo`.`id` = `sepae_libera_aluno`.`motivo_id`)) 
    UNION SELECT 
        `aluno`.`id` AS `id_aluno`,
        `aluno`.`nome` AS `aluno`,
        `turma`.`turma` AS `turma`,
        `motivo`.`motivo` AS `motivo`,
        `responsavel`.`nome` AS `liberador`,
        `responsavel_libera_aluno`.`data` AS `data`
    FROM
        ((((`responsavel_libera_aluno`
        JOIN `responsavel`)
        JOIN `aluno`)
        JOIN `motivo`)
        JOIN `turma`)
    WHERE
        ((`aluno`.`id` = `responsavel_libera_aluno`.`aluno_id`)
            AND (`motivo`.`id` = `responsavel_libera_aluno`.`motivo_id`)
            AND (`responsavel`.`email` = `responsavel_libera_aluno`.`responsavel_email`)
            AND (CAST(`responsavel_libera_aluno`.`data` AS DATE) = ?)
            AND (`responsavel_libera_aluno`.`horario_saida` IS NULL)
            AND (`turma`.`id` = `aluno`.`turma_id`))
    ORDER BY `data` DESC");
		// and (aluno.id = ?);
		$consulta->bind_param("ss", $date, $date);
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