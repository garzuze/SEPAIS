<?php
require "../../vendor/autoload.php";
header('Content-type: application/json');
date_default_timezone_set('America/Sao_Paulo');

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
                    "Message" => "Deu boa! O código enviado é válido."
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

function validate_code($user_email, $user_code)
{
    $mysqli = connect();
    $SELECT_CODES_SQL = "SELECT * FROM `email_verification` WHERE email = ?";
    $select_codes_stmt = $mysqli->prepare($SELECT_CODES_SQL);
    $select_codes_stmt->bind_param("s", $user_email);
    $select_codes_stmt->execute();
    $result_flag = $select_codes_stmt->get_result();
    $result = $result_flag->fetch_all(MYSQLI_ASSOC);
    
    if ($result_flag->num_rows > 0) {
        $result = $result[0];
        $valid_code = $result["codigo"] === $user_code;
        $valid_time = strtotime($result['created_at']) >= strtotime('-15 minutes');

        if ($valid_code && $valid_time) { 
            $delete_code_stmt = $mysqli->prepare("DELETE FROM `email_verification` WHERE (`codigo` = ?)");
            $delete_code_stmt->bind_param("s", $user_code);
            $delete_code_stmt->execute();
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
