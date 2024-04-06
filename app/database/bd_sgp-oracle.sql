CREATE TABLE agendamento( 
      id number(10)    NOT NULL , 
      titulo varchar  (200)    NOT NULL , 
      descricao varchar(3000)    NOT NULL , 
      data_inicio timestamp(0)    NOT NULL , 
      data_fim timestamp(0)    NOT NULL , 
      relevancia_id number(10)    NOT NULL , 
      agenda_id number(10)   , 
      recorrencia_id number(10)    NOT NULL , 
      limite_recorrencia date   , 
      plano_id number(10)   , 
      tipo_id number(10)   , 
      considera_final_semana_id number(10)   , 
      dias_personalizado number(10)   , 
      lembrete_agenda_id number(10)   , 
      system_users_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE categoria( 
      id number(10)    NOT NULL , 
      created_at timestamp(0)   , 
      updated_at timestamp(0)   , 
      descricao varchar  (200)    NOT NULL , 
      tipo_categoria_id number(10)    NOT NULL , 
      totaliza_receita_despesa_id number(10)    NOT NULL , 
      system_users_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE considera_final_semana( 
      id number(10)    NOT NULL , 
      descricao varchar  (200)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE conta( 
      id number(10)    NOT NULL , 
      tipo_conta_id number(10)    NOT NULL , 
      descricao varchar  (200)    NOT NULL , 
      banco varchar  (200)   , 
      data_saldo_inicial date    NOT NULL , 
      saldo_inicial binary_double    NOT NULL , 
      saldo_atual binary_double    NOT NULL , 
      system_users_id number(10)    NOT NULL , 
      updated_at timestamp(0)   , 
      created_at timestamp(0)   , 
      saldo_calculado_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE lancamento( 
      id number(10)    NOT NULL , 
      descricao varchar  (200)    NOT NULL , 
      vencimento date    NOT NULL , 
      pagamento date   , 
      valor binary_double    NOT NULL , 
      categoria_id number(10)    NOT NULL , 
      conta_id number(10)    NOT NULL , 
      status_lancamento_id number(10)    NOT NULL , 
      system_users_id number(10)    NOT NULL , 
      updated_at timestamp(0)   , 
      created_at timestamp(0)   , 
      tipo_lancamento_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE lembrete_agenda( 
      id number(10)    NOT NULL , 
      minutos number(10)   , 
      descricao varchar(3000)   , 
      mensagem varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE plano( 
      id number(10)    NOT NULL , 
      titulo varchar  (200)   , 
      descricao varchar(3000)    NOT NULL , 
      previsao date    NOT NULL , 
      created_at timestamp(0)    NOT NULL , 
      updated_at timestamp(0)   , 
      system_users_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE recorrencia( 
      id number(10)    NOT NULL , 
      descricao char  (200)    NOT NULL , 
      qtd_dia number(10)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE relevancia( 
      id number(10)    NOT NULL , 
      descricao varchar  (200)    NOT NULL , 
      cor varchar  (200)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE saldo_calculado( 
      id number(10)    NOT NULL , 
      descricao varchar  (5)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status_lancamento( 
      id number(10)    NOT NULL , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status_tarefa( 
      id number(10)    NOT NULL , 
      descricao varchar  (200)    NOT NULL , 
      cor varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      uuid varchar  (36)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
      system_program_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)    NOT NULL , 
      preference varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      controller varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      connection_name varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_program_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      login varchar(3000)    NOT NULL , 
      password varchar(3000)    NOT NULL , 
      email varchar(3000)   , 
      frontpage_id number(10)   , 
      system_unit_id number(10)   , 
      active char  (1)   , 
      accepted_term_policy_at varchar(3000)   , 
      accepted_term_policy char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_unit_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tarefa( 
      id number(10)    NOT NULL , 
      descricao varchar  (200)    NOT NULL , 
      detalhe varchar(3000)   , 
      conclusao date   , 
      plano_id number(10)   , 
      status_tarefa_id number(10)    NOT NULL , 
      relevancia_id number(10)    NOT NULL , 
      created_at timestamp(0)    NOT NULL , 
      update_at timestamp(0)   , 
      tipo_id number(10)    NOT NULL , 
      system_users_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo( 
      id number(10)    NOT NULL , 
      descricao varchar  (200)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_categoria( 
      id number(10)    NOT NULL , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_conta( 
      id number(10)    NOT NULL , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_lancamento( 
      id number(10)    NOT NULL , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE totaliza_receita_despesa( 
      id number(10)    NOT NULL , 
      descricao varchar  (20)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE transacao( 
      id number(10)    NOT NULL , 
      created_at timestamp(0)   , 
      updated_at timestamp(0)   , 
      data_transacao date    NOT NULL , 
      conta_id number(10)    NOT NULL , 
      saldo_anterior binary_double    NOT NULL , 
      valor binary_double    NOT NULL , 
      saldo_final binary_double   , 
      lancamento_id number(10)    NOT NULL , 
      system_users_id number(10)    NOT NULL , 
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
 CREATE SEQUENCE agendamento_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER agendamento_id_seq_tr 

BEFORE INSERT ON agendamento FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT agendamento_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE categoria_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER categoria_id_seq_tr 

BEFORE INSERT ON categoria FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT categoria_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE considera_final_semana_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER considera_final_semana_id_seq_tr 

BEFORE INSERT ON considera_final_semana FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT considera_final_semana_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE conta_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER conta_id_seq_tr 

BEFORE INSERT ON conta FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT conta_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE lancamento_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER lancamento_id_seq_tr 

BEFORE INSERT ON lancamento FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT lancamento_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE lembrete_agenda_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER lembrete_agenda_id_seq_tr 

BEFORE INSERT ON lembrete_agenda FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT lembrete_agenda_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE plano_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER plano_id_seq_tr 

BEFORE INSERT ON plano FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT plano_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE recorrencia_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER recorrencia_id_seq_tr 

BEFORE INSERT ON recorrencia FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT recorrencia_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE relevancia_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER relevancia_id_seq_tr 

BEFORE INSERT ON relevancia FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT relevancia_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE saldo_calculado_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER saldo_calculado_id_seq_tr 

BEFORE INSERT ON saldo_calculado FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT saldo_calculado_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE status_lancamento_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER status_lancamento_id_seq_tr 

BEFORE INSERT ON status_lancamento FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT status_lancamento_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE status_tarefa_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER status_tarefa_id_seq_tr 

BEFORE INSERT ON status_tarefa FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT status_tarefa_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_id_seq_tr 

BEFORE INSERT ON tipo FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tipo_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_categoria_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_categoria_id_seq_tr 

BEFORE INSERT ON tipo_categoria FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tipo_categoria_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_conta_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_conta_id_seq_tr 

BEFORE INSERT ON tipo_conta FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tipo_conta_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_lancamento_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_lancamento_id_seq_tr 

BEFORE INSERT ON tipo_lancamento FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tipo_lancamento_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE totaliza_receita_despesa_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER totaliza_receita_despesa_id_seq_tr 

BEFORE INSERT ON totaliza_receita_despesa FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT totaliza_receita_despesa_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE transacao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER transacao_id_seq_tr 

BEFORE INSERT ON transacao FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT transacao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 