PRAGMA foreign_keys=OFF; 

CREATE TABLE atendente( 
      id  INTEGER    NOT NULL  , 
      system_user_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE atendimento( 
      id  INTEGER    NOT NULL  , 
      tipo_atendimento_id int   NOT NULL  , 
      setor_id int   NOT NULL  , 
      cliente_id int   NOT NULL  , 
      cliente_usuario_id int   NOT NULL  , 
      atendente_id int   , 
      arquivos text   , 
      data_abertura datetime   , 
      data_fechamento datetime   , 
      mensagem text   , 
 PRIMARY KEY (id),
FOREIGN KEY(tipo_atendimento_id) REFERENCES tipo_atendimento(id),
FOREIGN KEY(setor_id) REFERENCES setor(id),
FOREIGN KEY(cliente_id) REFERENCES cliente(id),
FOREIGN KEY(atendente_id) REFERENCES atendente(id),
FOREIGN KEY(cliente_usuario_id) REFERENCES cliente_usuario(id)) ; 

CREATE TABLE atendimento_interacao( 
      id  INTEGER    NOT NULL  , 
      atendimento_id int   NOT NULL  , 
      atendente_id int   , 
      cliente_usuario_id int   , 
      arquivos text   , 
      mensagem text   , 
      data_interacao datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(atendimento_id) REFERENCES atendimento(id),
FOREIGN KEY(atendente_id) REFERENCES atendente(id),
FOREIGN KEY(cliente_usuario_id) REFERENCES cliente_usuario(id)) ; 

CREATE TABLE categoria_guia( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
      email text   , 
      telefone text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente_usuario( 
      id  INTEGER    NOT NULL  , 
      cliente_id int   NOT NULL  , 
      system_user_id int   , 
      ativo char  (1)   , 
 PRIMARY KEY (id),
FOREIGN KEY(cliente_id) REFERENCES cliente(id)) ; 

CREATE TABLE documento( 
      id  INTEGER    NOT NULL  , 
      cliente_id int   NOT NULL  , 
      tipo_documento_id int   NOT NULL  , 
      created_by_system_user_id int   , 
      vaildade date   , 
      arquivo text   , 
      observacao text   , 
 PRIMARY KEY (id),
FOREIGN KEY(cliente_id) REFERENCES cliente(id),
FOREIGN KEY(tipo_documento_id) REFERENCES tipo_documento(id)) ; 

CREATE TABLE documento_download_log( 
      id  INTEGER    NOT NULL  , 
      documento_id int   NOT NULL  , 
      downloaded_by_system_user_id int   NOT NULL  , 
      data_download datetime   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(documento_id) REFERENCES documento(id)) ; 

CREATE TABLE fila_email( 
      id  INTEGER    NOT NULL  , 
      fila_email_status_id int   NOT NULL  , 
      titulo text   NOT NULL  , 
      conteudo text   NOT NULL  , 
      arquivos text   , 
      destinatarios text   NOT NULL  , 
      tentativas_envio int   , 
      tipo_origem text   , 
      erro text   , 
      data_envio datetime   , 
      criado_em datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(fila_email_status_id) REFERENCES fila_email_status(id)) ; 

CREATE TABLE fila_email_status( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE guia( 
      id  INTEGER    NOT NULL  , 
      subcategoria_guia_id int   NOT NULL  , 
      cliente_id int   NOT NULL  , 
      created_by_system_user_id int   NOT NULL  , 
      ano_competencia int   NOT NULL  , 
      mes_competencia int   NOT NULL  , 
      data_vencimento date   NOT NULL  , 
      download_pos_vencimento char  (1)   NOT NULL    DEFAULT 'F', 
      arquivo text   NOT NULL  , 
      downloaded char  (1)   NOT NULL    DEFAULT 'F', 
 PRIMARY KEY (id),
FOREIGN KEY(subcategoria_guia_id) REFERENCES subcategoria_guia(id),
FOREIGN KEY(cliente_id) REFERENCES cliente(id)) ; 

CREATE TABLE guia_download_log( 
      id  INTEGER    NOT NULL  , 
      guia_id int   NOT NULL  , 
      downloaded_by_system_user_id int   NOT NULL  , 
      data_download datetime   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(guia_id) REFERENCES guia(id)) ; 

CREATE TABLE link_util( 
      id  INTEGER    NOT NULL  , 
      created_by_system_user_id int   NOT NULL  , 
      titulo text   NOT NULL  , 
      descricao text   NOT NULL  , 
      link text   NOT NULL  , 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
      criado_em datetime   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE noticia( 
      id  INTEGER    NOT NULL  , 
      created_by_system_user_id int   NOT NULL  , 
      titulo text   NOT NULL  , 
      descricao_resumida text   NOT NULL  , 
      conteudo text   NOT NULL  , 
      foto_capa text   NOT NULL  , 
      data_noticia datetime   NOT NULL  , 
      ativo char  (1)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE pagina_conhecimento( 
      id  INTEGER    NOT NULL  , 
      created_by_system_user_id int   NOT NULL  , 
      titulo text   NOT NULL  , 
      conteudo text   NOT NULL  , 
      descricao_resumida text   NOT NULL  , 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ; 

CREATE TABLE setor( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE setor_atendente( 
      id  INTEGER    NOT NULL  , 
      setor_id int   NOT NULL  , 
      atendente_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(setor_id) REFERENCES setor(id),
FOREIGN KEY(atendente_id) REFERENCES atendente(id)) ; 

CREATE TABLE subcategoria_guia( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
      categoria_guia_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(categoria_guia_id) REFERENCES categoria_guia(id)) ; 

CREATE TABLE template_email( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
      titulo text   NOT NULL  , 
      conteudo text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_atendimento( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_documento( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

 
 