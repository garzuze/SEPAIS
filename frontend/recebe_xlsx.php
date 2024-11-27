<?php
require_once('connect.php');
$sql = connect();

function validarDadosAluno($alunoData) {
    return isset($alunoData['aluno'][0]['periodo']) &&
        isset($alunoData['aluno'][0]['nome']) &&
        isset($alunoData['responsaveis'][0]['nome']) &&
        isset($alunoData['responsaveis'][0]['email']) &&
        isset($alunoData['responsaveis'][0]['telefone']);
}

function validarDadosResponsavel2($alunoData) {
    return $alunoData['responsaveis'][1] &&
        isset($alunoData['responsaveis'][1]['nome']) &&
        isset($alunoData['responsaveis'][1]['email']) &&
        isset($alunoData['responsaveis'][1]['telefone']);
}

function inserirResponsaveis($email, $responsavel, $foto_path, $telefone) {
    $sql = connect();
    $insert_user_query = $sql->prepare("INSERT INTO usuario (email, nome, foto_path) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE nome=?, foto_path=?");
    $insert_user_query->bind_param("sssss", $email, $responsavel, $foto_path, $responsavel, $foto_path);
    $insert_user_query->execute();

    $insert_child_user_stmt = "INSERT INTO responsavel (email, telefone) VALUES(?, ?) ON DUPLICATE KEY UPDATE telefone=?";
    $insert_child_user_query = $sql->prepare($insert_child_user_stmt);
    $insert_child_user_query->bind_param("sss", $email, $telefone, $telefone);
    $insert_child_user_query->execute();
}

function descobrirIdAluno($responsavel_email1, $responsavel_email2, $aluno_nome, $turma1, $turma2) {
    $sql = connect();
    $read_id_query = $sql->prepare("(SELECT 
        `aluno`.`id` AS `id`,
        `aluno`.`nome` AS `nome`,
        NULL AS `turma`,
        `responsavel_has_aluno`.`responsavel_email` AS `responsavel_email`
    FROM
        ((`aluno`
        JOIN `responsavel_has_aluno` ON ((`aluno`.`id` = `responsavel_has_aluno`.`aluno_id`)))
        JOIN `turma` ON ((`turma`.`id` = `aluno`.`turma_id`)))
    WHERE
        ((`aluno`.`nome` = ?)
            AND ((`responsavel_has_aluno`.`responsavel_email` = ?)
            OR (`responsavel_has_aluno`.`responsavel_email` = ?)))
    LIMIT 1) 
    UNION ALL 
    (SELECT 
        `aluno`.`id` AS `id`,
        `aluno`.`nome` AS `nome`,
        `turma`.`turma` AS `turma`,
        `responsavel_has_aluno`.`responsavel_email` AS `responsavel_email`
    FROM
        ((`aluno`
        JOIN `responsavel_has_aluno` ON ((`aluno`.`id` = `responsavel_has_aluno`.`aluno_id`)))
        JOIN `turma` ON ((`turma`.`id` = `aluno`.`turma_id`)))
    WHERE
        ((`aluno`.`nome` = ?)
            AND ((`turma`.`turma` = ?)
            OR (`turma`.`turma` = ?))
            AND NOT EXISTS (SELECT 
                1
            FROM
                (`aluno`
                JOIN `responsavel_has_aluno` ON ((`aluno`.`id` = `responsavel_has_aluno`.`aluno_id`)))
            WHERE
                ((`aluno`.`nome` = ?)
                    AND ((`responsavel_has_aluno`.`responsavel_email` = ?)
                    OR (`responsavel_has_aluno`.`responsavel_email` = ?)))))
    LIMIT 1)");

    $read_id_query->bind_param("sssssssss", $aluno_nome, $responsavel_email1, $responsavel_email2, $aluno_nome, $turma1, $turma2, $aluno_nome, $responsavel_email1, $responsavel_email2);
    $read_id_query->execute();

    $read_id_query = $read_id_query->get_result();
	$read_id_queryFormatado = $read_id_query->fetch_all(MYSQLI_ASSOC);
    // echo json_encode($read_id_queryFormatado, JSON_PRETTY_PRINT); 

    if (!empty($read_id_queryFormatado)) {
        $id = $read_id_queryFormatado[0]['id'];  // Get the 'id' from the first row
        return $id;
    } else {
        return 0;
    }
}

function inserirAlunos($aluno_nome, $turma1, $id_aluno) {
    $sql = connect();
    $foto_path = "static/default_user_icon.jpg";

    if ($id_aluno == false) {
        $query = $sql->prepare("INSERT INTO aluno (nome, foto_path, turma_id) VALUES (?, ?, ?)");
        $query->bind_param("ssi", $aluno_nome, $foto_path, $turma1);
        $query->execute();

        $last_id = $sql->insert_id;

        // echo "Aluno cadastrado com ID: $last_id\n";
        return $last_id;
    } else {
        $query = $sql->prepare("UPDATE aluno SET turma_id = ? WHERE id = ?");
        $query->bind_param("ii", $turma1, $id_aluno);
        $query->execute();

        // echo "Aluno atualizado\n";
        return $id_aluno;
    }
}

function vincularAlunos($id_aluno, $responsavel_email) {
    $sql = connect();
    $query = $sql->prepare("INSERT INTO `responsavel_has_aluno` (`aluno_id`, `responsavel_email`) VALUES (?, ?) ON DUPLICATE KEY UPDATE responsavel_email = ?;");
    $query->bind_param("sss", $id_aluno, $responsavel_email, $responsavel_email);
    $query->execute();
}

function inserirTurmas($turma) {
    $sql = connect();
    $turma_query = $sql->prepare("SELECT id FROM turma WHERE turma = ?");
    $turma_query->bind_param("s", $turma);
    $turma_query->execute();
    $result_query = $turma_query->get_result();
    $row = $result_query->fetch_assoc();

    if (!empty($row)) {
        $turma = $row['id'];
        return $turma;
    } else {
        echo $turma;
        $query = $sql->prepare("INSERT INTO turma (turma) VALUES (?)");
        $query->bind_param("s", $turma);
        $query->execute();

        $last_id = $sql->insert_id;
        echo $last_id;
        return $last_id;
    }
}

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['email'])) {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        $foto_path = "static/default_user_icon.jpg";
        foreach ($data as $alunoData) {
            $contador = 2;

            if (validarDadosAluno($alunoData)) {
                $responsavel_email1 = strtolower($alunoData['responsaveis'][0]['email']);
                if (!validarDadosResponsavel2($alunoData)) {
                    $contador--;
                    $responsavel_email2 = strtolower($alunoData['responsaveis'][0]['email']);
                } else {$responsavel_email2 = strtolower($alunoData['responsaveis'][1]['email']);}
                $periodo = $alunoData['aluno'][0]['periodo'];
                $curso = $alunoData['aluno'][0]['curso'];
                $search_array = array('Ensino Médio Técnico em Informática' => "INFO", 'Ensino Médio Técnico em Administração' => "ADM", 'Bacharelado em Administração' => "BADM", 'Bacharelado em Ciência da Computação' => "BCC", 'Curso Superior em Gestão da Tecnologia da Informação' => 'GTI');
                if (!array_key_exists($curso, $search_array)) {
                    if (preg_match_all("([A-Z])", $curso, $matches)) {
                        $uppercase_letters = $matches[0];
                        $curso = implode($uppercase_letters);
    
                        echo $curso;
                    }
                } else {
                    $curso = $search_array[$curso];
                    // echo $curso;
                }

                $aluno_nome = ucwords(strtolower($alunoData['aluno'][0]['nome']));
                $turma1 = $curso.$periodo;
                $turma1 = inserirTurmas($turma1);
                
                $turma2 = $curso.($periodo - 1);

                $id_aluno = descobrirIdAluno($responsavel_email1, $responsavel_email2, $aluno_nome, $turma1, $turma2);
                // echo "O id de $aluno_nome é $id_aluno \n";

                $id_aluno = inserirAlunos($aluno_nome, $turma1, $id_aluno);
                // echo $id_aluno;

                for ($i = 0; $i < $contador; $i++) {
                    $responsavel = ucwords(strtolower($alunoData['responsaveis'][$i]['nome']));
                    $resp_email = strtolower($alunoData['responsaveis'][$i]['email']);
                    $telefone = preg_replace('/[^\d]/', '', $alunoData['responsaveis'][$i]['telefone']);
                    inserirResponsaveis($resp_email, $responsavel, $foto_path, $telefone);
                    vincularAlunos($id_aluno, $resp_email);
                }
            }
        }
    }catch (Exception $e) {
        error_log($e->getMessage());
        exit($e->getMessage());
    }    
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method']);
}
