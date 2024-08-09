use sepaisdb;

-- Select alunos liberados no dia pela SEPAE. o username na tabela de liberação tem que ser um PK?
SELECT aluno.nome as Aluno, turma.turma as Turma, motivo.motivo as Motivo, 
sepae_libera_aluno.sepae_username as Servidor  FROM sepaisdb.sepae_libera_aluno, aluno, turma, motivo 
where (aluno.id = sepae_libera_aluno.aluno_id) and (date(data) = CURDATE()) and (horario_saida is null)
and (turma.id = aluno.turma_id) and (motivo.id = sepae_libera_aluno.motivo_id);

-- Select alunos liberados no dia pelos responsáveis
SELECT aluno.nome as Aluno, turma.turma as Turma, motivo.motivo as Motivo, responsavel.nome  
as Responsável  FROM sepaisdb.responsavel_libera_aluno, responsavel, aluno , motivo, turma
where (aluno.id = responsavel_libera_aluno.aluno_id)  and (motivo.id = responsavel_libera_aluno.motivo_id)
and (responsavel.email = responsavel_libera_aluno.responsavel_email) 
and (date(data) = CURDATE()) and (horario_saida is null)
and (turma.id = aluno.turma_id);

-- Select recados que não passaram ou não tem validade
SELECT titulo as Título, recado as Recado, data as Data, sepae_username as Enviado_por from recado 
where (CURDATE() < validade) or (validade is null);

-- Select responsáveis e alunos dependentes
SELECT responsavel.nome as Responsável, aluno.nome as Aluno, turma.turma as Turma
from responsavel_has_aluno, responsavel, aluno, turma
where (responsavel.email = responsavel_has_aluno.responsavel_email)
and (aluno.id = responsavel_has_aluno.aluno_id) and (turma.id = aluno.turma_id); 

-- Select alunos
SELECT aluno.id, aluno.nome as Nome, turma.turma as Turma, foto_path as Foto 
from aluno, turma 
where (turma.id = aluno.turma_id)
order by aluno.id;

-- Select alunos por turma
SELECT nome, turma FROM sepaisdb.aluno
INNER JOIN sepaisdb.turma
ON sepaisdb.aluno.turma_id = sepaisdb.turma.id
WHERE sepaisdb.turma.id = '{id_da_turma}';

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
            AND (`sepaisdb`.`responsavel_has_aluno`.`responsavel_email` = 'kratos@gmail.com')) -- substituir email por ? para  diferentes valores 
