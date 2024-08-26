<?php
require_once('../connect.php');

session_start();
if(!empty($_SESSION['email'])) {
    if (!empty($_POST['responsaveis']) && !empty($_POST['emails']) && !empty($_POST['telefones'])){
        try {
            $responsaveis = $_POST['responsaveis'];
            $emails = $_POST['emails'];
            $telefones = $_POST['telefones'];

            $registros = ["responsaveis" => $responsaveis, "emails" => $emails, "telefones" => $telefones];
            $sql = connect();
            foreach ($registros["responsaveis"] as $index => $responsavel) {
                $responsavel = ucwords(strtolower($responsavel));
                $email = strtolower($registros["emails"][$index]);
                $telefone = preg_replace('/[^\d]/', '', $registros["telefones"][$index]);
                $foto_path = "static/default_user_icon.jpg";
                echo "\n $responsavel \n";
                echo "$email \n";
                echo "$telefone \n";

                $insert_user_query = $sql->prepare("INSERT INTO usuario (nome, email, foto_path) VALUES (?, ?, ?)");
                $insert_user_query->bind_param("sss", $responsavel, $email, $foto_path);
                $insert_user_query->execute();

                $insert_child_user_stmt = "INSERT INTO responsavel (email, telefone) VALUES (?, ?)";
                $insert_child_user_query = $sql->prepare($insert_child_user_stmt);
                $insert_child_user_query->bind_param("ss", $email, $telefone);
                $insert_child_user_query->execute();

                $log_msg = "Servidor(a) ".$_SESSION['email']." cadastrou um responsável: Email = $email, Telefone = $telefone";
                // echo($log_msg ."</br>");
                write_log($log_msg, 0);
                // header('Location: ../index.php');
            }
        }catch (Exception $e) {
            error_log($e->getMessage());
            exit($e->getMessage());
        }
    }
} else{
	echo json_encode(0);
	header('Location: ../login.php');
}