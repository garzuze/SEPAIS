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
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_id`) VALUES ('Mateus', 'nenhum', '1');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_id`) VALUES ('Mariana', 'nenhum', '4');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_id`) VALUES ('Paulo', 'nenhum', '5');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_id`) VALUES ('Luan', 'nenhum', '6');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_id`) VALUES ('Mario', 'nenhum', '2');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_id`) VALUES ('Luigi', 'nenhum', '2');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_id`) VALUES ('Wario', 'nenhum', '3');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_id`) VALUES ('Waluigi', 'nenhum', '7');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_id`) VALUES ('Waluigi', 'nenhum', '7');
INSERT INTO `sepaisdb`.`aluno` (`nome`, `foto_path`, `turma_id`) VALUES ('Sonic', 'nenhum', '8');

-- inserir motivo
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Luto');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Médico');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Transporte');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Mal-estar');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Motivo particular');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Professor faltou');
INSERT INTO `sepaisdb`.`motivo` (`motivo`) VALUES ('Aula acabou mais cedo');

-- inserir sepae
INSERT INTO `sepaisdb`.`sepae` (`username`, `nome`, `email`, `senha`, `foto_path`) VALUES ('Neras', 'Nereu Filho', 'nereu.filho@ifpr.edu.br', '$hash', 'nenhum');
INSERT INTO `sepaisdb`.`sepae` (`username`, `nome`, `email`, `senha`, `foto_path`) VALUES ('Chicão', 'Francisco Fernando Kühn', 'francisco.kuhn@ifpr.edu.br', '$hash', 'nenhum');
INSERT INTO `sepaisdb`.`sepae` (`username`, `nome`, `email`, `senha`, `foto_path`) VALUES ('Tati', 'Tatiana Mayumi Niwa', 'tatiana.niwa@ifpr.edu.br', '$hash', 'nenhum');

-- inserir recado
INSERT INTO `sepaisdb`.`recado` (`titulo`, `recado`, `data`, `validade`, `sepae_username`) VALUES ('Reunião do Pais', 'A reunião dos pais vai acontecer nesta sexta-feira', '2023-10-05', '2023-10-14', 'Neras');
INSERT INTO `sepaisdb`.`recado` (`titulo`, `recado`, `data`, `validade`, `sepae_username`) VALUES ('Semana Científica', 'A semana científica ira acontecer dos dias 11/10 a 13/10. Se divirta!', '2023-10-6', '2023-10-14', 'Chicão');
INSERT INTO `sepaisdb`.`recado` (`titulo`, `recado`, `data`, `sepae_username`) VALUES ('Boas Vindas', 'Boas vindas ao Instituto Federal', '2023-02-15', 'Neras');
INSERT INTO `sepaisdb`.`recado` (`titulo`, `recado`, `data`, `validade`, `sepae_username`) VALUES ('Rematrícula', 'Realize a rematrícula o quanto antes', '2023-02-15', '2023-03-01', 'Chicão');
INSERT INTO `sepaisdb`.`recado` (`titulo`, `recado`, `data`, `validade`, `sepae_username`) VALUES ('Processo Seletivo – Curso de Especialização em Estudos da Linguagem', 'Informações importantes: Inscrição: de 04 até 24 de outubro – online por meio de formulário eletrônico; Custo: gratuito – sem taxa de inscrição ou cobrança de mensalidades. Duração do Curso: 12 meses, com início no 1º semestre de 2024; Oferta: 30 vagas; Modalidade: semipresencial, com aulas nas segundas e quartas-feiras, das 18:30 às 22:30 no Campus Pinhais do IFPR.', '2023-10-09', '2023-10-25', 'Tati');

-- inserir responsaveis
INSERT INTO `sepaisdb`.`responsavel` (`email`, `nome`, `senha`, `cpf`) VALUES ('eggman.robotnik@gmail.com', 'Dr. Eggman', '$hash', '12345678912');
INSERT INTO `sepaisdb`.`responsavel` (`email`, `nome`, `senha`, `cpf`) VALUES ('king.boo@gmail.com', 'King Boo', '$hash', '12345678922');
INSERT INTO `sepaisdb`.`responsavel` (`email`, `nome`, `senha`, `cpf`) VALUES ('kratos@gmail.com', 'Bom de Guerra', '$hash', '12345678933');
INSERT INTO `sepaisdb`.`responsavel` (`email`, `nome`, `senha`, `cpf`) VALUES ('francesco.bernoulli@gmail.com', 'Francesco Bernoulli', '$hash', '12345678944');
INSERT INTO `sepaisdb`.`responsavel` (`email`, `nome`, `senha`, `cpf`) VALUES ('neymar.junior@gmail.com', 'Neymar Jr.', '$hash', '12345678955');

-- inserir responsavel_libera_aluno
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_id`) VALUES ('eggman.robotnik@gmail.com', '2', '2023-10-10', '1');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_id`) VALUES ('king.boo@gmail.com', '4', '2023-10-10', '3');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_id`) VALUES ('kratos@gmail.com', '1', '2023-10-10', '2');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_id`) VALUES ('francesco.bernoulli@gmail.com', '5', '2023-10-05', '5');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_id`) VALUES ('neymar.junior@gmail.com', '3', '2023-10-10', '4');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_id`) VALUES ('eggman.robotnik@gmail.com', '8', '2023-10-11', '4');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_id`) VALUES ('king.boo@gmail.com', '9', '2023-10-11', '2');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_id`) VALUES ('kratos@gmail.com', '7', '2023-10-11', '3');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_id`) VALUES ('francesco.bernoulli@gmail.com', '6', '2023-10-11', '1');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_id`) VALUES ('neymar.junior@gmail.com', '10', '2023-10-11', '4');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_id`) VALUES ('eggman.robotnik@gmail.com', '2', '2023-10-12', '5');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_id`) VALUES ('king.boo@gmail.com', '4', '2023-10-12', '2');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_id`) VALUES ('kratos@gmail.com', '1', '2023-10-12', '5');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_id`) VALUES ('francesco.bernoulli@gmail.com', '5', '2023-10-12', '3');
INSERT INTO `sepaisdb`.`responsavel_libera_aluno` (`responsavel_email`, `aluno_id`, `data`, `motivo_id`) VALUES ('neymar.junior@gmail.com', '3', '2023-10-12', '4');

-- inserir sepae_libera_aluno
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_id`) VALUES ('Chicão', '2', '2023-10-11', '6');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_id`) VALUES ('Neras', '1', '2023-10-10', '6');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_id`) VALUES ('Neras', '3', '2023-10-10', '6');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_id`, `horario_saida`) VALUES ('Chicão', '4', '2023-10-10', '6', '0');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_id`) VALUES ('Chicão', '5', '2023-10-10', '6');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_id`) VALUES ('Tati', '6', '2023-10-11', '7');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_id`) VALUES ('Tati', '7', '2023-10-11', '6');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_id`) VALUES ('Neras', '8', '2023-10-11', '6');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_id`, `horario_saida`) VALUES ('Chicão', '9', '2023-10-11', '7', '0');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_id`) VALUES ('Neras', '10', '2023-10-18', '6');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_id`) VALUES ('Chicão', '4', '2023-10-18', '7');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_id`) VALUES ('Neras', '7', '2023-10-18', '6');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_id`) VALUES ('Neras', '6', '2023-10-18', '6');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_id`, `horario_saida`) VALUES ('Chicão', '10', '2023-10-18', '6', '0');
INSERT INTO `sepaisdb`.`sepae_libera_aluno` (`sepae_username`, `aluno_id`, `data`, `motivo_id`) VALUES ('Chicão', '5', '2023-10-18', '7');

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