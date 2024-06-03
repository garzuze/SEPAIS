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
		`id22194774_sepais`.`aluno`.`id` AS `id_aluno`,
        `id22194774_sepais`.`aluno`.`nome` AS `aluno`,
        `id22194774_sepais`.`turma`.`turma` AS `turma`,
        `id22194774_sepais`.`motivo`.`motivo` AS `motivo`,
        `id22194774_sepais`.`sepae_libera_aluno`.`sepae_username` AS `servidor`,
		id22194774_sepais.sepae_libera_aluno.data as data
    FROM
        (((`id22194774_sepais`.`sepae_libera_aluno`
        JOIN `id22194774_sepais`.`aluno`)
        JOIN `id22194774_sepais`.`turma`)
        JOIN `id22194774_sepais`.`motivo`)
    WHERE
        ((`id22194774_sepais`.`aluno`.`id` = `id22194774_sepais`.`sepae_libera_aluno`.`aluno_id`)
            AND (CAST(`id22194774_sepais`.`sepae_libera_aluno`.`data` AS DATE) = CURDATE())
            AND (`id22194774_sepais`.`sepae_libera_aluno`.`horario_saida` IS NULL)
            AND (`id22194774_sepais`.`turma`.`id` = `id22194774_sepais`.`aluno`.`turma_id`)
            AND (`id22194774_sepais`.`motivo`.`id` = `id22194774_sepais`.`sepae_libera_aluno`.`motivo_id`));");
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