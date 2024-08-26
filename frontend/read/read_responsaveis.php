<?php
require_once('../connect.php');

session_start();
if (isset($_SESSION['email'])) {
	if (isset($_GET['query'])) {
		$query = $_GET['query'];
	
		// Connect to the database
		$mysqli = connect();
		
		try {
			// Prepare the SQL statement with a WHERE clause to filter emails
			$consulta = $mysqli->prepare("
				SELECT `responsavel`.`email` AS `email`
				FROM `usuario`
				JOIN `responsavel` ON `usuario`.`email` = `responsavel`.`email`
				WHERE `responsavel`.`email` LIKE ?
				ORDER BY `responsavel`.`email`
				LIMIT 5
			");
	
			// Use parameterized queries to prevent SQL injection
			$searchQuery = "%$query%";
			$consulta->bind_param('s', $searchQuery);
			$consulta->execute();
	
			$resultado = $consulta->get_result();
			$emails = [];
	
			while ($row = $resultado->fetch_assoc()) {
				$emails[] = $row['email'];
			}
	
			echo json_encode($emails);
			
		} catch (Exception $e) {
			error_log($e->getMessage());
			print_r($mysqli->error);
			exit('Alguma coisa estranha aconteceu...');
		}
	
		$consulta->close();
		$mysqli->close();
	}
} else {
	echo json_encode(0);
}
