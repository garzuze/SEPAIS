<?php
$functions_path = dirname(__DIR__) . "/functions.php";
include($functions_path);
header('Content-type: application/json');

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    http_response_code(403);
    echo json_encode(array(
        "status" => false,
        "message" => "A requisição precisa ser HTTPS.",
    ));
    exit;
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST["email"])) {
            require_once("../connect.php");
            $mysqli = connect();
            $user_email = $_POST["email"];
            try {
                clean_expired_codes();
                $SELECT_USER_SQL = "SELECT * FROM `usuario` WHERE email = ?";
                $select_user_stmt = $mysqli->prepare($SELECT_USER_SQL);
                $select_user_stmt->bind_param("s", $user_email);
                $select_user_stmt->execute();
                $user_flag = $select_user_stmt->get_result();

                if ($user_flag->num_rows > 0) {
                    $verification_code = random_int(100000, 999999);
                    if (send_verification_email($user_email, $verification_code)) {
                        http_response_code(200);
                        $server_response_success = array(
                            "code" => http_response_code(200),
                            "status" => true,
                        );
                        echo json_encode($server_response_success);
                    } else {
                        http_response_code(404);
                        $server_response_error = array(
                            "code" => http_response_code(404),
                            "status" => false,
                            "message" => "Opa! Deu ruim ao enviar o email!",
                        );
                        echo json_encode($server_response_error);
                    }
                } else {
                    http_response_code(404);
                    $server_response_error = array(
                        "code" => http_response_code(404),
                        "status" => false,
                        "message" => "Opa! Responsável não registrado.",
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
}
