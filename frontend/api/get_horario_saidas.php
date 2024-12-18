<?php
ini_set("display_errors", 1);
date_default_timezone_set('America/Sao_Paulo');
require_once('../connect.php');
require "../../vendor/autoload.php";
require "../read/read_horario_saidas.php";

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
	http_response_code(403);
	echo json_encode(array(
		"status" => false,
		"message" => "A requisição precisa ser HTTPS.",
	));
	exit;
} else {
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$all_headers = getallheaders();
		$jwt = $all_headers['Authorization'];
		if (!empty($jwt)) {
			try {
				$secret = $_SERVER['SECRET'];;
				$decoded_data =  (array) JWT::decode($jwt, new Key($secret, 'HS256'));
				$email_responsavel = $decoded_data["sub"];
				$horaraio_saida = read_horario_saidas($email_responsavel);
				if ($horaraio_saida) {
					http_response_code(200);
					echo json_encode(array(
						"status" => True,
						"message" => $horaraio_saida,
						"user_data" => $decoded_data,
					));
				} else {
					http_response_code(500);
					echo json_encode(array(
						"status" => False,
					));
				}
			} catch (Exception $exception) {
				http_response_code(500);
				echo json_encode(array(
					"status" => False,
					"message" => $exception->getMessage(),
				));
			}
		} else {
			echo "JWT não encontrado";
		}
	} else {
		http_response_code(404);
		$server_response_error = array(
			"code" => http_response_code(404),
			"status" => false,
			"message" => "Bad Request"
		);
		echo json_encode($server_response_error);
	}
}
