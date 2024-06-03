<?php
include('../secure.php');

session_start();
if(isset($_SESSION['email'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Preparando variáveis para inserção no BD
        $username = ucfirst($_POST['username']);
        $id_aluno = intval($_POST['id_aluno']);

        // Conectando ao BD e inserindo novos dados
        $sql = connect();
        $query = $sql->prepare("INSERT INTO aluno_atrasado (portaria_username, aluno_id, data) VALUES (?, ?, now())");
        if ($query) {
            $query->bind_param("si", $username, $id_aluno);
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