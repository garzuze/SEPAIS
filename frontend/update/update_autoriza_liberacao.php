<?php
include('../secure.php');
session_start();

function update_autoriza_liberacao($aluno_id){
    // Preparando variáveis para inserção no BD
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y-m-d');
    $sql = connect();

    $query = $sql->prepare("UPDATE sepae_libera_aluno SET isAutorizado = TRUE
        WHERE (aluno_id = ?) and CAST(`sepae_libera_aluno`.`data` AS DATE) = ?;");
    if ($query) {
        $query->bind_param("ss", $aluno_id, $data);
        $query->execute();

        if ($query->affected_rows <= 0) {
            echo "Error inserting data: " . $query->error;
            return false;
        }
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }

        $query->close();
    } else {
        echo "Error preparing statement: " . $sql->error;
        return false;
    }
    $sql->close();
}
?>