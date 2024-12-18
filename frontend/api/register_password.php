<?php
require "../../vendor/autoload.php";
$functions_path = dirname(__DIR__) . "/functions.php";
include($functions_path);

date_default_timezone_set('America/Sao_Paulo');

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    http_response_code(403);
    echo json_encode(array(
        "status" => false,
        "message" => "A requisição precisa ser HTTPS.",
    ));
    exit;
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["code"])) {
            require_once("../connect.php");
            $mysqli = connect();
            $user_email = $_POST["email"];
            $user_password = $_POST["password"];
            $user_code = $_POST["code"];
            if (validate_code($user_email, $user_code)) {
                $hashed_pwd = password_hash($user_password, PASSWORD_DEFAULT);
                $UPDATE_USER_SQL = "UPDATE `usuario` SET `senha` = ? WHERE `email` = ?";
                $update_user_stmt = $mysqli->prepare($UPDATE_USER_SQL);
                $update_user_stmt->bind_param("ss",  $hashed_pwd, $user_email);
                if ($update_user_stmt->execute()) {
                    delete_validation_code($user_code);
                    http_response_code(200);
                    $server_response_success = array(
                        "code" => http_response_code(200),
                        "status" => true,
                        "message" => "Senha criada!"
                    );
                    echo json_encode($server_response_success);
                } else {
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
}
