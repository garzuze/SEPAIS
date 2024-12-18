<?php
ini_set("display_errors", 1);
require "../../vendor/autoload.php";
require "../insert/insert_responsavel_libera.php";

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
        $data = $_POST;
        if (!empty($jwt)) {
            try {
                $secret = $_SERVER['SECRET'];
                $decoded_data =  (array) JWT::decode($jwt, new Key($secret, 'HS256'));
                $email = $decoded_data["sub"];
                $aluno_id = $_POST["aluno_id"];
                $motivo = $_POST["motivo"];
                $isLiberated = insert_responsavel_libera($email, $aluno_id, $motivo);
                if ($isLiberated) {
                    http_response_code(200);
                    echo json_encode(array(
                        "status" => True,
                        "user_data" => $decoded_data,
                    ));
                } else {
                    http_response_code(500);
                    echo json_encode(array(
                        "status" => False,
                        "message" => "Houve um erro na liberação",
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
