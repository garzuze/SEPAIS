<?php
date_default_timezone_set('America/Sao_Paulo');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

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

function delete_validation_code($user_code)
{
    $mysqli = connect();
    $delete_code_stmt = $mysqli->prepare("DELETE FROM `email_verification` WHERE (`codigo` = ?)");
    $delete_code_stmt->bind_param("s", $user_code);
    $delete_code_stmt->execute();
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
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
