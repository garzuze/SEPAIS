-- inserir turmas
INSERT INTO `mydb`.`turma` (`turma`) VALUES ('ADM1');
INSERT INTO `mydb`.`turma` (`turma`) VALUES ('ADM2');
INSERT INTO `mydb`.`turma` (`turma`) VALUES ('ADM3');
INSERT INTO `mydb`.`turma` (`turma`) VALUES ('ADM4');
INSERT INTO `mydb`.`turma` (`turma`) VALUES ('INFO1');
INSERT INTO `mydb`.`turma` (`turma`) VALUES ('INFO2');
INSERT INTO `mydb`.`turma` (`turma`) VALUES ('INFO3');
INSERT INTO `mydb`.`turma` (`turma`) VALUES ('INFO4');

-- inserir alunos
INSERT INTO `mydb`.`alunos` (`nome`, `foto_path`, `turma_turma`) VALUES ('Lucas', 'nenhum', 'INFO3');
INSERT INTO `mydb`.`alunos` (`nome`, `foto_path`, `turma_turma`) VALUES ('Pietro', 'vazio', 'INFO3');
INSERT INTO `mydb`.`alunos` (`nome`, `foto_path`, `turma_turma`) VALUES ('Victor', 'nenhum', 'INFO3');
INSERT INTO `mydb`.`alunos` (`nome`, `foto_path`, `turma_turma`) VALUES ('Mateus', 'nenhum', 'ADM1');
INSERT INTO `mydb`.`alunos` (`nome`, `foto_path`, `turma_turma`) VALUES ('Mariana', 'nenhum', 'ADM4');
INSERT INTO `mydb`.`alunos` (`nome`, `foto_path`, `turma_turma`) VALUES ('Paulo', 'nenhum', 'INFO1');

-- inserir motivos
INSERT INTO `mydb`.`motivos` (`motivos`) VALUES ('Luto');
INSERT INTO `mydb`.`motivos` (`motivos`) VALUES ('Médico');
INSERT INTO `mydb`.`motivos` (`motivos`) VALUES ('Transporte');
INSERT INTO `mydb`.`motivos` (`motivos`) VALUES ('Mal-estar');
INSERT INTO `mydb`.`motivos` (`motivos`) VALUES ('Motivo particular');

-- inserir sepae
INSERT INTO `mydb`.`sepae` (`username`, `nome`, `email_institucional`, `senha`, `foto_path`) VALUES ('Neras', 'Nereu Filho', 'nereu.filho@ifpr.edu.br', '$hash', 'nenhum');
INSERT INTO `mydb`.`sepae` (`username`, `nome`, `email_institucional`, `senha`, `foto_path`) VALUES ('Chicão', 'Francisco Fernando Kühn', 'francisco.kuhn@ifpr.edu.br', '$hash', 'nenhum');

-- inserir recados
INSERT INTO `mydb`.`recados` (`titulo`, `recado`, `data`, `validade`, `sepae_username`) VALUES ('Reunião do Pais', 'A reunião dos pais vai acontecer nesta sexta-feira', '2023-10-05', '2023-10-14', 'Neras');
INSERT INTO `mydb`.`recados` (`titulo`, `recado`, `data`, `validade`, `sepae_username`) VALUES ('Semana Científica', 'A semana científica ira acontecer dos dias 11/10 a 13/10. Se divirta!', '2023-10-6', '2023-10-14', 'Chicão');

-- inserir responsaveis
INSERT INTO `mydb`.`responsavel` (`email`, `nome`, `senha`, `cpf`) VALUES ('jailson.mendes@gmail.com', 'Jailson Mendes', '$hash', '12345678912');
INSERT INTO `mydb`.`responsavel` (`email`, `nome`, `senha`, `cpf`) VALUES ('rafael.greca@gmail.com', 'Rafael Greca', '$hash', '12345678912');

-- inserir responsavel_libera_alunos
INSERT INTO `mydb`.`responsavel_libera_alunos` (`responsavel_email`, `alunos_id`, `data`, `motivos_motivos`) VALUES ('jailson.mendes@gmail.com', '8', '2023-10-11', 'Luto');
INSERT INTO `mydb`.`responsavel_libera_alunos` (`responsavel_email`, `alunos_id`, `data`, `motivos_motivos`) VALUES ('rafael.greca@gmail.com', '10', '2023-10-06', 'Transporte');

-- inserir sepae_libera_alunos
INSERT INTO `mydb`.`sepae_libera_alunos` (`sepae_username`, `alunos_id`, `data`, `motivos_motivos`) VALUES ('Chicão', '8', '2023-10-11', 'Professor faltou');
INSERT INTO `mydb`.`sepae_libera_alunos` (`sepae_username`, `alunos_id`, `data`, `motivos_motivos`) VALUES ('Neras', '7', '2023-10-06', 'Professor faltou');