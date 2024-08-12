<?php
require_once('../connect.php');

function read_dependentes_liberados($date, $email)
{
    $mysqli = connect();
    try {
        $consulta = $mysqli->prepare("SELECT 
        `aluno`.`id` AS `id_aluno`,
        `aluno`.`nome` AS `nome_aluno`,
        `turma`.`turma` AS `turma`,
        `sepae_libera_aluno`.`data` AS `data`,
        `sepae_libera_aluno`.`horario_saida` AS `horario_saida`,
        `motivo`.`motivo` AS `motivo`
    FROM
        (((`aluno`
        JOIN `turma`)
        JOIN `sepae_libera_aluno`)
        JOIN `responsavel_has_aluno`
        JOIN `motivo`)  
    WHERE
        ((`aluno`.`id` = `sepae_libera_aluno`.`aluno_id`)
            AND (`sepae_libera_aluno`.`horario_saida` IS NULL)
            AND (`turma`.`id` = `aluno`.`turma_id`)
            AND (`motivo`.`id` = `sepae_libera_aluno`.`motivo_id`)
            AND (`responsavel_has_aluno`.`aluno_id` = `sepae_libera_aluno`.`aluno_id`)
            AND (CAST(`sepae_libera_aluno`.`data` AS DATE) = ?)
            AND (`responsavel_has_aluno`.`responsavel_email` = ?))
");
        $consulta->bind_param("ss", $date, $email);
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
