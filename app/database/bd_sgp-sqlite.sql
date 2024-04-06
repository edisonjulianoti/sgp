PRAGMA foreign_keys=OFF; 

CREATE TABLE agendamento( 
      id  INTEGER    NOT NULL  , 
      titulo varchar  (200)   NOT NULL  , 
      descricao text   NOT NULL  , 
      data_inicio datetime   NOT NULL  , 
      data_fim datetime   NOT NULL  , 
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
 PRIMARY KEY (id),
FOREIGN KEY(relevancia_id) REFERENCES relevancia(id),
FOREIGN KEY(recorrencia_id) REFERENCES recorrencia(id),
FOREIGN KEY(plano_id) REFERENCES plano(id),
FOREIGN KEY(tipo_id) REFERENCES tipo(id),
FOREIGN KEY(considera_final_semana_id) REFERENCES considera_final_semana(id),
FOREIGN KEY(lembrete_agenda_id) REFERENCES lembrete_agenda(id),
FOREIGN KEY(system_users_id) REFERENCES system_users(id)) ; 

CREATE TABLE categoria( 
      id  INTEGER    NOT NULL  , 
      created_at datetime   , 
      updated_at datetime   , 
      descricao varchar  (200)   NOT NULL  , 
      tipo_categoria_id int   NOT NULL  , 
      totaliza_receita_despesa_id int   NOT NULL  , 
      system_users_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(tipo_categoria_id) REFERENCES tipo_categoria(id),
FOREIGN KEY(totaliza_receita_despesa_id) REFERENCES totaliza_receita_despesa(id),
FOREIGN KEY(system_users_id) REFERENCES system_users(id)) ; 

CREATE TABLE considera_final_semana( 
      id  INTEGER    NOT NULL  , 
      descricao varchar  (200)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE conta( 
      id  INTEGER    NOT NULL  , 
      tipo_conta_id int   NOT NULL  , 
      descricao varchar  (200)   NOT NULL  , 
      banco varchar  (200)   , 
      data_saldo_inicial date   NOT NULL  , 
      saldo_inicial double   NOT NULL  , 
      saldo_atual double   NOT NULL  , 
      system_users_id int   NOT NULL  , 
      updated_at datetime   , 
      created_at datetime   , 
      saldo_calculado_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(tipo_conta_id) REFERENCES tipo_conta(id),
FOREIGN KEY(system_users_id) REFERENCES system_users(id),
FOREIGN KEY(saldo_calculado_id) REFERENCES saldo_calculado(id)) ; 

CREATE TABLE lancamento( 
      id  INTEGER    NOT NULL  , 
      descricao varchar  (200)   NOT NULL  , 
      vencimento date   NOT NULL  , 
      pagamento date   , 
      valor double   NOT NULL  , 
      categoria_id int   NOT NULL  , 
      conta_id int   NOT NULL  , 
      status_lancamento_id int   NOT NULL  , 
      system_users_id int   NOT NULL  , 
      updated_at datetime   , 
      created_at datetime   , 
      tipo_lancamento_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(categoria_id) REFERENCES categoria(id),
FOREIGN KEY(conta_id) REFERENCES conta(id),
FOREIGN KEY(status_lancamento_id) REFERENCES status_lancamento(id),
FOREIGN KEY(system_users_id) REFERENCES system_users(id),
FOREIGN KEY(tipo_lancamento_id) REFERENCES tipo_lancamento(id)) ; 

CREATE TABLE lembrete_agenda( 
      id  INTEGER    NOT NULL  , 
      minutos int   , 
      descricao text   , 
      mensagem text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE plano( 
      id  INTEGER    NOT NULL  , 
      titulo varchar  (200)   , 
      descricao text   NOT NULL  , 
      previsao date   NOT NULL  , 
      created_at datetime   NOT NULL  , 
      updated_at datetime   , 
      system_users_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_users_id) REFERENCES system_users(id)) ; 

CREATE TABLE recorrencia( 
      id  INTEGER    NOT NULL  , 
      descricao char  (200)   NOT NULL  , 
      qtd_dia int   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE relevancia( 
      id  INTEGER    NOT NULL  , 
      descricao varchar  (200)   NOT NULL  , 
      cor varchar  (200)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE saldo_calculado( 
      id  INTEGER    NOT NULL  , 
      descricao varchar  (5)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status_lancamento( 
      id  INTEGER    NOT NULL  , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status_tarefa( 
      id  INTEGER    NOT NULL  , 
      descricao varchar  (200)   NOT NULL  , 
      cor text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      uuid varchar  (36)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_program_id) REFERENCES system_program(id),
FOREIGN KEY(system_group_id) REFERENCES system_group(id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)   NOT NULL  , 
      preference text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      controller text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      connection_name text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_group_id) REFERENCES system_group(id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id)) ; 

CREATE TABLE system_user_program( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_program_id) REFERENCES system_program(id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id)) ; 

CREATE TABLE system_users( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      login text   NOT NULL  , 
      password text   NOT NULL  , 
      email text   , 
      frontpage_id int   , 
      system_unit_id int   , 
      active char  (1)   , 
      accepted_term_policy_at text   , 
      accepted_term_policy char  (1)   , 
 PRIMARY KEY (id),
FOREIGN KEY(system_unit_id) REFERENCES system_unit(id),
FOREIGN KEY(frontpage_id) REFERENCES system_program(id)) ; 

CREATE TABLE system_user_unit( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id),
FOREIGN KEY(system_unit_id) REFERENCES system_unit(id)) ; 

CREATE TABLE tarefa( 
      id int   NOT NULL  , 
      descricao varchar  (200)   NOT NULL  , 
      detalhe text   , 
      conclusao date   , 
      plano_id int   , 
      status_tarefa_id int   NOT NULL  , 
      relevancia_id int   NOT NULL  , 
      created_at datetime   NOT NULL  , 
      update_at datetime   , 
      tipo_id int   NOT NULL  , 
      system_users_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(plano_id) REFERENCES plano(id),
FOREIGN KEY(status_tarefa_id) REFERENCES status_tarefa(id),
FOREIGN KEY(relevancia_id) REFERENCES relevancia(id),
FOREIGN KEY(tipo_id) REFERENCES tipo(id),
FOREIGN KEY(system_users_id) REFERENCES system_users(id)) ; 

CREATE TABLE tipo( 
      id  INTEGER    NOT NULL  , 
      descricao varchar  (200)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_categoria( 
      id  INTEGER    NOT NULL  , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_conta( 
      id  INTEGER    NOT NULL  , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_lancamento( 
      id  INTEGER    NOT NULL  , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE totaliza_receita_despesa( 
      id  INTEGER    NOT NULL  , 
      descricao varchar  (20)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE transacao( 
      id  INTEGER    NOT NULL  , 
      created_at datetime   , 
      updated_at datetime   , 
      data_transacao date   NOT NULL  , 
      conta_id int   NOT NULL  , 
      saldo_anterior double   NOT NULL  , 
      valor double   NOT NULL  , 
      saldo_final double   , 
      lancamento_id int   NOT NULL  , 
      system_users_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(conta_id) REFERENCES conta(id),
FOREIGN KEY(lancamento_id) REFERENCES lancamento(id),
FOREIGN KEY(system_users_id) REFERENCES system_users(id)) ; 

 
 