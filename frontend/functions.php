<?php
date_default_timezone_set('America/Sao_Paulo');
require_once("connect.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;

require dirname(__DIR__) . "/vendor/autoload.php";

function insert_verification_code($user_email, $validation_code)
{
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

function get_google_access_token()
{
    $credential_file = dirname(__DIR__) . "/sepais-2024-firebase-adminsdk-hxhsv-cfe10c070f.json";

    $credential = new ServiceAccountCredentials(
        "https://www.googleapis.com/auth/firebase.messaging",
        json_decode(file_get_contents($credential_file), true)
    );
    $token = $credential->fetchAuthToken(HttpHandlerFactory::build());
    $access_token = $token['access_token'];
    return $access_token;
}


function get_all_responsable_tokens()
{
    $mysqli = connect();
    $query = $mysqli->prepare("SELECT token from responsavel;");
    $query->execute();

    $results = $query->get_result();
    $results = $results->fetch_all(MYSQLI_ASSOC);
    
    for ($i = 0; $i < count($results); $i++) {
        $results[$i] = $results[$i]["token"];
    }

    return $results;
}

function get_student_info($student_id)
{
    $mysqli = connect();
    $query = $mysqli->prepare("SELECT responsavel.email as email_responsavel, responsavel.token as token_responsavel,
			aluno.id as id_aluno, aluno.nome as nome_aluno, turma.turma as turma
			from responsavel_has_aluno, responsavel, aluno, turma
			where (responsavel.email = responsavel_has_aluno.responsavel_email)
			and (aluno.id = responsavel_has_aluno.aluno_id) and (turma.id = aluno.turma_id)
			and (aluno.id = ?)");
    $query->bind_param("i", $student_id);
    $query->execute();

    $result = $query->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function send_notification($token, $type, $student_name = "", $message = "", $skip_time = "")
{
    $server_key = get_google_access_token();

    $notifications = [
        "liberation" => [
            'title' => 'Olá! O aluno ' . $student_name . ' está liberado para sair.',
            'body' => 'Clique aqui para autorizar sua saída antecipada.',
        ],
        "message" => [
            'title' => 'Olá! Você tem um novo recado',
            'body' => $message,
        ],
        "skip" => [
            'title' => 'Opa! O estudente ' . $student_name . ' acabou de sair.',
            'body' => 'Horário de saída: ' . $skip_time,
        ],
    ];

    $message = [
        'message' => [
            'notification' => [
                'title' => $notifications[$type]['title'],
                'body' => $notifications[$type]['body'],
            ],
            'token' => $token,
        ],
    ];

    $data = json_encode($message);
    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer " . $server_key,
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
    ];

    $options = [
        'http' => [
            'method' => 'POST',
            'header' => implode("\r\n", $headers),
            'content' => $data,
        ],
    ];
    $context = stream_context_create($options);
    $url = "https://fcm.googleapis.com/v1/projects/sepais-2024/messages:send";
    $result = @file_get_contents($url, false, $context);
    if ($result === false) {
        echo json_encode(error_get_last());
    } else {
    }
}
