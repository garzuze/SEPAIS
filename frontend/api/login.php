<?php
header('Content-type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        try {
            $SELECT_USER_SQL = "SELECT * FROM `usuario` WHERE email = ?";
            $mysqli = connect();
            $select_user_stmt = $mysqli->prepare($SELECT_USER_SQL);
            $select_user_stmt->bind_param("s", $email);
            $select_user_stmt->execute();
            $user_flag = $select_user_stmt->num_rows();
            if ($user_flag > 0) {
                $user_data = $select_user_stmt->get_result();
                $user_data = $user_data->fetch_all(MYSQLI_ASSOC);
                if (password_verify($password, $user_data[0]['senha'])) {
                    $user_object = array(
                        "email" => $user_data[0]["email"],
                        "name" => $user_data[0]["nome"],
                        "password" => $user_data[0]["senha"],
                    );
                    http_response_code(200);
                    $server_response_success = array(
                        "code" => http_response_code(200),
                        "status" => true,
                        "message" => "Usuário validado!",
                        "user_data" => $user_object,
                    );
                    echo json_encode($server_response_success);
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
