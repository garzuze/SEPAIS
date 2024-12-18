<?php
header("Content-type: application/json");

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    http_response_code(403);
    echo json_encode(array(
        "status" => false,
        "message" => "A requisição precisa ser HTTPS.",
    ));
    exit;
} else {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!empty($_POST["email"]) && !empty($_POST["name"]) && !empty($_POST["password"])) {
            require_once("../connect.php");
            $mysqli = connect();
            $email = $_POST["email"];
            $name = $_POST["name"];
            $password = $_POST["password"];
            $photo_path = "static/default_user_icon.jpg";
            try {
                // Verificar se não é um usuário duplicado
                $SELECT_USER_SQL = "SELECT * FROM usuario WHERE email = ?";
                $duplicate_user_stmt = $mysqli->prepare($SELECT_USER_SQL);
                $duplicate_user_stmt->bind_param("s", $email);
                $duplicate_user_stmt->execute();
                $duplicate_user_flag = $duplicate_user_stmt->get_result();
                if ($duplicate_user_flag->num_rows > 0) {
                    http_response_code(404);
                    $server_response_error = array(
                        "code" => http_response_code(404),
                        "status" => false,
                        "message" => "Usuário já registrado.",
                    );
                    echo json_encode($server_response_error);
                } else {
                    // Inserir usuário
                    // Encriptar senha
                    $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);
                    $INSERT_USER_SQL = "INSERT INTO `usuario` (`email`, `nome`, `senha`, `foto_path`) VALUES (?, ?, ?, ?)";
                    $insert_user_stmt = $mysqli->prepare($INSERT_USER_SQL);
                    $insert_user_stmt->bind_param("ssss", $email, $name, $hashed_pwd, $photo_path);
                    if ($insert_user_stmt->execute()) {
                        $server_response_success = array(
                            "code" => http_response_code(200),
                            "status" => true,
                            "message" => "Usuário criado com sucesso."
                        );
                        echo json_encode($server_response_success);
                    } else {
                        http_response_code(404);
                        $server_response_error = array(
                            "code" => http_response_code(404),
                            "status" => false,
                            "message" => "Erro ao criar usuário. Tente novamente.",
                        );
                        echo json_encode($server_response_error);
                    }
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
                "data" => $_POST,
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
