-- inserir turmas
INSERT INTO `sepaisdb`.`turma` (`turma`) VALUES ('ADM1');
INSERT INTO `sepaisdb`.`turma` (`turma`) VALUES ('ADM2');
INSERT INTO `sepaisdb`.`turma` (`turma`) VALUES ('ADM3');
INSERT INTO `sepaisdb`.`turma` (`turma`) VALUES ('ADM4');
INSERT INTO `sepaisdb`.`turma` (`turma`) VALUES ('INFO1');
INSERT INTO `sepaisdb`.`turma` (`turma`) VALUES ('INFO2');
INSERT INTO `sepaisdb`.`turma` (`turma`) VALUES ('INFO3');
INSERT INTO `sepaisdb`.`turma` (`turma`) VALUES ('INFO4');

-- inserir aluno
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_turma`) VALUES ('Lucas', 'nenhum', 'INFO3');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_turma`) VALUES ('Pietro', 'vazio', 'INFO3');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_turma`) VALUES ('Victor', 'nenhum', 'INFO3');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_turma`) VALUES ('Mateus', 'nenhum', 'ADM1');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_turma`) VALUES ('Mariana', 'nenhum', 'ADM4');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_turma`) VALUES ('Paulo', 'nenhum', 'INFO1');

-- inserir motivo
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Luto');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Médico');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Transporte');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Mal-estar');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Motivo particular');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Professor faltou');

-- inserir sepae
INSERT INTO `sepaisdb`.`sepae` (`username`, `nome`, `email_institucional`, `senha`, `foto_path`) VALUES ('Neras', 'Nereu Filho', 'nereu.filho@ifpr.edu.br', '$hash', 'nenhum');
INSERT INTO `sepaisdb`.`sepae` (`username`, `nome`, `email_institucional`, `senha`, `foto_path`) VALUES ('Chicão', 'Francisco Fernando Kühn', 'francisco.kuhn@ifpr.edu.br', '$hash', 'nenhum');

-- inserir recado
INSERT INTO `sepaisdb`.`recado` (`titulo`, `recado`, `data`, `validade`, `sepae_username`) VALUES ('Reunião do Pais', 'A reunião dos pais vai acontecer nesta sexta-feira', '2023-10-05', '2023-10-14', 'Neras');
INSERT INTO `sepaisdb`.`recado` (`titulo`, `recado`, `data`, `validade`, `sepae_username`) VALUES ('Semana Científica', 'A semana científica ira acontecer dos dias 11/10 a 13/10. Se divirta!', '2023-10-6', '2023-10-14', 'Chicão');
INSERT INTO `sepaisdb`.`recado` (`id`, `titulo`, `recado`, `data`, `sepae_username`) VALUES ('3', 'Boas Vindas', 'Boas vindas ao Instituto Federal', '2023-02-15', 'Neras');
INSERT INTO `sepaisdb`.`recado` (`titulo`, `recado`, `data`, `validade`, `sepae_username`) VALUES ('Rematrícula', 'Realize a rematrícula o quanto antes', '2023-02-15', '2023-03-01', 'Chicão');

-- inserir responsaveis
INSERT INTO `sepaisdb`.`responsavel` (`email`, `nome`, `senha`, `cpf`) VALUES ('jailson.mendes@gmail.com', 'Jailson Mendes', '$hash', '12345678912');
INSERT INTO `sepaisdb`.`responsavel` (`email`, `nome`, `senha`, `cpf`) VALUES ('rafael.greca@gmail.com', 'Rafael Greca', '$hash', '12345678912');

-- inserir responsavel_libera_aluno
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('jailson.mendes@gmail.com', '2', '2023-10-11', 'Luto');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('rafael.greca@gmail.com', '4', '2023-10-06', 'Transporte');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('jailson.mendes@gmail.com', '1', '2023-10-05', 'Médico');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('rafael.greca@gmail.com', '5', '2023-10-05', 'Motivo particular');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('rafael.greca@gmail.com', '3', '2023-10-06', 'Mal-estar');

-- inserir sepae_libera_aluno
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('Chicão', '2', '2023-10-11', 'Professor faltou');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('Neras', '1', '2023-10-06', 'Professor faltou');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('Neras', '3', '2023-10-05', 'Professor faltou');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`, `horario_saida`) VALUES ('Chicão', '4', '2023-10-05', 'Professor faltou', '0');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('Chicão', '5', '2023-10-05', 'Professor faltou');

