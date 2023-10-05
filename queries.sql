use sepaisdb;

-- Select alunos liberados no dia pela SEPAE. o username na tabela de liberação tem que ser um PK?
SELECT aluno.nome as Aluno, aluno.turma_turma as Turma, sepae_libera_aluno.motivo_motivo as Motivo, sepae_libera_aluno.sepae_username as Servidor  FROM sepaisdb.sepae_libera_aluno, aluno where (aluno.id = sepae_libera_aluno.aluno_id) and (data = CURDATE()) and (horario_saida is null);

-- Select alunos liberados no dia pelos responsáveis
SELECT aluno.nome as Aluno, aluno.turma_turma as Turma, motivo_motivo as Motivo, responsavel.nome  as Responsável  FROM sepaisdb.responsavel_libera_aluno, responsavel, aluno where (aluno.id = responsavel_libera_aluno.aluno_id) and (responsavel.email = responsavel_libera_aluno.responsavel_email) and (data = CURDATE()) and (horario_saida is null);

-- Select recados que não passaram ou não tem validade
SELECT titulo as Título, recado as Recado, data as Data, sepae_username as Enviado_por from recado where (CURDATE() < validade) or (validade is null);