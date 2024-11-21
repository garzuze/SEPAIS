<?php
ini_set("display_errors", 1);
require_once('../connect.php');
require "../../vendor/autoload.php";
require "../read/read_recados.php";

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;



if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$all_headers = getallheaders();
	$jwt = $all_headers['Authorization'];
	if (!empty($jwt)) {
		try {
			$recados = read_recados();
			$secret = $_SERVER['SECRET'];;
			$decoded_data = JWT::decode($jwt, new Key($secret, 'HS256'));
			http_response_code(200);
			echo json_encode(array(
				"status" => True,
				"message" => $recados,
				"user_data" => $decoded_data,
			));
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
