<?php
include('../secure.php');
date_default_timezone_set('America/Sao_Paulo');
session_start();
if(isset($_SESSION['email'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Preparando variáveis para inserção no BD
        $motivo = $_POST['motivo'];
        $email = $_POST['email'];
        $id_aluno = $_POST['id_aluno'];
        $date = date('Y-m-d H:i:s');
        $data_calendario = date('Y-m-d');

        // Conectando ao BD e inserindo novos dados
        $sql = connect();

        foreach ($id_aluno as $aluno_id) {
            $registros_duplicados = $sql->prepare("SELECT * FROM sepae_libera_aluno where cast(data as date)= ? and aluno_id = ?;");
            $registros_duplicados->bind_param("ss", $data_calendario, $aluno_id);
            $registros_duplicados->execute();
            $result_query = $registros_duplicados->get_result();
            if ($result_query->num_rows >= 1) {
                echo "Registro duplicado";
                continue;
            }
            $query = $sql->prepare("INSERT INTO sepae_libera_aluno (sepae_email, aluno_id, data, horario_saida, motivo_id) VALUES (?, ?, ?, NULL, ?)");
            // if (!$registros_duplicados->num_rows >= 1) {continue;};
            if ($query) {
                $query->bind_param("ssss", $email, $aluno_id, $date, $motivo);
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