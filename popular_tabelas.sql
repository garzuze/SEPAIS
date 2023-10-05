-- inserir turmas
INSERT INTO `sepaisdb`.`turma` (`turma`) VALUES ('ADM1');
INSERT INTO `sepaisdb`.`turma` (`turma`) VALUES ('ADM2');
INSERT INTO `sepaisdb`.`turma` (`turma`) VALUES ('ADM3');
INSERT INTO `sepaisdb`.`turma` (`turma`) VALUES ('ADM4');
INSERT INTO `sepaisdb`.`turma` (`turma`) VALUES ('INFO1');
INSERT INTO `sepaisdb`.`turma` (`turma`) VALUES ('INFO2');
INSERT INTO `sepaisdb`.`turma` (`turma`) VALUES ('INFO3');
INSERT INTO `sepaisdb`.`turma` (`turma`) VALUES ('INFO4');

-- inserir alunos
INSERT INTO `sepaisdb`.`alunos` (`nome`, `foto_path`, `turma_turma`) VALUES ('Lucas', 'nenhum', 'INFO3');
INSERT INTO `sepaisdb`.`alunos` (`nome`, `foto_path`, `turma_turma`) VALUES ('Pietro', 'vazio', 'INFO3');
INSERT INTO `sepaisdb`.`alunos` (`nome`, `foto_path`, `turma_turma`) VALUES ('Victor', 'nenhum', 'INFO3');
INSERT INTO `sepaisdb`.`alunos` (`nome`, `foto_path`, `turma_turma`) VALUES ('Mateus', 'nenhum', 'ADM1');
INSERT INTO `sepaisdb`.`alunos` (`nome`, `foto_path`, `turma_turma`) VALUES ('Mariana', 'nenhum', 'ADM4');
INSERT INTO `sepaisdb`.`alunos` (`nome`, `foto_path`, `turma_turma`) VALUES ('Paulo', 'nenhum', 'INFO1');

-- inserir motivos
INSERT INTO `sepaisdb`.`motivos` (`motivos`) VALUES ('Luto');
INSERT INTO `sepaisdb`.`motivos` (`motivos`) VALUES ('Médico');
INSERT INTO `sepaisdb`.`motivos` (`motivos`) VALUES ('Transporte');
INSERT INTO `sepaisdb`.`motivos` (`motivos`) VALUES ('Mal-estar');
INSERT INTO `sepaisdb`.`motivos` (`motivos`) VALUES ('Motivo particular');
INSERT INTO `sepaisdb`.`motivos` (`motivos`) VALUES ('Professor faltou');

-- inserir sepae
INSERT INTO `sepaisdb`.`sepae` (`username`, `nome`, `email_institucional`, `senha`, `foto_path`) VALUES ('Neras', 'Nereu Filho', 'nereu.filho@ifpr.edu.br', '$hash', 'nenhum');
INSERT INTO `sepaisdb`.`sepae` (`username`, `nome`, `email_institucional`, `senha`, `foto_path`) VALUES ('Chicão', 'Francisco Fernando Kühn', 'francisco.kuhn@ifpr.edu.br', '$hash', 'nenhum');

-- inserir recados
INSERT INTO `sepaisdb`.`recados` (`titulo`, `recado`, `data`, `validade`, `sepae_username`) VALUES ('Reunião do Pais', 'A reunião dos pais vai acontecer nesta sexta-feira', '2023-10-05', '2023-10-14', 'Neras');
INSERT INTO `sepaisdb`.`recados` (`titulo`, `recado`, `data`, `validade`, `sepae_username`) VALUES ('Semana Científica', 'A semana científica ira acontecer dos dias 11/10 a 13/10. Se divirta!', '2023-10-6', '2023-10-14', 'Chicão');

-- inserir responsaveis
INSERT INTO `sepaisdb`.`responsavel` (`email`, `nome`, `senha`, `cpf`) VALUES ('jailson.mendes@gmail.com', 'Jailson Mendes', '$hash', '12345678912');
INSERT INTO `sepaisdb`.`responsavel` (`email`, `nome`, `senha`, `cpf`) VALUES ('rafael.greca@gmail.com', 'Rafael Greca', '$hash', '12345678912');

-- inserir responsavel_libera_alunos
INSERT INTO `sepaisdb`.`responsavel_libera_alunos` (`responsavel_email`, `alunos_id`, `data`, `motivos_motivos`) VALUES ('jailson.mendes@gmail.com', '2', '2023-10-11', 'Luto');
INSERT INTO `sepaisdb`.`responsavel_libera_alunos` (`responsavel_email`, `alunos_id`, `data`, `motivos_motivos`) VALUES ('rafael.greca@gmail.com', '4', '2023-10-06', 'Transporte');

-- inserir sepae_libera_alunos
INSERT INTO `sepaisdb`.`sepae_libera_alunos` (`sepae_username`, `alunos_id`, `data`, `motivos_motivos`) VALUES ('Chicão', '2', '2023-10-11', 'Professor faltou');
INSERT INTO `sepaisdb`.`sepae_libera_alunos` (`sepae_username`, `alunos_id`, `data`, `motivos_motivos`) VALUES ('Neras', '1', '2023-10-06', 'Professor faltou');
