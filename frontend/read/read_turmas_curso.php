<?php
require_once('../connect.php');

function read_turmas_curso($curso)
{ {
	$mysqli = connect();
		try {
			$consulta = $mysqli->prepare("SELECT `turma`.`id` 
            AS `id`, `turma`.`turma` AS `turma`
            FROM
                `turma`
            WHERE
                (`turma`.`turma` LIKE ?)
            ORDER BY `turma`.`turma` DESC");
			$consulta->bind_param("s", $curso);
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
if (!empty($_POST['curso'])) {
	$curso = $_POST['curso']."%";
} else {
	$curso = 'ADM'.'%';
}

session_start();
if (!empty($_SESSION['email'])) {
	$turmas_curso = read_turmas_curso($curso);
    echo json_encode($turmas_curso,  JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
