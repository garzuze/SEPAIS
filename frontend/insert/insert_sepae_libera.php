<?php
include('../secure.php');
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;

function get_google_access_token()
{
    $credential = new ServiceAccountCredentials(
        "https://www.googleapis.com/auth/firebase.messaging",
        json_decode(file_get_contents("../../sepais-2024-firebase-adminsdk-hxhsv-cfe10c070f.json"), true)
    );
    $token = $credential->fetchAuthToken(HttpHandlerFactory::build());
    $access_token = $token['access_token'];
    return $access_token;
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

function send_notification_liberation($student_name, $token)
{
    $server_key = get_google_access_token();

    $message = [
        'message' => [
            'notification' => [
                'title' => 'Olá! O aluno ' . $student_name . ' está liberado para sair.',
                'body' => 'Clique aqui para autorizar sua saída antecipada.',
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

date_default_timezone_set('America/Sao_Paulo');
session_start();
if (isset($_SESSION['email'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Preparando variáveis para inserção no BD
        $motivo = $_POST['motivo'];
        $email = $_POST['email'];
        $ids_alunos = $_POST['id_aluno'];
        $date = date('Y-m-d H:i:s');
        $data_calendario = date('Y-m-d');

        // Conectando ao BD e inserindo novos dados
        $sql = connect();

        foreach ($ids_alunos as $id_aluno) {
            $registros_duplicados = $sql->prepare("SELECT * FROM sepae_libera_aluno where cast(data as date)= ? and aluno_id = ?;");
            $registros_duplicados->bind_param("ss", $data_calendario, $id_aluno);
            $registros_duplicados->execute();
            $result_query = $registros_duplicados->get_result();
            if ($result_query->num_rows >= 1) {
                echo "Registro duplicado";
                continue;
            }
            $query = $sql->prepare("INSERT INTO sepae_libera_aluno (sepae_email, aluno_id, data, horario_saida, motivo_id) VALUES (?, ?, ?, NULL, ?)");
            // if (!$registros_duplicados->num_rows >= 1) {continue;};
            if ($query) {
                $query->bind_param("ssss", $email, $id_aluno, $date, $motivo);
                $query->execute();

                if ($query->affected_rows <= 0) {
                    echo "Error inserting data: " . $query->error;
                }

                $query->close();
            } else {
                echo "Error preparing statement: " . $sql->error;
            }

            $student_infos = get_student_info($id_aluno);
            foreach ($student_infos as $student_info) {
                if ($student_info["token_responsavel"] != null) {
                    send_notification_liberation($student_info["nome_aluno"], $student_info["token_responsavel"]);
                } else {
                    continue;
                }
            }
        }

        $sql->close();

        header('Location: ../login.php');
    }
} else {
}
