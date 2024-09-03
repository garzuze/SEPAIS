<?php
include('../secure.php');
date_default_timezone_set('America/Sao_Paulo');
session_start();

function insert_responsavel_libera($email, $aluno_id, $motivo){
    // Preparando variáveis para inserção no BD
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d H:i:s');
    $data_calendario = date('Y-m-d');
    $sql = connect();

    // Checar registros duplicados
    $registros_duplicados = $sql->prepare("SELECT * FROM responsavel_libera_aluno where cast(data as date)= ? and aluno_id = ?;");
    $registros_duplicados->bind_param("ss", $data_calendario, $aluno_id);
    $registros_duplicados->execute();
    $result_query = $registros_duplicados->get_result();
    if ($result_query->num_rows >= 1) {
        return false;
    }
    // Conectando ao BD e inserindo novos dados
    $query = $sql->prepare("INSERT INTO responsavel_libera_aluno (responsavel_email, aluno_id, data, horario_saida, motivo_id) VALUES (?, ?, ?, NULL, ?);");
    if ($query) {
        $query->bind_param("ssss", $email, $aluno_id, $date, $motivo);
        $query->execute();

        if ($query->affected_rows <= 0) {
            echo "Error inserting data: " . $query->error;
            return false;
        }

        $query->close();
    } else {
        echo "Error preparing statement: " . $sql->error;
        return false;
    }
    $sql->close();
    return true;
}
?>