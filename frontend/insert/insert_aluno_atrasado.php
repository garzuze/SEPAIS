<?php
include('../secure.php');
date_default_timezone_set('America/Sao_Paulo');
session_start();
if(isset($_SESSION['email'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Preparando variáveis para inserção no BD
        $email = $_POST['email'];
        $id_aluno = intval($_POST['id_aluno']);
        $date = date('Y-m-d H:i:s');
        $data_calendario = date('Y-m-d');

        // Conectando ao BD e inserindo novos dados
        $sql = connect();
        $registros_duplicados = $sql->prepare("SELECT * FROM aluno_atrasado where cast(data as date)= ? and aluno_id = ?;");
        $registros_duplicados->bind_param("ss", $data_calendario, $id_aluno);
        $registros_duplicados->execute();
        $result_query = $registros_duplicados->get_result();

        if ($result_query->num_rows >= 1) {
            $resposta = ['status' => 1, 'mensagem' => 'Atraso já foi registrado!'];
        } else{
            $query = $sql->prepare("INSERT INTO aluno_atrasado (portaria_email, aluno_id, data) VALUES (?, ?, ?)");
            if ($query) {
                $query->bind_param("sis", $email, $id_aluno, $date);
                $query->execute();
                $query->close();
                $resposta = ['status' => 1, 'mensagem' => 'Atraso registrado!'];
            } else {
                echo "Error preparing statement: " . $sql->error;
            }
            $sql->close();
        }
            // header('Location: ../login.php');
        }
} else{
	$resposta = ['status' => 0, 'mensagem' => 'Session não existe'];
}
echo json_encode($resposta);
?>