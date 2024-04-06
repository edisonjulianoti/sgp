CREATE TABLE atendente( 
      id  INT IDENTITY    NOT NULL  , 
      system_user_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE atendimento( 
      id  INT IDENTITY    NOT NULL  , 
      tipo_atendimento_id int   NOT NULL  , 
      setor_id int   NOT NULL  , 
      cliente_id int   NOT NULL  , 
      cliente_usuario_id int   NOT NULL  , 
      atendente_id int   , 
      arquivos nvarchar(max)   , 
      data_abertura datetime2   , 
      data_fechamento datetime2   , 
      mensagem nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE atendimento_interacao( 
      id  INT IDENTITY    NOT NULL  , 
      atendimento_id int   NOT NULL  , 
      atendente_id int   , 
      cliente_usuario_id int   , 
      arquivos nvarchar(max)   , 
      mensagem nvarchar(max)   , 
      data_interacao datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE categoria_guia( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      email nvarchar(max)   , 
      telefone nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente_usuario( 
      id  INT IDENTITY    NOT NULL  , 
      cliente_id int   NOT NULL  , 
      system_user_id int   , 
      ativo char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE documento( 
      id  INT IDENTITY    NOT NULL  , 
      cliente_id int   NOT NULL  , 
      tipo_documento_id int   NOT NULL  , 
      created_by_system_user_id int   , 
      vaildade date   , 
      arquivo nvarchar(max)   , 
      observacao nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE documento_download_log( 
      id  INT IDENTITY    NOT NULL  , 
      documento_id int   NOT NULL  , 
      downloaded_by_system_user_id int   NOT NULL  , 
      data_download datetime2   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE fila_email( 
      id  INT IDENTITY    NOT NULL  , 
      fila_email_status_id int   NOT NULL  , 
      titulo nvarchar(max)   NOT NULL  , 
      conteudo nvarchar(max)   NOT NULL  , 
      arquivos nvarchar(max)   , 
      destinatarios nvarchar(max)   NOT NULL  , 
      tentativas_envio int   , 
      tipo_origem nvarchar(max)   , 
      erro nvarchar(max)   , 
      data_envio datetime2   , 
      criado_em datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE fila_email_status( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE guia( 
      id  INT IDENTITY    NOT NULL  , 
      subcategoria_guia_id int   NOT NULL  , 
      cliente_id int   NOT NULL  , 
      created_by_system_user_id int   NOT NULL  , 
      ano_competencia int   NOT NULL  , 
      mes_competencia int   NOT NULL  , 
      data_vencimento date   NOT NULL  , 
      download_pos_vencimento char  (1)   NOT NULL    DEFAULT 'F', 
      arquivo nvarchar(max)   NOT NULL  , 
      downloaded char  (1)   NOT NULL    DEFAULT 'F', 
 PRIMARY KEY (id)) ; 

CREATE TABLE guia_download_log( 
      id  INT IDENTITY    NOT NULL  , 
      guia_id int   NOT NULL  , 
      downloaded_by_system_user_id int   NOT NULL  , 
      data_download datetime2   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE link_util( 
      id  INT IDENTITY    NOT NULL  , 
      created_by_system_user_id int   NOT NULL  , 
      titulo nvarchar(max)   NOT NULL  , 
      descricao nvarchar(max)   NOT NULL  , 
      link nvarchar(max)   NOT NULL  , 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
      criado_em datetime2   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE noticia( 
      id  INT IDENTITY    NOT NULL  , 
      created_by_system_user_id int   NOT NULL  , 
      titulo nvarchar(max)   NOT NULL  , 
      descricao_resumida nvarchar(max)   NOT NULL  , 
      conteudo nvarchar(max)   NOT NULL  , 
      foto_capa nvarchar(max)   NOT NULL  , 
      data_noticia datetime2   NOT NULL  , 
      ativo char  (1)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pagina_conhecimento( 
      id  INT IDENTITY    NOT NULL  , 
      created_by_system_user_id int   NOT NULL  , 
      titulo nvarchar(max)   NOT NULL  , 
      conteudo nvarchar(max)   NOT NULL  , 
      descricao_resumida nvarchar(max)   NOT NULL  , 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ; 

CREATE TABLE setor( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE setor_atendente( 
      id  INT IDENTITY    NOT NULL  , 
      setor_id int   NOT NULL  , 
      atendente_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE subcategoria_guia( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      categoria_guia_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE template_email( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      titulo nvarchar(max)   NOT NULL  , 
      conteudo nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_atendimento( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_documento( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
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
