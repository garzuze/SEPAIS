<?php
include('../secure.php');
date_default_timezone_set('America/Sao_Paulo');
session_start();
if(isset($_SESSION['email'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Preparando variáveis para inserção no BD
        $motivo = $_POST['motivo'];
        $username = ucfirst($_POST['username']);
        $id_aluno = $_POST['id_aluno'];
        $date = date('Y-m-d H:i:s');

        // Conectando ao BD e inserindo novos dados
        $sql = connect();

        foreach ($id_aluno as $aluno_id) {
            $query = $sql->prepare("INSERT INTO sepae_libera_aluno (sepae_username, aluno_id, data, horario_saida, motivo_id) VALUES (?, ?, ?, NULL, ?)");

            if ($query) {
                $query->bind_param("ssss", $username, $aluno_id, $date, $motivo);
                $query->execute();

                if ($query->affected_rows <= 0) {
                    echo "Error inserting data: " . $query->error;
                }

                $query->close();
            } else {
                echo "Error preparing statement: " . $sql->error;
            }
        }

        $sql->close();

        header('Location: ../login.php');
    }
} else{
	echo json_encode(0);
}
?>