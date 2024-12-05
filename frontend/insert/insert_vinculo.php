<?php
require_once('../connect.php');

session_start();
if(!empty($_SESSION['email'])) {
    if (!empty($_POST['alunos']) && !empty($_POST['responsaveis'])){
        try {
            $alunos = $_POST['alunos'];
            $responsaveis = $_POST['responsaveis'];
            $registros = ["alunos" => $alunos, "responsaveis" => $responsaveis];
            print_r($registros);
            $sql = connect();
            foreach ($registros["alunos"] as $index => $aluno) {
                $responsavel = $registros["responsaveis"][$index];

                $query = $sql->prepare("INSERT INTO `responsavel_has_aluno` (`aluno_id`, `responsavel_email`) VALUES (?, ?);");
                $query->bind_param("ss", $aluno, $responsavel);
                $query->execute();

                $log_msg = "Servidor(a) ".$_SESSION['email']." cadastrou um vínculo: Id do aluno = $aluno, Responsável = $responsavel";
                // echo($log_msg ."</br>");
                write_log($log_msg, 0);
                header('Location: ../index.php');
            }
        }catch (Exception $e) {
            error_log($e->getMessage());
            exit($e->getMessage());
        }
    }
} else{
	
	header('Location: ../login.php');
}
