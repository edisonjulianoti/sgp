CREATE TABLE agendamento( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `titulo` varchar  (200)   NOT NULL  , 
      `descricao` text   NOT NULL  , 
      `data_inicio` datetime   NOT NULL  , 
      `data_fim` datetime   NOT NULL  , 
      `relevancia_id` int   NOT NULL  , 
      `agenda_id` int   , 
      `recorrencia_id` int   NOT NULL  , 
      `limite_recorrencia` date   , 
      `plano_id` int   , 
      `tipo_id` int   , 
      `considera_final_semana_id` int   , 
      `dias_personalizado` int   , 
      `lembrete_agenda_id` int   , 
      `system_users_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE categoria( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `created_at` datetime   , 
      `updated_at` datetime   , 
      `descricao` varchar  (200)   NOT NULL  , 
      `tipo_categoria_id` int   NOT NULL  , 
      `totaliza_receita_despesa_id` int   NOT NULL  , 
      `system_users_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE considera_final_semana( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `descricao` varchar  (200)   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE conta( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `tipo_conta_id` int   NOT NULL  , 
      `descricao` varchar  (200)   NOT NULL  , 
      `banco` varchar  (200)   , 
      `data_saldo_inicial` date   NOT NULL  , 
      `saldo_inicial` double   NOT NULL  , 
      `saldo_atual` double   NOT NULL  , 
      `system_users_id` int   NOT NULL  , 
      `updated_at` datetime   , 
      `created_at` datetime   , 
      `saldo_calculado_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE lancamento( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `descricao` varchar  (200)   NOT NULL  , 
      `vencimento` date   NOT NULL  , 
      `pagamento` date   , 
      `valor` double   NOT NULL  , 
      `categoria_id` int   NOT NULL  , 
      `conta_id` int   NOT NULL  , 
      `status_lancamento_id` int   NOT NULL  , 
      `system_users_id` int   NOT NULL  , 
      `updated_at` datetime   , 
      `created_at` datetime   , 
      `tipo_lancamento_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE lembrete_agenda( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `minutos` int   , 
      `descricao` text   , 
      `mensagem` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE plano( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `titulo` varchar  (200)   , 
      `descricao` text   NOT NULL  , 
      `previsao` date   NOT NULL  , 
      `created_at` datetime   NOT NULL  , 
      `updated_at` datetime   , 
      `system_users_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE recorrencia( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `descricao` char  (200)   NOT NULL  , 
      `qtd_dia` int   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE relevancia( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `descricao` varchar  (200)   NOT NULL  , 
      `cor` varchar  (200)   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE saldo_calculado( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `descricao` varchar  (5)   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE status_lancamento( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `descricao` varchar  (200)   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE status_tarefa( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `descricao` varchar  (200)   NOT NULL  , 
      `cor` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_group( 
      `id` int   NOT NULL  , 
      `name` text   NOT NULL  , 
      `uuid` varchar  (36)   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_group_program( 
      `id` int   NOT NULL  , 
      `system_group_id` int   NOT NULL  , 
      `system_program_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_preference( 
      `id` varchar  (255)   NOT NULL  , 
      `preference` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_program( 
      `id` int   NOT NULL  , 
      `name` text   NOT NULL  , 
      `controller` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_unit( 
      `id` int   NOT NULL  , 
      `name` text   NOT NULL  , 
      `connection_name` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_user_group( 
      `id` int   NOT NULL  , 
      `system_user_id` int   NOT NULL  , 
      `system_group_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_user_program( 
      `id` int   NOT NULL  , 
      `system_user_id` int   NOT NULL  , 
      `system_program_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_users( 
      `id` int   NOT NULL  , 
      `name` text   NOT NULL  , 
      `login` text   NOT NULL  , 
      `password` text   NOT NULL  , 
      `email` text   , 
      `frontpage_id` int   , 
      `system_unit_id` int   , 
      `active` char  (1)   , 
      `accepted_term_policy_at` text   , 
      `accepted_term_policy` char  (1)   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE system_user_unit( 
      `id` int   NOT NULL  , 
      `system_user_id` int   NOT NULL  , 
      `system_unit_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE tarefa( 
      `id` int   NOT NULL  , 
      `descricao` varchar  (200)   NOT NULL  , 
      `detalhe` text   , 
      `conclusao` date   , 
      `plano_id` int   , 
      `status_tarefa_id` int   NOT NULL  , 
      `relevancia_id` int   NOT NULL  , 
      `created_at` datetime   NOT NULL  , 
      `update_at` datetime   , 
      `tipo_id` int   NOT NULL  , 
      `system_users_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE tipo( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `descricao` varchar  (200)   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE tipo_categoria( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `descricao` varchar  (200)   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE tipo_conta( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `descricao` varchar  (200)   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE tipo_lancamento( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `descricao` varchar  (200)   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE totaliza_receita_despesa( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `descricao` varchar  (20)   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE transacao( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `created_at` datetime   , 
      `updated_at` datetime   , 
      `data_transacao` date   NOT NULL  , 
      `conta_id` int   NOT NULL  , 
      `saldo_anterior` double   NOT NULL  , 
      `valor` double   NOT NULL  , 
      `saldo_final` double   , 
      `lancamento_id` int   NOT NULL  , 
      `system_users_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

 
  
 ALTER TABLE agendamento ADD CONSTRAINT fk_agenda_1 FOREIGN KEY (relevancia_id) references relevancia(id); 
ALTER TABLE agendamento ADD CONSTRAINT fk_agenda_3 FOREIGN KEY (recorrencia_id) references recorrencia(id); 
ALTER TABLE agendamento ADD CONSTRAINT fk_agenda_4 FOREIGN KEY (plano_id) references plano(id); 
ALTER TABLE agendamento ADD CONSTRAINT fk_agenda_5 FOREIGN KEY (tipo_id) references tipo(id); 
ALTER TABLE agendamento ADD CONSTRAINT fk_agenda_6 FOREIGN KEY (considera_final_semana_id) references considera_final_semana(id); 
ALTER TABLE agendamento ADD CONSTRAINT fk_agenda_7 FOREIGN KEY (lembrete_agenda_id) references lembrete_agenda(id); 
ALTER TABLE agendamento ADD CONSTRAINT fk_agendamento_8 FOREIGN KEY (system_users_id) references system_users(id); 
ALTER TABLE categoria ADD CONSTRAINT fk_categoria_1 FOREIGN KEY (tipo_categoria_id) references tipo_categoria(id); 
ALTER TABLE categoria ADD CONSTRAINT fk_categoria_2 FOREIGN KEY (totaliza_receita_despesa_id) references totaliza_receita_despesa(id); 
ALTER TABLE categoria ADD CONSTRAINT fk_categoria_3 FOREIGN KEY (system_users_id) references system_users(id); 
ALTER TABLE conta ADD CONSTRAINT fk_conta_1 FOREIGN KEY (tipo_conta_id) references tipo_conta(id); 
ALTER TABLE conta ADD CONSTRAINT fk_conta_2 FOREIGN KEY (system_users_id) references system_users(id); 
ALTER TABLE conta ADD CONSTRAINT fk_conta_3 FOREIGN KEY (saldo_calculado_id) references saldo_calculado(id); 
ALTER TABLE lancamento ADD CONSTRAINT fk_lancamento_1 FOREIGN KEY (categoria_id) references categoria(id); 
ALTER TABLE lancamento ADD CONSTRAINT fk_lancamento_2 FOREIGN KEY (conta_id) references conta(id); 
ALTER TABLE lancamento ADD CONSTRAINT fk_lancamento_3 FOREIGN KEY (status_lancamento_id) references status_lancamento(id); 
ALTER TABLE lancamento ADD CONSTRAINT fk_lancamento_4 FOREIGN KEY (system_users_id) references system_users(id); 
ALTER TABLE lancamento ADD CONSTRAINT fk_lancamento_5 FOREIGN KEY (tipo_lancamento_id) references tipo_lancamento(id); 
ALTER TABLE plano ADD CONSTRAINT fk_plano_1 FOREIGN KEY (system_users_id) references system_users(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_1 FOREIGN KEY (system_program_id) references system_program(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_2 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_1 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_2 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_1 FOREIGN KEY (system_program_id) references system_program(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_2 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_1 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_2 FOREIGN KEY (frontpage_id) references system_program(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_2 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE tarefa ADD CONSTRAINT fk_tarefa_1 FOREIGN KEY (plano_id) references plano(id); 
ALTER TABLE tarefa ADD CONSTRAINT fk_tarefa_2 FOREIGN KEY (status_tarefa_id) references status_tarefa(id); 
ALTER TABLE tarefa ADD CONSTRAINT fk_tarefa_3 FOREIGN KEY (relevancia_id) references relevancia(id); 
ALTER TABLE tarefa ADD CONSTRAINT fk_tarefa_4 FOREIGN KEY (tipo_id) references tipo(id); 
ALTER TABLE tarefa ADD CONSTRAINT fk_tarefa_5 FOREIGN KEY (system_users_id) references system_users(id); 
ALTER TABLE transacao ADD CONSTRAINT fk_transacoes_2 FOREIGN KEY (conta_id) references conta(id); 
ALTER TABLE transacao ADD CONSTRAINT fk_transacoes_3 FOREIGN KEY (lancamento_id) references lancamento(id); 
ALTER TABLE transacao ADD CONSTRAINT fk_transacao_4 FOREIGN KEY (system_users_id) references system_users(id); 
 
 CREATE index idx_agendamento_relevancia_id on agendamento(relevancia_id); 
CREATE index idx_agendamento_recorrencia_id on agendamento(recorrencia_id); 
CREATE index idx_agendamento_plano_id on agendamento(plano_id); 
CREATE index idx_agendamento_tipo_id on agendamento(tipo_id); 
CREATE index idx_agendamento_considera_final_semana_id on agendamento(considera_final_semana_id); 
CREATE index idx_agendamento_lembrete_agenda_id on agendamento(lembrete_agenda_id); 
CREATE index idx_agendamento_system_users_id on agendamento(system_users_id); 
CREATE index idx_categoria_tipo_categoria_id on categoria(tipo_categoria_id); 
CREATE index idx_categoria_totaliza_receita_despesa_id on categoria(totaliza_receita_despesa_id); 
CREATE index idx_categoria_system_users_id on categoria(system_users_id); 
CREATE index idx_conta_tipo_conta_id on conta(tipo_conta_id); 
CREATE index idx_conta_system_users_id on conta(system_users_id); 
CREATE index idx_conta_saldo_calculado_id on conta(saldo_calculado_id); 
CREATE index idx_lancamento_categoria_id on lancamento(categoria_id); 
CREATE index idx_lancamento_conta_id on lancamento(conta_id); 
CREATE index idx_lancamento_status_lancamento_id on lancamento(status_lancamento_id); 
CREATE index idx_lancamento_system_users_id on lancamento(system_users_id); 
CREATE index idx_lancamento_tipo_lancamento_id on lancamento(tipo_lancamento_id); 
CREATE index idx_plano_system_users_id on plano(system_users_id); 
CREATE index idx_system_group_program_system_program_id on system_group_program(system_program_id); 
CREATE index idx_system_group_program_system_group_id on system_group_program(system_group_id); 
CREATE index idx_system_user_group_system_group_id on system_user_group(system_group_id); 
CREATE index idx_system_user_group_system_user_id on system_user_group(system_user_id); 
CREATE index idx_system_user_program_system_program_id on system_user_program(system_program_id); 
CREATE index idx_system_user_program_system_user_id on system_user_program(system_user_id); 
CREATE index idx_system_users_system_unit_id on system_users(system_unit_id); 
CREATE index idx_system_users_frontpage_id on system_users(frontpage_id); 
CREATE index idx_system_user_unit_system_user_id on system_user_unit(system_user_id); 
CREATE index idx_system_user_unit_system_unit_id on system_user_unit(system_unit_id); 
CREATE index idx_tarefa_plano_id on tarefa(plano_id); 
CREATE index idx_tarefa_status_tarefa_id on tarefa(status_tarefa_id); 
CREATE index idx_tarefa_relevancia_id on tarefa(relevancia_id); 
CREATE index idx_tarefa_tipo_id on tarefa(tipo_id); 
CREATE index idx_tarefa_system_users_id on tarefa(system_users_id); 
CREATE index idx_transacao_conta_id on transacao(conta_id); 
CREATE index idx_transacao_lancamento_id on transacao(lancamento_id); 
CREATE index idx_transacao_system_users_id on transacao(system_users_id); 