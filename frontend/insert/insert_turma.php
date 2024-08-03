<?php
require_once('../connect.php');

session_start();
if(!empty($_SESSION['email'])) {
    if (!empty($_POST['turma'])){
        try {
            $turma = $_POST['turma'];
            $sql = connect();
            $query = $sql->prepare("INSERT INTO turma (turma) VALUES (?)");
            $query->bind_param("s", $turma);
            $query->execute();
            header('Location: ../index.php');
        }catch (Exception $e) {
            error_log($e->getMessage());
            exit("<br>Alguma coisa estranha aconteceu");
        }
    }
} else{
	echo json_encode(0);
	header('Location: ../login.php');
}
