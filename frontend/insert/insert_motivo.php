<?php
require_once('../connect.php');

session_start();
if(!empty($_SESSION['email'])) {
    if (!empty($_POST['motivo'])){
        try {
            $email = $_SESSION['email'];
            $motivo = $_POST['motivo'];
            $sql = connect();
            $query = $sql->prepare("INSERT INTO motivo (motivo) VALUES (?)");
            $query->bind_param("s", $motivo);
            $query->execute();

            $log_msg = "Servidor(a) $email cadastrou um motivo: Motivo = $motivo";
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
