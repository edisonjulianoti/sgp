CREATE TABLE atendente( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE atendimento( 
      id number(10)    NOT NULL , 
      tipo_atendimento_id number(10)    NOT NULL , 
      setor_id number(10)    NOT NULL , 
      cliente_id number(10)    NOT NULL , 
      cliente_usuario_id number(10)    NOT NULL , 
      atendente_id number(10)   , 
      arquivos varchar(3000)   , 
      data_abertura timestamp(0)   , 
      data_fechamento timestamp(0)   , 
      mensagem varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE atendimento_interacao( 
      id number(10)    NOT NULL , 
      atendimento_id number(10)    NOT NULL , 
      atendente_id number(10)   , 
      cliente_usuario_id number(10)   , 
      arquivos varchar(3000)   , 
      mensagem varchar(3000)   , 
      data_interacao timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE categoria_guia( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
      email varchar(3000)   , 
      telefone varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente_usuario( 
      id number(10)    NOT NULL , 
      cliente_id number(10)    NOT NULL , 
      system_user_id number(10)   , 
      ativo char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE documento( 
      id number(10)    NOT NULL , 
      cliente_id number(10)    NOT NULL , 
      tipo_documento_id number(10)    NOT NULL , 
      created_by_system_user_id number(10)   , 
      vaildade date   , 
      arquivo varchar(3000)   , 
      observacao varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE documento_download_log( 
      id number(10)    NOT NULL , 
      documento_id number(10)    NOT NULL , 
      downloaded_by_system_user_id number(10)    NOT NULL , 
      data_download timestamp(0)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE fila_email( 
      id number(10)    NOT NULL , 
      fila_email_status_id number(10)    NOT NULL , 
      titulo varchar(3000)    NOT NULL , 
      conteudo varchar(3000)    NOT NULL , 
      arquivos varchar(3000)   , 
      destinatarios varchar(3000)    NOT NULL , 
      tentativas_envio number(10)   , 
      tipo_origem varchar(3000)   , 
      erro varchar(3000)   , 
      data_envio timestamp(0)   , 
      criado_em timestamp(0)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE fila_email_status( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE guia( 
      id number(10)    NOT NULL , 
      subcategoria_guia_id number(10)    NOT NULL , 
      cliente_id number(10)    NOT NULL , 
      created_by_system_user_id number(10)    NOT NULL , 
      ano_competencia number(10)    NOT NULL , 
      mes_competencia number(10)    NOT NULL , 
      data_vencimento date    NOT NULL , 
      download_pos_vencimento char  (1)    DEFAULT 'F'  NOT NULL , 
      arquivo varchar(3000)    NOT NULL , 
      downloaded char  (1)    DEFAULT 'F'  NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE guia_download_log( 
      id number(10)    NOT NULL , 
      guia_id number(10)    NOT NULL , 
      downloaded_by_system_user_id number(10)    NOT NULL , 
      data_download timestamp(0)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE link_util( 
      id number(10)    NOT NULL , 
      created_by_system_user_id number(10)    NOT NULL , 
      titulo varchar(3000)    NOT NULL , 
      descricao varchar(3000)    NOT NULL , 
      link varchar(3000)    NOT NULL , 
      ativo char  (1)    DEFAULT 'T'  NOT NULL , 
      criado_em timestamp(0)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE noticia( 
      id number(10)    NOT NULL , 
      created_by_system_user_id number(10)    NOT NULL , 
      titulo varchar(3000)    NOT NULL , 
      descricao_resumida varchar(3000)    NOT NULL , 
      conteudo varchar(3000)    NOT NULL , 
      foto_capa varchar(3000)    NOT NULL , 
      data_noticia timestamp(0)    NOT NULL , 
      ativo char  (1)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pagina_conhecimento( 
      id number(10)    NOT NULL , 
      created_by_system_user_id number(10)    NOT NULL , 
      titulo varchar(3000)    NOT NULL , 
      conteudo varchar(3000)    NOT NULL , 
      descricao_resumida varchar(3000)    NOT NULL , 
      ativo char  (1)    DEFAULT 'T'  NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE setor( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE setor_atendente( 
      id number(10)    NOT NULL , 
      setor_id number(10)    NOT NULL , 
      atendente_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE subcategoria_guia( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
      categoria_guia_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE template_email( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
      titulo varchar(3000)    NOT NULL , 
      conteudo varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_atendimento( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_documento( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

 
  
 ALTER TABLE atendimento ADD CONSTRAINT fk_atendimento_1 FOREIGN KEY (tipo_atendimento_id) references tipo_atendimento(id); 
ALTER TABLE atendimento ADD CONSTRAINT fk_atendimento_2 FOREIGN KEY (setor_id) references setor(id); 
ALTER TABLE atendimento ADD CONSTRAINT fk_atendimento_3 FOREIGN KEY (cliente_id) references cliente(id); 
ALTER TABLE atendimento ADD CONSTRAINT fk_atendimento_4 FOREIGN KEY (atendente_id) references atendente(id); 
ALTER TABLE atendimento ADD CONSTRAINT fk_atendimento_5 FOREIGN KEY (cliente_usuario_id) references cliente_usuario(id); 
ALTER TABLE atendimento_interacao ADD CONSTRAINT fk_atendimento_interacao_1 FOREIGN KEY (atendimento_id) references atendimento(id); 
ALTER TABLE atendimento_interacao ADD CONSTRAINT fk_atendimento_interacao_2 FOREIGN KEY (atendente_id) references atendente(id); 
ALTER TABLE atendimento_interacao ADD CONSTRAINT fk_atendimento_interacao_3 FOREIGN KEY (cliente_usuario_id) references cliente_usuario(id); 
ALTER TABLE cliente_usuario ADD CONSTRAINT fk_cliente_usuario_1 FOREIGN KEY (cliente_id) references cliente(id); 
ALTER TABLE documento ADD CONSTRAINT fk_documento_1 FOREIGN KEY (cliente_id) references cliente(id); 
ALTER TABLE documento ADD CONSTRAINT fk_documento_2 FOREIGN KEY (tipo_documento_id) references tipo_documento(id); 
ALTER TABLE documento_download_log ADD CONSTRAINT fk_documento_download_log_1 FOREIGN KEY (documento_id) references documento(id); 
ALTER TABLE fila_email ADD CONSTRAINT fk_fila_email_1 FOREIGN KEY (fila_email_status_id) references fila_email_status(id); 
ALTER TABLE guia ADD CONSTRAINT fk_guia_1 FOREIGN KEY (subcategoria_guia_id) references subcategoria_guia(id); 
ALTER TABLE guia ADD CONSTRAINT fk_guia_2 FOREIGN KEY (cliente_id) references cliente(id); 
ALTER TABLE guia_download_log ADD CONSTRAINT fk_guia_download_log_1 FOREIGN KEY (guia_id) references guia(id); 
ALTER TABLE setor_atendente ADD CONSTRAINT fk_setor_atendente_1 FOREIGN KEY (setor_id) references setor(id); 
ALTER TABLE setor_atendente ADD CONSTRAINT fk_setor_atendente_2 FOREIGN KEY (atendente_id) references atendente(id); 
ALTER TABLE subcategoria_guia ADD CONSTRAINT fk_subcategoria_guia_1 FOREIGN KEY (categoria_guia_id) references categoria_guia(id); 
 CREATE SEQUENCE atendente_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER atendente_id_seq_tr 

BEFORE INSERT ON atendente FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT atendente_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE atendimento_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER atendimento_id_seq_tr 

BEFORE INSERT ON atendimento FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT atendimento_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE atendimento_interacao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER atendimento_interacao_id_seq_tr 

BEFORE INSERT ON atendimento_interacao FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT atendimento_interacao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE categoria_guia_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER categoria_guia_id_seq_tr 

BEFORE INSERT ON categoria_guia FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT categoria_guia_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE cliente_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER cliente_id_seq_tr 

BEFORE INSERT ON cliente FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT cliente_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE cliente_usuario_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER cliente_usuario_id_seq_tr 

BEFORE INSERT ON cliente_usuario FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT cliente_usuario_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE documento_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER documento_id_seq_tr 

BEFORE INSERT ON documento FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT documento_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE documento_download_log_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER documento_download_log_id_seq_tr 

BEFORE INSERT ON documento_download_log FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT documento_download_log_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE fila_email_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER fila_email_id_seq_tr 

BEFORE INSERT ON fila_email FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT fila_email_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE fila_email_status_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER fila_email_status_id_seq_tr 

BEFORE INSERT ON fila_email_status FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT fila_email_status_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE guia_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER guia_id_seq_tr 

BEFORE INSERT ON guia FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT guia_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE guia_download_log_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER guia_download_log_id_seq_tr 

BEFORE INSERT ON guia_download_log FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT guia_download_log_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE link_util_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER link_util_id_seq_tr 

BEFORE INSERT ON link_util FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT link_util_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE noticia_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER noticia_id_seq_tr 

BEFORE INSERT ON noticia FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT noticia_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE pagina_conhecimento_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER pagina_conhecimento_id_seq_tr 

BEFORE INSERT ON pagina_conhecimento FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT pagina_conhecimento_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE setor_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER setor_id_seq_tr 

BEFORE INSERT ON setor FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT setor_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE setor_atendente_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER setor_atendente_id_seq_tr 

BEFORE INSERT ON setor_atendente FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT setor_atendente_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE subcategoria_guia_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER subcategoria_guia_id_seq_tr 

BEFORE INSERT ON subcategoria_guia FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT subcategoria_guia_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE template_email_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER template_email_id_seq_tr 

BEFORE INSERT ON template_email FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT template_email_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_atendimento_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_atendimento_id_seq_tr 

BEFORE INSERT ON tipo_atendimento FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tipo_atendimento_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_documento_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_documento_id_seq_tr 

BEFORE INSERT ON tipo_documento FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tipo_documento_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 