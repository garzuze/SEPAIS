<?php
include('../secure.php');

session_start();
if(isset($_SESSION['email'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Preparando variáveis para inserção no BD
        $id_aluno = $_POST['id_aluno'];
        $data = $_POST['data']."%";

        // Conectando ao BD e inserindo novos dados
        $sql = connect();
        if(isset($_POST['servidor'])) {
            $query = $sql->prepare("UPDATE `sepaisdb`.`sepae_libera_aluno` SET `horario_saida` = now() 
            WHERE (`aluno_id` = ?) and `data` LIKE ?;");
        }
        elseif(isset($_POST['responsavel'])){
            $query = $sql->prepare("UPDATE `sepaisdb`.`responsavel_libera_aluno` SET `horario_saida` = now() 
            WHERE (`aluno_id` = ?) and `data` LIKE ?;");
        }

        if ($query) {
            $query->bind_param("is", $id_aluno, $data);
            $query->execute();
            $query->close();
        } else {
            echo "Error preparing statement: " . $sql->error;
        }
        header('Location: ../index.php');
    }
} else{
	echo json_encode(0);
}
?>