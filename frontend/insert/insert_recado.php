<?php
require_once('../connect.php');

session_start();
if(isset($_SESSION['email'])) {
    if (isset($_POST['titulo'])){
        try {
            // Preparando variáveis para inserção no BD
            $titulo = $_POST['titulo'];
            $recado = $_POST['recado'];
            $validade = $_POST['validade'];
            $email = $_POST['email'];
            $date = date('Y-m-d H:i:s');
            
            if ($validade === ''){
                $validade = null;
            }
            
            // Conectando ao BD e inserindo novos dados
            $sql = connect();
            $query = $sql->prepare("INSERT INTO recado (titulo, recado, data, validade, sepae_email) VALUES (?, ?, ?, ?, ?)");
            $query->bind_param("sssss", $titulo, $recado, $date, $validade, $email);
            $query->execute();
            header('Location: ../login.php');
        }catch (Exception $e) {
            error_log($e->getMessage());
            exit("<br>Alguma coisa estranha aconteceu");
        }
    }
} else{
	echo json_encode(0);
	header('Location: ../login.php');
}
?>