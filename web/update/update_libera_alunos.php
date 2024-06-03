<?php
include('../secure.php');

session_start();
if(isset($_SESSION['email'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Preparando variáveis para inserção no BD
        $id_aluno = intval($_POST['id_aluno']);
        $data = $_POST['date']."%";

        // Conectando ao BD e inserindo novos dados
        $sql = connect();
        // if(isset($_POST['servidor'])) {
        $query1 = $sql->prepare("UPDATE `id22194774_sepais`.`sepae_libera_aluno` SET `horario_saida` = now() 
        WHERE (`aluno_id` = ?) and `data` LIKE ?;");
        $query2 = $sql->prepare("UPDATE `id22194774_sepais`.`responsavel_libera_aluno` SET `horario_saida` = now() 
        WHERE (`aluno_id` = ?) and `data` LIKE ? ;");
        // }
        // elseif(isset($_POST['responsavel'])){
        //     $query = $sql->prepare("UPDATE `id22194774_sepais`.`responsavel_libera_aluno` SET `horario_saida` = now() 
        //     WHERE (`aluno_id` = ?) and `data` LIKE ?;");
        // }

        if ($query1) {
            $query1->bind_param("is", $id_aluno, $data);
            $query2->bind_param("is", $id_aluno, $data);
            $query1->execute();
            $query2->execute();
            $query1->close();
            $query2->close();
        } else {
            echo "Error preparing statement: " . $sql->error;
        }
        header('Location: ../index.php');
    }
} else{
	echo json_encode(0);
}
?>