CREATE TABLE agendamento( 
      id  integer generated by default as identity     NOT NULL , 
      titulo varchar  (200)    NOT NULL , 
      descricao blob sub_type 1    NOT NULL , 
      data_inicio timestamp    NOT NULL , 
      data_fim timestamp    NOT NULL , 
      relevancia_id integer    NOT NULL , 
      agenda_id integer   , 
      recorrencia_id integer    NOT NULL , 
      limite_recorrencia date   , 
      plano_id integer   , 
      tipo_id integer   , 
      considera_final_semana_id integer   , 
      dias_personalizado integer   , 
      lembrete_agenda_id integer   , 
      system_users_id integer    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE categoria( 
      id  integer generated by default as identity     NOT NULL , 
      created_at timestamp   , 
      updated_at timestamp   , 
      descricao varchar  (200)    NOT NULL , 
      tipo_categoria_id integer    NOT NULL , 
      totaliza_receita_despesa_id integer    NOT NULL , 
      system_users_id integer    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE considera_final_semana( 
      id  integer generated by default as identity     NOT NULL , 
      descricao varchar  (200)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE conta( 
      id  integer generated by default as identity     NOT NULL , 
      tipo_conta_id integer    NOT NULL , 
      descricao varchar  (200)    NOT NULL , 
      banco varchar  (200)   , 
      data_saldo_inicial date    NOT NULL , 
      saldo_inicial float    NOT NULL , 
      saldo_atual float    NOT NULL , 
      system_users_id integer    NOT NULL , 
      updated_at timestamp   , 
      created_at timestamp   , 
      saldo_calculado_id integer    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE lancamento( 
      id  integer generated by default as identity     NOT NULL , 
      descricao varchar  (200)    NOT NULL , 
      vencimento date    NOT NULL , 
      pagamento date   , 
      valor float    NOT NULL , 
      categoria_id integer    NOT NULL , 
      conta_id integer    NOT NULL , 
      status_lancamento_id integer    NOT NULL , 
      system_users_id integer    NOT NULL , 
      updated_at timestamp   , 
      created_at timestamp   , 
      tipo_lancamento_id integer    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE lembrete_agenda( 
      id  integer generated by default as identity     NOT NULL , 
      minutos integer   , 
      descricao blob sub_type 1   , 
      mensagem blob sub_type 1   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE plano( 
      id  integer generated by default as identity     NOT NULL , 
      titulo varchar  (200)   , 
      descricao blob sub_type 1    NOT NULL , 
      previsao date    NOT NULL , 
      created_at timestamp    NOT NULL , 
      updated_at timestamp   , 
      system_users_id integer    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE recorrencia( 
      id  integer generated by default as identity     NOT NULL , 
      descricao char  (200)    NOT NULL , 
      qtd_dia integer   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE relevancia( 
      id  integer generated by default as identity     NOT NULL , 
      descricao varchar  (200)    NOT NULL , 
      cor varchar  (200)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE saldo_calculado( 
      id  integer generated by default as identity     NOT NULL , 
      descricao varchar  (5)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status_lancamento( 
      id  integer generated by default as identity     NOT NULL , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status_tarefa( 
      id  integer generated by default as identity     NOT NULL , 
      descricao varchar  (200)    NOT NULL , 
      cor blob sub_type 1   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id integer    NOT NULL , 
      name blob sub_type 1    NOT NULL , 
      uuid varchar  (36)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id integer    NOT NULL , 
      system_group_id integer    NOT NULL , 
      system_program_id integer    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)    NOT NULL , 
      preference blob sub_type 1   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id integer    NOT NULL , 
      name blob sub_type 1    NOT NULL , 
      controller blob sub_type 1    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id integer    NOT NULL , 
      name blob sub_type 1    NOT NULL , 
      connection_name blob sub_type 1   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id integer    NOT NULL , 
      system_user_id integer    NOT NULL , 
      system_group_id integer    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id integer    NOT NULL , 
      system_user_id integer    NOT NULL , 
      system_program_id integer    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id integer    NOT NULL , 
      name blob sub_type 1    NOT NULL , 
      login blob sub_type 1    NOT NULL , 
      password blob sub_type 1    NOT NULL , 
      email blob sub_type 1   , 
      frontpage_id integer   , 
      system_unit_id integer   , 
      active char  (1)   , 
      accepted_term_policy_at blob sub_type 1   , 
      accepted_term_policy char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id integer    NOT NULL , 
      system_user_id integer    NOT NULL , 
      system_unit_id integer    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tarefa( 
      id integer    NOT NULL , 
      descricao varchar  (200)    NOT NULL , 
      detalhe blob sub_type 1   , 
      conclusao date   , 
      plano_id integer   , 
      status_tarefa_id integer    NOT NULL , 
      relevancia_id integer    NOT NULL , 
      created_at timestamp    NOT NULL , 
      update_at timestamp   , 
      tipo_id integer    NOT NULL , 
      system_users_id integer    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo( 
      id  integer generated by default as identity     NOT NULL , 
      descricao varchar  (200)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_categoria( 
      id  integer generated by default as identity     NOT NULL , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_conta( 
      id  integer generated by default as identity     NOT NULL , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_lancamento( 
      id  integer generated by default as identity     NOT NULL , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE totaliza_receita_despesa( 
      id  integer generated by default as identity     NOT NULL , 
      descricao varchar  (20)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE transacao( 
      id  integer generated by default as identity     NOT NULL , 
      created_at timestamp   , 
      updated_at timestamp   , 
      data_transacao date    NOT NULL , 
      conta_id integer    NOT NULL , 
      saldo_anterior float    NOT NULL , 
      valor float    NOT NULL , 
      saldo_final float   , 
      lancamento_id integer    NOT NULL , 
      system_users_id integer    NOT NULL , 
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