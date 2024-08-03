<?php
require_once('../connect.php');

session_start();
if(!empty($_SESSION['email'])) {
    if (!empty($_POST['motivo'])){
        try {
            $motivo = $_POST['motivo'];
            $sql = connect();
            $query = $sql->prepare("INSERT INTO motivo (motivo) VALUES (?)");
            $query->bind_param("s", $motivo);
            $query->execute();
            header('Location: ../index.php');
            // $resposta = ['status' => 1, 'mensagem' => 'Atraso registrado!'];
        }catch (Exception $e) {
            error_log($e->getMessage());
            exit("<br>Alguma coisa estranha aconteceu");
        }
    }
} else{
	echo json_encode(0);
	header('Location: ../login.php');
}
