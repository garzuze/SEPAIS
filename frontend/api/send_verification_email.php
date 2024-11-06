<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../../vendor/autoload.php";
header('Content-type: application/json');
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST["email"])) {
        require_once("../connect.php");
        $mysqli = connect();
        $user_email = $_POST["email"];
        try {
            $SELECT_USER_SQL = "SELECT * FROM `usuario` WHERE email = ?";
            $select_user_stmt = $mysqli->prepare($SELECT_USER_SQL);
            $select_user_stmt->bind_param("s", $user_email);
            $select_user_stmt->execute();
            $user_flag = $select_user_stmt->get_result();

            if ($user_flag->num_rows > 0) {
                $verification_code = random_int(1000, 9999);
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

function insert_verification_code($user_email, $validation_code)
{
    require_once("../connect.php");
    $mysqli = connect();

    $INSERT_VERIFICATION_SQL = "INSERT INTO `email_verification`(`email`,`codigo`) VALUES (?, ?)";
    $insert_verification_stmt = $mysqli->prepare($INSERT_VERIFICATION_SQL);
    $insert_verification_stmt->bind_param("ss", $user_email, $validation_code);
    $insert_verification_stmt->execute();
}

function send_verification_email($user_email, $validation_code)
{
    $email_password = $_SERVER['APP_PASSWORD'];
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sepais.edu@gmail.com';
        $mail->Password = $email_password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('sepais.edu@gmail.com', 'SEPAIS');
        $mail->addAddress($user_email);

        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
        $mail->Encoding = 'base64';
        $mail->Subject = 'Código de Verificação';
        $mail->Body = "Seu código de verificação é: <b>$validation_code</b>";
        $mail->AltBody = "Seu código de verificação é: $validation_code";
        if (!$mail->send()) {
            echo 'Deu ruim: ' . $mail->ErrorInfo;
            return false;
        } else {
            insert_verification_code($user_email, $validation_code);
            return true;
        }
        $mail->smtpClose();
    } catch (Exception $e) {
        echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
        return false;
    }
}
