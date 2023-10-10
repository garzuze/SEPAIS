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
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_turma`) VALUES ('Mateus', 'nenhum', 'ADM1');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_turma`) VALUES ('Mariana', 'nenhum', 'ADM4');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_turma`) VALUES ('Paulo', 'nenhum', 'INFO1');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_turma`) VALUES ('Luan', 'nenhum', 'INFO2');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_turma`) VALUES ('Mario', 'nenhum', 'ADM2');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_turma`) VALUES ('Luigi', 'nenhum', 'ADM2');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_turma`) VALUES ('Wario', 'nenhum', 'ADM3');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_turma`) VALUES ('Waluigi', 'nenhum', 'INFO3');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_turma`) VALUES ('Waluigi', 'nenhum', 'INFO3');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_turma`) VALUES ('Sonic', 'nenhum', 'INFO4');

-- inserir motivo
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Luto');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Médico');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Transporte');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Mal-estar');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Motivo particular');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Professor faltou');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Aula acabou mais cedo');

-- inserir sepae
INSERT INTO `sepaisdb`.`sepae` (`username`, `nome`, `email_institucional`, `senha`, `foto_path`) VALUES ('Neras', 'Nereu Filho', 'nereu.filho@ifpr.edu.br', '$hash', 'nenhum');
INSERT INTO `sepaisdb`.`sepae` (`username`, `nome`, `email_institucional`, `senha`, `foto_path`) VALUES ('Chicão', 'Francisco Fernando Kühn', 'francisco.kuhn@ifpr.edu.br', '$hash', 'nenhum');
INSERT INTO `sepaisdb`.`sepae` (`username`, `nome`, `email_institucional`, `senha`, `foto_path`) VALUES ('Tati', 'Tatiana Mayumi Niwa', 'tatiana.niwa@ifpr.edu.br', '$hash', 'nenhum');

-- inserir recado
INSERT INTO `sepaisdb`.`recado` (`titulo`, `recado`, `data`, `validade`, `sepae_username`) VALUES ('Reunião do Pais', 'A reunião dos pais vai acontecer nesta sexta-feira', '2023-10-05', '2023-10-14', 'Neras');
INSERT INTO `sepaisdb`.`recado` (`titulo`, `recado`, `data`, `validade`, `sepae_username`) VALUES ('Semana Científica', 'A semana científica ira acontecer dos dias 11/10 a 13/10. Se divirta!', '2023-10-6', '2023-10-14', 'Chicão');
INSERT INTO `sepaisdb`.`recado` (`titulo`, `recado`, `data`, `sepae_username`) VALUES ('Boas Vindas', 'Boas vindas ao Instituto Federal', '2023-02-15', 'Neras');
INSERT INTO `sepaisdb`.`recado` (`titulo`, `recado`, `data`, `validade`, `sepae_username`) VALUES ('Rematrícula', 'Realize a rematrícula o quanto antes', '2023-02-15', '2023-03-01', 'Chicão');
INSERT INTO `sepaisdb`.`recado` (`titulo`, `recado`, `data`, `validade`, `sepae_username`) VALUES ('Processo Seletivo – Curso de Especialização em Estudos da Linguagem', 'Informações importantes: Inscrição: de 04 até 24 de outubro – online por meio de formulário eletrônico; Custo: gratuito – sem taxa de inscrição ou cobrança de mensalidades. Duração do Curso: 12 meses, com início no 1º semestre de 2024; Oferta: 30 vagas; Modalidade: semipresencial, com aulas nas segundas e quartas-feiras, das 18:30 às 22:30 no Campus Pinhais do IFPR.', '2023-10-09', '2023-10-25', 'Tati');

-- inserir responsaveis
INSERT INTO `sepaisdb`.`responsavel` (`email`, `nome`, `senha`, `cpf`) VALUES ('eggman.robotnik@gmail.com', 'Dr. Eggman', '$hash', '12345678912');
INSERT INTO `sepaisdb`.`responsavel` (`email`, `nome`, `senha`, `cpf`) VALUES ('king.boo@gmail.com', 'King Boo', '$hash', '123456789123');
INSERT INTO `sepaisdb`.`responsavel` (`email`, `nome`, `senha`, `cpf`) VALUES ('kratos@gmail.com', 'Bom de Guerra', '$hash', '123456789124');
INSERT INTO `sepaisdb`.`responsavel` (`email`, `nome`, `senha`, `cpf`) VALUES ('francesco.bernoulli@gmail.com', 'Francesco Bernoulli', '$hash', '123456789125');
INSERT INTO `sepaisdb`.`responsavel` (`email`, `nome`, `senha`, `cpf`) VALUES ('neymar.junior@gmail.com', 'Neymar Jr.', '$hash', '123456789123');

-- inserir responsavel_libera_aluno
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('eggman.robotnik@gmail.com', '2', '2023-10-10', 'Luto');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('king.boo@gmail.com', '4', '2023-10-10', 'Transporte');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('kratos@gmail.com', '1', '2023-10-10', 'Médico');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('francesco.bernoulli@gmail.com', '5', '2023-10-05', 'Motivo particular');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('neymar.junior@gmail.com', '3', '2023-10-10', 'Mal-estar');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('eggman.robotnik@gmail.com', '8', '2023-10-11', 'Mal-estar');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('king.boo@gmail.com', '9', '2023-10-11', 'Médico');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('kratos@gmail.com', '7', '2023-10-11', 'Transporte');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('francesco.bernoulli@gmail.com', '6', '2023-10-11', 'Luto');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('neymar.junior@gmail.com', '10', '2023-10-11', 'Mal-estar');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('eggman.robotnik@gmail.com', '2', '2023-10-12', 'Motivo particular');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('king.boo@gmail.com', '4', '2023-10-12', 'Médico');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('kratos@gmail.com', '1', '2023-10-12', 'Motivo particular');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('francesco.bernoulli@gmail.com', '5', '2023-10-12', 'Transporte');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('neymar.junior@gmail.com', '3', '2023-10-12', 'Mal-estar');

-- inserir sepae_libera_aluno
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('Chicão', '2', '2023-10-11', 'Professor faltou');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('Neras', '1', '2023-10-10', 'Professor faltou');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('Neras', '3', '2023-10-10', 'Professor faltou');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`, `horario_saida`) VALUES ('Chicão', '4', '2023-10-10', 'Professor faltou', '0');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('Chicão', '5', '2023-10-10', 'Professor faltou');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('Tati', '6', '2023-10-11', 'Aula acabou mais cedo');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('Tati', '7', '2023-10-11', 'Professor faltou');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('Neras', '8', '2023-10-11', 'Professor faltou');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`, `horario_saida`) VALUES ('Chicão', '9', '2023-10-11', 'Aula acabou mais cedo', '0');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('Neras', '10', '2023-10-18', 'Professor faltou');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('Chicão', '4', '2023-10-18', 'Aula acabou mais cedo');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('Neras', '7', '2023-10-18', 'Professor faltou');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('Neras', '6', '2023-10-18', 'Professor faltou');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`, `horario_saida`) VALUES ('Chicão', '5', '2023-10-18', 'Professor faltou', '0');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_motivo`) VALUES ('Chicão', '5', '2023-10-18', 'Aula acabou mais cedo');

-- inserir sepae_libera_aluno
INSERT INTO `sepaisdb`.`responsavel_has_aluno` (`responsavel_email`, `aluno_id`) VALUES ('king.boo@gmail.com', '4');
INSERT INTO `sepaisdb`.`responsavel_has_aluno` (`responsavel_email`, `aluno_id`) VALUES ('king.boo@gmail.com', '9');
INSERT INTO `sepaisdb`.`responsavel_has_aluno` (`responsavel_email`, `aluno_id`) VALUES ('eggman.robotnik@gmail.com', '8');
INSERT INTO `sepaisdb`.`responsavel_has_aluno` (`responsavel_email`, `aluno_id`) VALUES ('eggman.robotnik@gmail.com', '2');
INSERT INTO `sepaisdb`.`responsavel_has_aluno` (`responsavel_email`, `aluno_id`) VALUES ('kratos@gmail.com', '1');
INSERT INTO `sepaisdb`.`responsavel_has_aluno` (`responsavel_email`, `aluno_id`) VALUES ('kratos@gmail.com', '7');
INSERT INTO `sepaisdb`.`responsavel_has_aluno` (`responsavel_email`, `aluno_id`) VALUES ('francesco.bernoulli@gmail.com', '5');
INSERT INTO `sepaisdb`.`responsavel_has_aluno` (`responsavel_email`, `aluno_id`) VALUES ('francesco.bernoulli@gmail.com', '6');
INSERT INTO `sepaisdb`.`responsavel_has_aluno` (`responsavel_email`, `aluno_id`) VALUES ('neymar.junior@gmail.com', '3');
INSERT INTO `sepaisdb`.`responsavel_has_aluno` (`responsavel_email`, `aluno_id`) VALUES ('neymar.junior@gmail.com', '10');
