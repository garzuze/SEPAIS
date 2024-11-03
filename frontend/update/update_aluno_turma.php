<?php
include('../secure.php');
session_start();
if (isset($_SESSION['email'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $sql = connect();
        
        $turma = $_POST['turma'];
        $id_aluno = $_POST['id_aluno'];
        $email = $_SESSION['email'];

        if ($turma == "APROV" || $turma == "DESIS") {
            $turma_query = $sql->prepare("SELECT id FROM turma WHERE turma = ?");
            $turma_query->bind_param("s", $turma);
            $turma_query->execute();
            $result_query = $turma_query->get_result();
            
            if ($result_query->num_rows == 0) {
                $create_turma = $sql->prepare("INSERT INTO turma (turma) VALUES (?)");
                $create_turma->bind_param("s", $turma);
                $create_turma->execute();

                $turma = $sql->insert_id;
            } else {
                $row = $result_query->fetch_assoc();
                $turma = $row['id'];
            }
            
            $turma_query->close();
        }

        foreach ($id_aluno as $aluno_id) {
            $query = $sql->prepare("UPDATE aluno SET turma_id = ? WHERE id = ?");
            if ($query) {
                $query->bind_param("ii", $turma, $aluno_id);
                $query->execute();

                if ($query->affected_rows <= 0) {
                    echo "Error updating data: " . $query->error;
                }

                $query->close();
                $log_msg = "Servidor(a) $email alterou um aluno para outra turma: IDaluno = $aluno_id, turma = $turma";
                write_log($log_msg, 1);
            } else {
                echo "Error preparing statement: " . $sql->error;
            }
        }

        $sql->close();
        header('Location: ../login.php');
    }
}
?>