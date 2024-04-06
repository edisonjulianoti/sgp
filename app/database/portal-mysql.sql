CREATE TABLE atendente( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `system_user_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE atendimento( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `tipo_atendimento_id` int   NOT NULL  , 
      `setor_id` int   NOT NULL  , 
      `cliente_id` int   NOT NULL  , 
      `cliente_usuario_id` int   NOT NULL  , 
      `atendente_id` int   , 
      `arquivos` text   , 
      `data_abertura` datetime   , 
      `data_fechamento` datetime   , 
      `mensagem` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE atendimento_interacao( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `atendimento_id` int   NOT NULL  , 
      `atendente_id` int   , 
      `cliente_usuario_id` int   , 
      `arquivos` text   , 
      `mensagem` text   , 
      `data_interacao` datetime   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE categoria_guia( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE cliente( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
      `email` text   , 
      `telefone` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE cliente_usuario( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `cliente_id` int   NOT NULL  , 
      `system_user_id` int   , 
      `ativo` char  (1)   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE documento( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `cliente_id` int   NOT NULL  , 
      `tipo_documento_id` int   NOT NULL  , 
      `created_by_system_user_id` int   , 
      `vaildade` date   , 
      `arquivo` text   , 
      `observacao` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE documento_download_log( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `documento_id` int   NOT NULL  , 
      `downloaded_by_system_user_id` int   NOT NULL  , 
      `data_download` datetime   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE fila_email( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `fila_email_status_id` int   NOT NULL  , 
      `titulo` text   NOT NULL  , 
      `conteudo` text   NOT NULL  , 
      `arquivos` text   , 
      `destinatarios` text   NOT NULL  , 
      `tentativas_envio` int   , 
      `tipo_origem` text   , 
      `erro` text   , 
      `data_envio` datetime   , 
      `criado_em` datetime   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE fila_email_status( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE guia( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `subcategoria_guia_id` int   NOT NULL  , 
      `cliente_id` int   NOT NULL  , 
      `created_by_system_user_id` int   NOT NULL  , 
      `ano_competencia` int   NOT NULL  , 
      `mes_competencia` int   NOT NULL  , 
      `data_vencimento` date   NOT NULL  , 
      `download_pos_vencimento` char  (1)   NOT NULL    DEFAULT 'F', 
      `arquivo` text   NOT NULL  , 
      `downloaded` char  (1)   NOT NULL    DEFAULT 'F', 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE guia_download_log( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `guia_id` int   NOT NULL  , 
      `downloaded_by_system_user_id` int   NOT NULL  , 
      `data_download` datetime   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE link_util( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `created_by_system_user_id` int   NOT NULL  , 
      `titulo` text   NOT NULL  , 
      `descricao` text   NOT NULL  , 
      `link` text   NOT NULL  , 
      `ativo` char  (1)   NOT NULL    DEFAULT 'T', 
      `criado_em` datetime   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE noticia( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `created_by_system_user_id` int   NOT NULL  , 
      `titulo` text   NOT NULL  , 
      `descricao_resumida` text   NOT NULL  , 
      `conteudo` text   NOT NULL  , 
      `foto_capa` text   NOT NULL  , 
      `data_noticia` datetime   NOT NULL  , 
      `ativo` char  (1)   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE pagina_conhecimento( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `created_by_system_user_id` int   NOT NULL  , 
      `titulo` text   NOT NULL  , 
      `conteudo` text   NOT NULL  , 
      `descricao_resumida` text   NOT NULL  , 
      `ativo` char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE setor( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE setor_atendente( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `setor_id` int   NOT NULL  , 
      `atendente_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE subcategoria_guia( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
      `categoria_guia_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE template_email( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
      `titulo` text   NOT NULL  , 
      `conteudo` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE tipo_atendimento( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE tipo_documento( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

 
  
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
