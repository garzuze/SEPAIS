<?php
require_once('../connect.php');

session_start();
if(!empty($_SESSION['email'])) {
    if (!empty($_POST['alunos']) && !empty($_POST['turmas'])){
        try {
            $alunos = $_POST['alunos'];
            $turmas = $_POST['turmas'];
            $registros = ["alunos" => $alunos, "turmas" => $turmas];
            $sql = connect();
            foreach ($registros["alunos"] as $index => $aluno) {
                $turma = $registros["turmas"][$index];
                echo "$aluno, $turma \n";
                $foto_path = "nenhum";
                $query = $sql->prepare("INSERT INTO aluno (nome, foto_path, turma_id) VALUES (?, ?, ?);");
                $query->bind_param("ssi", $aluno, $foto_path, $turma);
                $query->execute();
                header('Location: ../index.php');
            }
        }catch (Exception $e) {
            error_log($e->getMessage());
            exit("<br>Alguma coisa estranha aconteceu");
        }
    }
} else{
	echo json_encode(0);
	header('Location: ../login.php');
}
