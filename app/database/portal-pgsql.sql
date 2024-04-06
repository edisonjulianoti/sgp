CREATE TABLE atendente( 
      id  SERIAL    NOT NULL  , 
      system_user_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE atendimento( 
      id  SERIAL    NOT NULL  , 
      tipo_atendimento_id integer   NOT NULL  , 
      setor_id integer   NOT NULL  , 
      cliente_id integer   NOT NULL  , 
      cliente_usuario_id integer   NOT NULL  , 
      atendente_id integer   , 
      arquivos text   , 
      data_abertura timestamp   , 
      data_fechamento timestamp   , 
      mensagem text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE atendimento_interacao( 
      id  SERIAL    NOT NULL  , 
      atendimento_id integer   NOT NULL  , 
      atendente_id integer   , 
      cliente_usuario_id integer   , 
      arquivos text   , 
      mensagem text   , 
      data_interacao timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE categoria_guia( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
      email text   , 
      telefone text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente_usuario( 
      id  SERIAL    NOT NULL  , 
      cliente_id integer   NOT NULL  , 
      system_user_id integer   , 
      ativo char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE documento( 
      id  SERIAL    NOT NULL  , 
      cliente_id integer   NOT NULL  , 
      tipo_documento_id integer   NOT NULL  , 
      created_by_system_user_id integer   , 
      vaildade date   , 
      arquivo text   , 
      observacao text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE documento_download_log( 
      id  SERIAL    NOT NULL  , 
      documento_id integer   NOT NULL  , 
      downloaded_by_system_user_id integer   NOT NULL  , 
      data_download timestamp   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE fila_email( 
      id  SERIAL    NOT NULL  , 
      fila_email_status_id integer   NOT NULL  , 
      titulo text   NOT NULL  , 
      conteudo text   NOT NULL  , 
      arquivos text   , 
      destinatarios text   NOT NULL  , 
      tentativas_envio integer   , 
      tipo_origem text   , 
      erro text   , 
      data_envio timestamp   , 
      criado_em timestamp   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE fila_email_status( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE guia( 
      id  SERIAL    NOT NULL  , 
      subcategoria_guia_id integer   NOT NULL  , 
      cliente_id integer   NOT NULL  , 
      created_by_system_user_id integer   NOT NULL  , 
      ano_competencia integer   NOT NULL  , 
      mes_competencia integer   NOT NULL  , 
      data_vencimento date   NOT NULL  , 
      download_pos_vencimento char  (1)   NOT NULL    DEFAULT 'F', 
      arquivo text   NOT NULL  , 
      downloaded char  (1)   NOT NULL    DEFAULT 'F', 
 PRIMARY KEY (id)) ; 

CREATE TABLE guia_download_log( 
      id  SERIAL    NOT NULL  , 
      guia_id integer   NOT NULL  , 
      downloaded_by_system_user_id integer   NOT NULL  , 
      data_download timestamp   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE link_util( 
      id  SERIAL    NOT NULL  , 
      created_by_system_user_id integer   NOT NULL  , 
      titulo text   NOT NULL  , 
      descricao text   NOT NULL  , 
      link text   NOT NULL  , 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
      criado_em timestamp   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE noticia( 
      id  SERIAL    NOT NULL  , 
      created_by_system_user_id integer   NOT NULL  , 
      titulo text   NOT NULL  , 
      descricao_resumida text   NOT NULL  , 
      conteudo text   NOT NULL  , 
      foto_capa text   NOT NULL  , 
      data_noticia timestamp   NOT NULL  , 
      ativo char  (1)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pagina_conhecimento( 
      id  SERIAL    NOT NULL  , 
      created_by_system_user_id integer   NOT NULL  , 
      titulo text   NOT NULL  , 
      conteudo text   NOT NULL  , 
      descricao_resumida text   NOT NULL  , 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ; 

CREATE TABLE setor( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE setor_atendente( 
      id  SERIAL    NOT NULL  , 
      setor_id integer   NOT NULL  , 
      atendente_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE subcategoria_guia( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
      categoria_guia_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE template_email( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
      titulo text   NOT NULL  , 
      conteudo text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_atendimento( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_documento( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
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
 
 CREATE index idx_atendimento_tipo_atendimento_id on atendimento(tipo_atendimento_id); 
CREATE index idx_atendimento_setor_id on atendimento(setor_id); 
CREATE index idx_atendimento_cliente_id on atendimento(cliente_id); 
CREATE index idx_atendimento_atendente_id on atendimento(atendente_id); 
CREATE index idx_atendimento_cliente_usuario_id on atendimento(cliente_usuario_id); 
CREATE index idx_atendimento_interacao_atendimento_id on atendimento_interacao(atendimento_id); 
CREATE index idx_atendimento_interacao_atendente_id on atendimento_interacao(atendente_id); 
CREATE index idx_atendimento_interacao_cliente_usuario_id on atendimento_interacao(cliente_usuario_id); 
CREATE index idx_cliente_usuario_cliente_id on cliente_usuario(cliente_id); 
CREATE index idx_documento_cliente_id on documento(cliente_id); 
CREATE index idx_documento_tipo_documento_id on documento(tipo_documento_id); 
CREATE index idx_documento_download_log_documento_id on documento_download_log(documento_id); 
CREATE index idx_fila_email_fila_email_status_id on fila_email(fila_email_status_id); 
CREATE index idx_guia_subcategoria_guia_id on guia(subcategoria_guia_id); 
CREATE index idx_guia_cliente_id on guia(cliente_id); 
CREATE index idx_guia_download_log_guia_id on guia_download_log(guia_id); 
CREATE index idx_setor_atendente_setor_id on setor_atendente(setor_id); 
CREATE index idx_setor_atendente_atendente_id on setor_atendente(atendente_id); 
CREATE index idx_subcategoria_guia_categoria_guia_id on subcategoria_guia(categoria_guia_id); 
