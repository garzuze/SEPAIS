<?php
require_once('../connect.php');

if (isset($_GET['turma'])) {
	$turma = $_GET['turma'];
} else {
	$turma = 'adm1';
}

session_start();
if (isset($_SESSION['email'])) {
	$mysqli = connect();
	try {
		$consulta = $mysqli->prepare("SELECT 
        `aluno`.`id` AS `id_aluno`,
        `aluno`.`nome` AS `nome_aluno`,
        GROUP_CONCAT(`usuario`.`nome`
            SEPARATOR ', ') AS `nome_responsavel`,
        GROUP_CONCAT(`responsavel`.`email`
            SEPARATOR ', ') AS `email_responsavel`,
        `turma`.`turma` AS `turma`
    FROM
        (`usuario`
        JOIN (((`aluno`
        JOIN `responsavel_has_aluno` ON ((`aluno`.`id` = `responsavel_has_aluno`.`aluno_id`)))
        JOIN `responsavel` ON ((`responsavel_has_aluno`.`responsavel_email` = `responsavel`.`email`)))
        JOIN `turma` ON ((`aluno`.`turma_id` = `turma`.`id`))))
    WHERE
        ((`turma`.`turma` = ?)
            AND (`responsavel`.`email` = `usuario`.`email`))
    GROUP BY `aluno`.`id` , `aluno`.`nome` , `turma`.`turma`
    ORDER BY `aluno`.`nome`");
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
} else {
	
}
