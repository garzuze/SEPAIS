<?php
include('../secure.php');
date_default_timezone_set('America/Sao_Paulo');
session_start();
if(isset($_SESSION['email'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Preparando variáveis para inserção no BD
        $username = ucfirst($_POST['username']);
        $id_aluno = intval($_POST['id_aluno']);
        $date = date('Y-m-d H:i:s');

        // Conectando ao BD e inserindo novos dados
        $sql = connect();
        $query = $sql->prepare("INSERT INTO aluno_atrasado (portaria_username, aluno_id, data) VALUES (?, ?, ?)");
        if ($query) {
            $query->bind_param("sis", $username, $id_aluno, $date);
            $query->execute();
            $query->close();
        } else {
            echo "Error preparing statement: " . $sql->error;
        }
        $sql->close();

        header('Location: ../login.php');
    }
} else{
	echo json_encode(0);
}
?>