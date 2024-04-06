SET IDENTITY_INSERT atendente ON; 

INSERT INTO atendente (id,system_user_id) VALUES (1,1); 

SET IDENTITY_INSERT atendente OFF; 

SET IDENTITY_INSERT categoria_guia ON; 

INSERT INTO categoria_guia (id,nome) VALUES (1,'Pessoal'); 

INSERT INTO categoria_guia (id,nome) VALUES (2,'Tributos federais'); 

INSERT INTO categoria_guia (id,nome) VALUES (3,'Tributos estaduais'); 

INSERT INTO categoria_guia (id,nome) VALUES (4,'Tributos municipais'); 

INSERT INTO categoria_guia (id,nome) VALUES (5,'Escritório'); 

SET IDENTITY_INSERT categoria_guia OFF; 

SET IDENTITY_INSERT cliente ON; 

INSERT INTO cliente (id,nome,email,telefone) VALUES (1,'Adianti','adianti@adianti.com.br','(51) 1 1111-1111'); 

SET IDENTITY_INSERT cliente OFF; 

SET IDENTITY_INSERT cliente_usuario ON; 

INSERT INTO cliente_usuario (id,cliente_id,system_user_id,ativo) VALUES (1,1,1,'T'); 

SET IDENTITY_INSERT cliente_usuario OFF; 

SET IDENTITY_INSERT fila_email_status ON; 

INSERT INTO fila_email_status (id,nome) VALUES (1,'Aguardando'); 

INSERT INTO fila_email_status (id,nome) VALUES (2,'Enviando'); 

INSERT INTO fila_email_status (id,nome) VALUES (3,'Enviado'); 

INSERT INTO fila_email_status (id,nome) VALUES (4,'Erro'); 

SET IDENTITY_INSERT fila_email_status OFF; 

SET IDENTITY_INSERT setor ON; 

INSERT INTO setor (id,nome) VALUES (1,'Fiscal'); 

INSERT INTO setor (id,nome) VALUES (2,'Contábil'); 

INSERT INTO setor (id,nome) VALUES (3,'RH'); 

INSERT INTO setor (id,nome) VALUES (4,'Geral'); 

SET IDENTITY_INSERT setor OFF; 

SET IDENTITY_INSERT setor_atendente ON; 

INSERT INTO setor_atendente (id,setor_id,atendente_id) VALUES (1,1,1); 

INSERT INTO setor_atendente (id,setor_id,atendente_id) VALUES (2,2,1); 

INSERT INTO setor_atendente (id,setor_id,atendente_id) VALUES (3,3,1); 

SET IDENTITY_INSERT setor_atendente OFF; 

SET IDENTITY_INSERT subcategoria_guia ON; 

INSERT INTO subcategoria_guia (id,nome,categoria_guia_id) VALUES (1,'DCTF',1); 

INSERT INTO subcategoria_guia (id,nome,categoria_guia_id) VALUES (2,'Folha de pagamento',1); 

INSERT INTO subcategoria_guia (id,nome,categoria_guia_id) VALUES (3,'IRRF',2); 

INSERT INTO subcategoria_guia (id,nome,categoria_guia_id) VALUES (4,'PIS',2); 

INSERT INTO subcategoria_guia (id,nome,categoria_guia_id) VALUES (5,'COFINS',2); 

INSERT INTO subcategoria_guia (id,nome,categoria_guia_id) VALUES (6,'ICMS',3); 

INSERT INTO subcategoria_guia (id,nome,categoria_guia_id) VALUES (7,'ISS',4); 

INSERT INTO subcategoria_guia (id,nome,categoria_guia_id) VALUES (8,'Honorários',5); 

SET IDENTITY_INSERT subcategoria_guia OFF; 

SET IDENTITY_INSERT template_email ON; 

INSERT INTO template_email (id,nome,titulo,conteudo) VALUES (1,'Nova guia','Nova guia publicada','Olá {cliente->nome}'); 

INSERT INTO template_email (id,nome,titulo,conteudo) VALUES (2,'Novo documento','Novo documento publicado','Olá {cliente->nome}'); 

INSERT INTO template_email (id,nome,titulo,conteudo) VALUES (3,'Guia expirando','Há uma guia expirando','<p>Olá {cliente->nome}.</p><p><span style="color: var(--text-color); font-family: var(--font-family); font-size: var(--font-size);">Você possui uma guia publicada que vencerá amanhã, no entanto o download da mesma não foi efetuado.</span><br></p><p><span style="color: var(--text-color); font-family: var(--font-family); font-size: var(--font-size);">A guia é referente à {subcategoria_guia->nome}, e o vencimento é em {data_vencimento_br}.</span><br></p><p><span style="color: var(--text-color); font-family: var(--font-family); font-size: var(--font-size);">Acesse o portal contábil para realizar o download, e em seguida efetue o pagamento da mesma para não ficar em débito com suas obrigações.</span><br></p>'); 

INSERT INTO template_email (id,nome,titulo,conteudo) VALUES (4,'Novo atendimento','Há um novo atendimento #{id}','Olá há um novo atendimento aguardando.'); 

INSERT INTO template_email (id,nome,titulo,conteudo) VALUES (5,'Nova interação do cliente','Nova interação no atendimento #{id}','Olá há uma nova interação'); 

INSERT INTO template_email (id,nome,titulo,conteudo) VALUES (6,'Nova interação do atendente','Nova interação no atendimento #{id}','Olá há uma nova interação'); 

SET IDENTITY_INSERT template_email OFF; 

SET IDENTITY_INSERT tipo_atendimento ON; 

INSERT INTO tipo_atendimento (id,nome) VALUES (1,'Envio de extratos'); 

INSERT INTO tipo_atendimento (id,nome) VALUES (2,'Envio de comprovantes'); 

INSERT INTO tipo_atendimento (id,nome) VALUES (3,'Envio de documentos'); 

INSERT INTO tipo_atendimento (id,nome) VALUES (4,'Dúvidas gerais'); 

INSERT INTO tipo_atendimento (id,nome) VALUES (5,'Solicitações de alterações contratuais'); 

SET IDENTITY_INSERT tipo_atendimento OFF; 

SET IDENTITY_INSERT tipo_documento ON; 

INSERT INTO tipo_documento (id,nome) VALUES (1,'Contrato social'); 

INSERT INTO tipo_documento (id,nome) VALUES (2,'Certificado digital'); 

INSERT INTO tipo_documento (id,nome) VALUES (3,'Ficha CNPJ'); 

INSERT INTO tipo_documento (id,nome) VALUES (4,'Decore'); 

INSERT INTO tipo_documento (id,nome) VALUES (5,'Certidões negativas'); 

SET IDENTITY_INSERT tipo_documento OFF; 
