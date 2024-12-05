<?php
require "../../vendor/autoload.php";
header('Content-type: application/json');
date_default_timezone_set('America/Sao_Paulo');
include("../functions.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST["code"]) && !empty($_POST["email"])) {
        require_once("../connect.php");
        $mysqli = connect();
        $user_email = $_POST["email"];
        $user_code = $_POST["code"];
        try {
            if (validate_code($user_email, $user_code)) {
                http_response_code(200);
                $server_response_success = array(
                    "code" => http_response_code(200),
                    "status" => true,
                    "message" => "Deu boa! O código enviado é válido."
                );
                echo json_encode($server_response_success);
            } else {
                http_response_code(404);
                $server_response_error = array(
                    "code" => http_response_code(404),
                    "status" => false,
                    "message" => "Opa! Código inválido!",
                );
                echo json_encode($server_response_error);
            }
        } catch (Exception $exception) {
            http_response_code(404);
            $server_response_error = array(
                "code" => http_response_code(404),
                "status" => false,
                "message" => "Vish! Alguma coisa deu errado: " . $exception->getMessage(),
            );
            echo json_encode($server_response_error);
        }
    } else {
        http_response_code(404);
        $server_response_error = array(
            "code" => http_response_code(404),
            "status" => false,
            "message" => "Parâmetros inválidos.",
        );
        echo json_encode($server_response_error);
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