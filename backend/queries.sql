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


