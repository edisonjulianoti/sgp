CREATE TABLE agendamento( 
      id  INT IDENTITY    NOT NULL  , 
      titulo varchar  (200)   NOT NULL  , 
      descricao nvarchar(max)   NOT NULL  , 
      data_inicio datetime2   NOT NULL  , 
      data_fim datetime2   NOT NULL  , 
      relevancia_id int   NOT NULL  , 
      agenda_id int   , 
      recorrencia_id int   NOT NULL  , 
      limite_recorrencia date   , 
      plano_id int   , 
      tipo_id int   , 
      considera_final_semana_id int   , 
      dias_personalizado int   , 
      lembrete_agenda_id int   , 
      system_users_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE categoria( 
      id  INT IDENTITY    NOT NULL  , 
      created_at datetime2   , 
      updated_at datetime2   , 
      descricao varchar  (200)   NOT NULL  , 
      tipo_categoria_id int   NOT NULL  , 
      totaliza_receita_despesa_id int   NOT NULL  , 
      system_users_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE considera_final_semana( 
      id  INT IDENTITY    NOT NULL  , 
      descricao varchar  (200)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE conta( 
      id  INT IDENTITY    NOT NULL  , 
      tipo_conta_id int   NOT NULL  , 
      descricao varchar  (200)   NOT NULL  , 
      banco varchar  (200)   , 
      data_saldo_inicial date   NOT NULL  , 
      saldo_inicial float   NOT NULL  , 
      saldo_atual float   NOT NULL  , 
      system_users_id int   NOT NULL  , 
      updated_at datetime2   , 
      created_at datetime2   , 
      saldo_calculado_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE lancamento( 
      id  INT IDENTITY    NOT NULL  , 
      descricao varchar  (200)   NOT NULL  , 
      vencimento date   NOT NULL  , 
      pagamento date   , 
      valor float   NOT NULL  , 
      categoria_id int   NOT NULL  , 
      conta_id int   NOT NULL  , 
      status_lancamento_id int   NOT NULL  , 
      system_users_id int   NOT NULL  , 
      updated_at datetime2   , 
      created_at datetime2   , 
      tipo_lancamento_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE lembrete_agenda( 
      id  INT IDENTITY    NOT NULL  , 
      minutos int   , 
      descricao nvarchar(max)   , 
      mensagem nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE plano( 
      id  INT IDENTITY    NOT NULL  , 
      titulo varchar  (200)   , 
      descricao nvarchar(max)   NOT NULL  , 
      previsao date   NOT NULL  , 
      created_at datetime2   NOT NULL  , 
      updated_at datetime2   , 
      system_users_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE recorrencia( 
      id  INT IDENTITY    NOT NULL  , 
      descricao char  (200)   NOT NULL  , 
      qtd_dia int   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE relevancia( 
      id  INT IDENTITY    NOT NULL  , 
      descricao varchar  (200)   NOT NULL  , 
      cor varchar  (200)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE saldo_calculado( 
      id  INT IDENTITY    NOT NULL  , 
      descricao varchar  (5)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status_lancamento( 
      id  INT IDENTITY    NOT NULL  , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status_tarefa( 
      id  INT IDENTITY    NOT NULL  , 
      descricao varchar  (200)   NOT NULL  , 
      cor nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      uuid varchar  (36)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)   NOT NULL  , 
      preference nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      controller nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      connection_name nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      login nvarchar(max)   NOT NULL  , 
      password nvarchar(max)   NOT NULL  , 
      email nvarchar(max)   , 
      frontpage_id int   , 
      system_unit_id int   , 
      active char  (1)   , 
      accepted_term_policy_at nvarchar(max)   , 
      accepted_term_policy char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tarefa( 
      id int   NOT NULL  , 
      descricao varchar  (200)   NOT NULL  , 
      detalhe nvarchar(max)   , 
      conclusao date   , 
      plano_id int   , 
      status_tarefa_id int   NOT NULL  , 
      relevancia_id int   NOT NULL  , 
      created_at datetime2   NOT NULL  , 
      update_at datetime2   , 
      tipo_id int   NOT NULL  , 
      system_users_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo( 
      id  INT IDENTITY    NOT NULL  , 
      descricao varchar  (200)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_categoria( 
      id  INT IDENTITY    NOT NULL  , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_conta( 
      id  INT IDENTITY    NOT NULL  , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_lancamento( 
      id  INT IDENTITY    NOT NULL  , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE totaliza_receita_despesa( 
      id  INT IDENTITY    NOT NULL  , 
      descricao varchar  (20)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE transacao( 
      id  INT IDENTITY    NOT NULL  , 
      created_at datetime2   , 
      updated_at datetime2   , 
      data_transacao date   NOT NULL  , 
      conta_id int   NOT NULL  , 
      saldo_anterior float   NOT NULL  , 
      valor float   NOT NULL  , 
      saldo_final float   , 
      lancamento_id int   NOT NULL  , 
      system_users_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

 
  
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
