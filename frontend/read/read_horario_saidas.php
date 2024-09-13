<?php
require_once('../connect.php');

function read_horario_saidas($email){
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d');

    $mysqli = connect();
    try {
        $consulta = $mysqli->prepare("SELECT 
        `aluno`.`id` AS `id_aluno`,
        `aluno`.`nome` AS `aluno`,
        `sepae_libera_aluno`.`horario_saida` AS `saida`
    FROM
        ((`sepae_libera_aluno`
        JOIN `aluno`)
        JOIN `responsavel_has_aluno`)
    WHERE
        ((`aluno`.`id` = `sepae_libera_aluno`.`aluno_id`)
            AND (CAST(`sepae_libera_aluno`.`data` AS DATE) = ?)
            AND (`sepae_libera_aluno`.`horario_saida` IS NOT NULL)
            AND (`responsavel_has_aluno`.`aluno_id` = `sepae_libera_aluno`.`aluno_id`)
            AND (`responsavel_has_aluno`.`responsavel_email` = ?)) 
    UNION SELECT 
        `aluno`.`id` AS `id_aluno`,
        `aluno`.`nome` AS `aluno`,
        `responsavel_libera_aluno`.`horario_saida` AS `saida`
    FROM
        (`responsavel_libera_aluno`
        JOIN `aluno`)
    WHERE
        ((`aluno`.`id` = `responsavel_libera_aluno`.`aluno_id`)
            AND (CAST(`responsavel_libera_aluno`.`data` AS DATE) = ?)
            AND (`responsavel_libera_aluno`.`horario_saida` IS NOT NULL)
            AND (`responsavel_libera_aluno`.`responsavel_email` = ?))
");
        $consulta->bind_param("ssss", $date, $email, $date, $email);
        $consulta->execute();
        $resultado = $consulta->get_result();
        if ($resultado->num_rows > 0) {
            $resultadoFormatado = $resultado->fetch_all(MYSQLI_ASSOC);
            $consulta->close();
            $mysqli->close();
            return $resultadoFormatado;
        } else {
            return false;
        }
    } catch (Exception $e) {
        print_r($e->getMessage());
        print_r($mysqli->error);
        exit('Alguma coisa estranha aconteceu...');
    }
}