<?php
require_once('../connect.php');

session_start();
if(!empty($_SESSION['email'])) {
    if (!empty($_POST['turma'])){
        try {
            $email = $_SESSION['email'];
            $turma = strtoupper($_POST['turma']);
            $sql = connect();
            $query = $sql->prepare("INSERT INTO turma (turma) VALUES (?)");
            $query->bind_param("s", $turma);
            $query->execute();

            $log_msg = "Servidor(a) $email cadastrou uma turma: Turma = $turma";
            // echo($log_msg ."</br>");
            write_log($log_msg, 0);
            header('Location: ../index.php');
        }catch (Exception $e) {
            error_log($e->getMessage());
            exit("<br>Alguma coisa estranha aconteceu");
        }
    }
} else{
	
	header('Location: ../login.php');
}
