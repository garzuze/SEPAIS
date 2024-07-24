<?php
header('Content-type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        require_once("../connect.php");
        $mysqli = connect();
        $email = $_POST["email"];
        $password = $_POST["password"];
        try {
            $SELECT_USER_SQL = "SELECT * FROM `usuario` WHERE email = ?";
            $select_user_stmt = $mysqli->prepare($SELECT_USER_SQL);
            $select_user_stmt->bind_param("s", $email);
            $select_user_stmt->execute();
            $user_flag = $select_user_stmt->get_result();
            if ($user_flag->num_rows > 0) {
                $user_data = $user_flag->fetch_all(MYSQLI_ASSOC);
                if (password_verify($password, $user_data[0]['senha'])) {
                    require("jwt_utils.php");
                    $user_object = array(
                        "email" => $user_data[0]["email"],
                        "name" => $user_data[0]["nome"],
                        "password" => $user_data[0]["senha"],
                    );
                    $headers = array('alg' => 'HS256', 'typ' => 'JWT');
                    $payload = array('sub' => $user_data[0]["email"], 'name' => $user_data[0]["nome"], 'iat' => time(), 'exp' => (time() + 60), 'data' => $user_object);
                    
                    $jwt = generate_jwt($headers, $payload);
                    echo $jwt;
                } else {
                    http_response_code(404);
                    $server_response_error = array(
                        "code" => http_response_code(404),
                        "status" => false,
                        "message" => "Opa! Credenciais de login erradas!",
                    );
                    echo json_encode($server_response_error);
                }
            } else {
                http_response_code(404);
                $server_response_error = array(
                    "code" => http_response_code(404),
                    "status" => false,
                    "message" => "Opa! Credenciais de login erradas!",
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
