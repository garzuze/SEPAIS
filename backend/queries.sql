-- Select alunos liberados no dia pela SEPAE.
SELECT 
        `aluno`.`id` AS `id_aluno`,
        `aluno`.`nome` AS `aluno`,
        `turma`.`turma` AS `turma`,
        `motivo`.`motivo` AS `motivo`,
        `sepae_libera_aluno`.`sepae_email` AS `liberador`,
        `sepae_libera_aluno`.`data` AS `data`
    FROM
        (((`sepae_libera_aluno`
        JOIN `aluno`)
        JOIN `turma`)
        JOIN `motivo`)
    WHERE
        ((`aluno`.`id` = `sepae_libera_aluno`.`aluno_id`)
            AND (CAST(`sepae_libera_aluno`.`data` AS date) = CURDATE())
            AND (`sepae_libera_aluno`.`horario_saida` IS NULL)
            AND (`turma`.`id` = `aluno`.`turma_id`)
            AND (`motivo`.`id` = `sepae_libera_aluno`.`motivo_id`));

-- Select alunos liberados no dia pelos responsáveis
SELECT 
        `aluno`.`id` AS `id_aluno`,
        `aluno`.`nome` AS `aluno`,
        `turma`.`turma` AS `turma`,
        `motivo`.`motivo` AS `motivo`,
        `responsavel`.`email` AS `liberador`,
        `responsavel_libera_aluno`.`data` AS `data`
    FROM
        ((((`responsavel_libera_aluno`
        JOIN `responsavel`)
        JOIN `aluno`)
        JOIN `motivo`)
        JOIN `turma`)
    WHERE
        ((`aluno`.`id` = `responsavel_libera_aluno`.`aluno_id`)
            AND (`motivo`.`id` = `responsavel_libera_aluno`.`motivo_id`)
            AND (`responsavel`.`email` = `responsavel_libera_aluno`.`responsavel_email`)
            AND (CAST(`responsavel_libera_aluno`.`data` AS DATE) = CURDATE())
            AND (`responsavel_libera_aluno`.`horario_saida` IS NULL)
            AND (`turma`.`id` = `aluno`.`turma_id`));

-- Select recados que não passaram ou não tem validade
SELECT id, titulo, recado, data, validade, sepae_email from recado 
		where (CURDATE() < validade) or (validade is null) ORDER BY id DESC;

-- Select responsáveis e alunos dependentes
SELECT responsavel.email as email_responsavel,
			aluno.id as id_aluno, aluno.nome as nome_aluno, turma.turma as turma
			from responsavel_has_aluno, responsavel, aluno, turma
			where (responsavel.email = responsavel_has_aluno.responsavel_email)
			and (aluno.id = responsavel_has_aluno.aluno_id) and (turma.id = aluno.turma_id);
			-- and (responsavel.email = ?) // Se for para um responsável específico
            
-- Select alunos
SELECT aluno.id, aluno.nome as Nome, turma.turma as Turma, foto_path as Foto 
from aluno, turma 
where (turma.id = aluno.turma_id)
order by aluno.id;

-- Select alunos por turma
SELECT 
        `aluno`.`id` AS `id_aluno`,
        `aluno`.`nome` AS `nome_aluno`,
        GROUP_CONCAT(`usuario`.`nome` -- Para n dar erro se o aluno tem mais de um responsável
            SEPARATOR ', ') AS `nome_responsavel`,
        GROUP_CONCAT(`responsavel`.`email`
            SEPARATOR ', ') AS `email_responsavel`,
        `turma`.`turma` AS `turma`
    FROM
        (`usuario`
        JOIN (((`aluno`
        JOIN `responsavel_has_aluno` ON ((`aluno`.`id` = `responsavel_has_aluno`.`aluno_id`)))
        JOIN `responsavel` ON ((`responsavel_has_aluno`.`responsavel_email` = `responsavel`.`email`)))
        JOIN `turma` ON ((`aluno`.`turma_id` = `turma`.`id`))))
    WHERE
        ((`turma`.`turma` = ?) -- Adicionar turma
            AND (`responsavel`.`email` = `usuario`.`email`))
    GROUP BY `aluno`.`id` , `aluno`.`nome` , `turma`.`turma`
    ORDER BY `aluno`.`nome`;

-- select nome do aluno, nome do responsavel, email do responsavel e turma especifica
SELECT aluno.nome as 'nome aluno', responsavel.nome as 'nome responsavel', responsavel.email as 'email responsavel', turma.turma as 'turma'
from responsavel_has_aluno, responsavel, aluno, turma
where (responsavel.email = responsavel_has_aluno.responsavel_email)
and (aluno.id = responsavel_has_aluno.aluno_id) and (turma.id = aluno.turma_id) and (turma.turma = 'adm1'); 

-- select dependentes de um certo responsável que foram liberados pela SEPAE em um dia específico
SELECT 
        `sepaisdb`.`aluno`.`id` AS `id_aluno`,
        `sepaisdb`.`aluno`.`nome` AS `nome_aluno`,
        `sepaisdb`.`turma`.`turma` AS `turma`,
        `sepaisdb`.`sepae_libera_aluno`.`data` AS `data`,
        `sepaisdb`.`sepae_libera_aluno`.`horario_saida` AS `horario_saida`
    FROM
        (((`sepaisdb`.`aluno`
        JOIN `sepaisdb`.`turma`)
        JOIN `sepaisdb`.`sepae_libera_aluno`)
        JOIN `sepaisdb`.`responsavel_has_aluno`)
    WHERE
        ((`sepaisdb`.`aluno`.`id` = `sepaisdb`.`sepae_libera_aluno`.`aluno_id`)
            AND (`sepaisdb`.`sepae_libera_aluno`.`horario_saida` IS NULL)
            AND (`sepaisdb`.`turma`.`id` = `sepaisdb`.`aluno`.`turma_id`)
            AND (`sepaisdb`.`responsavel_has_aluno`.`aluno_id` = `sepaisdb`.`sepae_libera_aluno`.`aluno_id`)
            AND (CAST(`sepaisdb`.`sepae_libera_aluno`.`data` AS DATE) = '2024-08-09') -- substituir data por ? para  diferentes valores (Tem que formatar a data direitinho que vc recebeu do input)
            AND (`sepaisdb`.`responsavel_has_aluno`.`responsavel_email` = 'kratos@gmail.com')); -- substituir email por ? para  diferentes valores 
            
-- select historico de atrasos
SELECT 
        `aluno`.`id` AS `id_aluno`,
        `aluno`.`nome` AS `nome_aluno`,
        `turma`.`turma` AS `turma`,
        `aluno_atrasado`.`data` AS `data`,
        `aluno_atrasado`.`portaria_email` AS `servidor`
    FROM
        ((`aluno_atrasado`
        JOIN `aluno`)
        JOIN `turma`)
    WHERE
        ((`aluno`.`id` = `aluno_atrasado`.`aluno_id`)
            AND (`turma`.`id` = `aluno`.`turma_id`))
    ORDER BY `aluno_atrasado`.`data` DESC;
    
-- select historico de liberações pelos responsaveis
SELECT 
        `aluno`.`id` AS `id_aluno`,
        `aluno`.`nome` AS `nome_aluno`,
        `turma`.`turma` AS `turma`,
        `responsavel_libera_aluno`.`data` AS `data`,
        `responsavel_libera_aluno`.`horario_saida` AS `saida`,
        `motivo`.`motivo` AS `motivo`,
        `responsavel`.`email` AS `responsavel`
    FROM
        ((((`responsavel_libera_aluno`
        JOIN `aluno`)
        JOIN `turma`)
        JOIN `motivo`)
        JOIN `responsavel`)
    WHERE
        ((`aluno`.`id` = `responsavel_libera_aluno`.`aluno_id`)
            AND (`responsavel`.`email` = `responsavel_libera_aluno`.`responsavel_email`)
            AND (`turma`.`id` = `aluno`.`turma_id`)
            AND (`motivo`.`id` = `responsavel_libera_aluno`.`motivo_id`))
    ORDER BY `responsavel_libera_aluno`.`data` DESC;

-- select historico de liberações pela SEPAE
SELECT 
        `aluno`.`id` AS `id_aluno`,
        `aluno`.`nome` AS `nome_aluno`,
        `turma`.`turma` AS `turma`,
        `sepae_libera_aluno`.`data` AS `data`,
        `sepae_libera_aluno`.`horario_saida` AS `saida`,
        `motivo`.`motivo` AS `motivo`,
        `sepae_libera_aluno`.`sepae_email` AS `servidor`
    FROM
        (((`sepae_libera_aluno`
        JOIN `aluno`)
        JOIN `turma`)
        JOIN `motivo`)
    WHERE
        ((`aluno`.`id` = `sepae_libera_aluno`.`aluno_id`)
            AND (`turma`.`id` = `aluno`.`turma_id`)
            AND (`motivo`.`id` = `sepae_libera_aluno`.`motivo_id`))
    ORDER BY `sepae_libera_aluno`.`data` DESC;