SET IDENTITY_INSERT considera_final_semana ON; 

INSERT INTO considera_final_semana (id,descricao) VALUES (1,'Sim'); 

INSERT INTO considera_final_semana (id,descricao) VALUES (2,'Não'); 

SET IDENTITY_INSERT considera_final_semana OFF; 

SET IDENTITY_INSERT lembrete_agenda ON; 

INSERT INTO lembrete_agenda (id,minutos,descricao,mensagem) VALUES (1,5,'5 Minutos antes de iniciar','inicia em 5 minutos.'); 

INSERT INTO lembrete_agenda (id,minutos,descricao,mensagem) VALUES (2,10,'10 Minutos antes de iniciar','inicia em 10 minutos.'); 

INSERT INTO lembrete_agenda (id,minutos,descricao,mensagem) VALUES (3,15,'15 Minutos antes de iniciar','inicia em 15 minutos.'); 

INSERT INTO lembrete_agenda (id,minutos,descricao,mensagem) VALUES (4,20,'20 Minutos antes de iniciar','inicia em 20 minutos.'); 

INSERT INTO lembrete_agenda (id,minutos,descricao,mensagem) VALUES (5,30,'30 Minutos antes de iniciar','inicia em 30 minutos.'); 

INSERT INTO lembrete_agenda (id,minutos,descricao,mensagem) VALUES (6,45,'45 Minutos antes de iniciar','inicia em 45 minutos.'); 

INSERT INTO lembrete_agenda (id,minutos,descricao,mensagem) VALUES (7,60,'1 Hora antes de iniciar','inicia em 1 hora.'); 

INSERT INTO lembrete_agenda (id,minutos,descricao,mensagem) VALUES (8,120,'2 Hora antes de iniciar','inicia em 2 horas.'); 

INSERT INTO lembrete_agenda (id,minutos,descricao,mensagem) VALUES (9,180,'3 Hora antes de iniciar','inicia em 3 horas.'); 

INSERT INTO lembrete_agenda (id,minutos,descricao,mensagem) VALUES (10,240,'4 Hora antes de iniciar','inicia em 4 horas.'); 

INSERT INTO lembrete_agenda (id,minutos,descricao,mensagem) VALUES (11,300,'5 Hora antes de iniciar','inicia em 5 horas.'); 

INSERT INTO lembrete_agenda (id,minutos,descricao,mensagem) VALUES (12,360,'6 Hora antes de iniciar','inicia em 6 horas.'); 

SET IDENTITY_INSERT lembrete_agenda OFF; 

SET IDENTITY_INSERT recorrencia ON; 

INSERT INTO recorrencia (id,descricao,qtd_dia) VALUES (1,'Sem Recorrência',0); 

INSERT INTO recorrencia (id,descricao,qtd_dia) VALUES (2,'Diário',1); 

INSERT INTO recorrencia (id,descricao,qtd_dia) VALUES (3,'Semanal',7); 

INSERT INTO recorrencia (id,descricao,qtd_dia) VALUES (4,'Mensal',30); 

INSERT INTO recorrencia (id,descricao,qtd_dia) VALUES (5,'Anual',365); 

INSERT INTO recorrencia (id,descricao,qtd_dia) VALUES (6,'Quinzenal',15); 

INSERT INTO recorrencia (id,descricao,qtd_dia) VALUES (7,'Trimestral',90); 

INSERT INTO recorrencia (id,descricao,qtd_dia) VALUES (8,'Semestral',180); 

INSERT INTO recorrencia (id,descricao,qtd_dia) VALUES (9,'Dia Específico',0); 

INSERT INTO recorrencia (id,descricao,qtd_dia) VALUES (10,'Personalizada',0); 

SET IDENTITY_INSERT recorrencia OFF; 

SET IDENTITY_INSERT relevancia ON; 

INSERT INTO relevancia (id,descricao,cor) VALUES (1,'Importante','#ffa000'); 

INSERT INTO relevancia (id,descricao,cor) VALUES (2,'Urgente','#d50000'); 

INSERT INTO relevancia (id,descricao,cor) VALUES (3,'Eventual','#4caf50'); 

SET IDENTITY_INSERT relevancia OFF; 

SET IDENTITY_INSERT saldo_calculado ON; 

INSERT INTO saldo_calculado (id,descricao) VALUES (1,'Sim'); 

INSERT INTO saldo_calculado (id,descricao) VALUES (2,'Não'); 

SET IDENTITY_INSERT saldo_calculado OFF; 

SET IDENTITY_INSERT status_lancamento ON; 

INSERT INTO status_lancamento (id,descricao) VALUES (1,'Aberto'); 

INSERT INTO status_lancamento (id,descricao) VALUES (2,'Pago'); 

SET IDENTITY_INSERT status_lancamento OFF; 

SET IDENTITY_INSERT status_tarefa ON; 

INSERT INTO status_tarefa (id,descricao,cor) VALUES (1,'Pendente','#ffcdd2'); 

INSERT INTO status_tarefa (id,descricao,cor) VALUES (2,'Em Progresso','#fff9c4'); 

INSERT INTO status_tarefa (id,descricao,cor) VALUES (3,'Concluída','#a5d6a7'); 

SET IDENTITY_INSERT status_tarefa OFF; 

INSERT INTO system_group (id,name,uuid) VALUES (1,'Admin',null); 

INSERT INTO system_group (id,name,uuid) VALUES (2,'Standard',null); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (1,1,1); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (2,1,2); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (3,1,3); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (4,1,4); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (5,1,5); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (6,1,6); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (7,1,8); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (8,1,9); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (9,1,11); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (10,1,14); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (11,1,15); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (12,2,10); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (13,2,12); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (14,2,13); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (15,2,16); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (16,2,17); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (17,2,18); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (18,2,19); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (19,2,20); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (20,1,21); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (21,2,22); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (22,2,23); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (23,2,24); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (24,2,25); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (25,1,26); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (26,1,27); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (27,1,28); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (28,1,29); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (29,2,30); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (30,1,31); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (31,1,32); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (32,1,33); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (33,1,34); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (34,1,35); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (35,1,36); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (36,1,37); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (37,1,38); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (38,1,39); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (39,1,40); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (40,1,41); 

INSERT INTO system_group_program (id,system_group_id,system_program_id) VALUES (41,1,42); 

INSERT INTO system_program (id,name,controller) VALUES (1,'System Group Form','SystemGroupForm'); 

INSERT INTO system_program (id,name,controller) VALUES (2,'System Group List','SystemGroupList'); 

INSERT INTO system_program (id,name,controller) VALUES (3,'System Program Form','SystemProgramForm'); 

INSERT INTO system_program (id,name,controller) VALUES (4,'System Program List','SystemProgramList'); 

INSERT INTO system_program (id,name,controller) VALUES (5,'System User Form','SystemUserForm'); 

INSERT INTO system_program (id,name,controller) VALUES (6,'System User List','SystemUserList'); 

INSERT INTO system_program (id,name,controller) VALUES (7,'Common Page','CommonPage'); 

INSERT INTO system_program (id,name,controller) VALUES (8,'System PHP Info','SystemPHPInfoView'); 

INSERT INTO system_program (id,name,controller) VALUES (9,'System ChangeLog View','SystemChangeLogView'); 

INSERT INTO system_program (id,name,controller) VALUES (10,'Welcome View','WelcomeView'); 

INSERT INTO system_program (id,name,controller) VALUES (11,'System Sql Log','SystemSqlLogList'); 

INSERT INTO system_program (id,name,controller) VALUES (12,'System Profile View','SystemProfileView'); 

INSERT INTO system_program (id,name,controller) VALUES (13,'System Profile Form','SystemProfileForm'); 

INSERT INTO system_program (id,name,controller) VALUES (14,'System SQL Panel','SystemSQLPanel'); 

INSERT INTO system_program (id,name,controller) VALUES (15,'System Access Log','SystemAccessLogList'); 

INSERT INTO system_program (id,name,controller) VALUES (16,'System Message Form','SystemMessageForm'); 

INSERT INTO system_program (id,name,controller) VALUES (17,'System Message List','SystemMessageList'); 

INSERT INTO system_program (id,name,controller) VALUES (18,'System Message Form View','SystemMessageFormView'); 

INSERT INTO system_program (id,name,controller) VALUES (19,'System Notification List','SystemNotificationList'); 

INSERT INTO system_program (id,name,controller) VALUES (20,'System Notification Form View','SystemNotificationFormView'); 

INSERT INTO system_program (id,name,controller) VALUES (21,'System Document Category List','SystemDocumentCategoryFormList'); 

INSERT INTO system_program (id,name,controller) VALUES (22,'System Document Form','SystemDocumentForm'); 

INSERT INTO system_program (id,name,controller) VALUES (23,'System Document Upload Form','SystemDocumentUploadForm'); 

INSERT INTO system_program (id,name,controller) VALUES (24,'System Document List','SystemDocumentList'); 

INSERT INTO system_program (id,name,controller) VALUES (25,'System Shared Document List','SystemSharedDocumentList'); 

INSERT INTO system_program (id,name,controller) VALUES (26,'System Unit Form','SystemUnitForm'); 

INSERT INTO system_program (id,name,controller) VALUES (27,'System Unit List','SystemUnitList'); 

INSERT INTO system_program (id,name,controller) VALUES (28,'System Access stats','SystemAccessLogStats'); 

INSERT INTO system_program (id,name,controller) VALUES (29,'System Preference form','SystemPreferenceForm'); 

INSERT INTO system_program (id,name,controller) VALUES (30,'System Support form','SystemSupportForm'); 

INSERT INTO system_program (id,name,controller) VALUES (31,'System PHP Error','SystemPHPErrorLogView'); 

INSERT INTO system_program (id,name,controller) VALUES (32,'System Database Browser','SystemDatabaseExplorer'); 

INSERT INTO system_program (id,name,controller) VALUES (33,'System Table List','SystemTableList'); 

INSERT INTO system_program (id,name,controller) VALUES (34,'System Data Browser','SystemDataBrowser'); 

INSERT INTO system_program (id,name,controller) VALUES (35,'System Menu Editor','SystemMenuEditor'); 

INSERT INTO system_program (id,name,controller) VALUES (36,'System Request Log','SystemRequestLogList'); 

INSERT INTO system_program (id,name,controller) VALUES (37,'System Request Log View','SystemRequestLogView'); 

INSERT INTO system_program (id,name,controller) VALUES (38,'System Administration Dashboard','SystemAdministrationDashboard'); 

INSERT INTO system_program (id,name,controller) VALUES (39,'System Log Dashboard','SystemLogDashboard'); 

INSERT INTO system_program (id,name,controller) VALUES (40,'System Session dump','SystemSessionDumpView'); 

INSERT INTO system_program (id,name,controller) VALUES (41,'Files diff','SystemFilesDiff'); 

INSERT INTO system_program (id,name,controller) VALUES (42,'System Information','SystemInformationView'); 

INSERT INTO system_unit (id,name,connection_name) VALUES (1,'Matriz','matriz'); 

INSERT INTO system_user_group (id,system_user_id,system_group_id) VALUES (1,1,1); 

INSERT INTO system_user_group (id,system_user_id,system_group_id) VALUES (2,2,2); 

INSERT INTO system_user_group (id,system_user_id,system_group_id) VALUES (3,1,2); 

INSERT INTO system_user_program (id,system_user_id,system_program_id) VALUES (1,2,7); 

INSERT INTO system_users (id,name,login,password,email,frontpage_id,system_unit_id,active,accepted_term_policy_at,accepted_term_policy) VALUES (1,'Administrator','admin','21232f297a57a5a743894a0e4a801fc3','admin@admin.net',10,null,'Y','',''); 

INSERT INTO system_users (id,name,login,password,email,frontpage_id,system_unit_id,active,accepted_term_policy_at,accepted_term_policy) VALUES (2,'User','user','ee11cbb19052e40b07aac0ca060c23ee','user@user.net',7,null,'Y','',''); 

INSERT INTO system_user_unit (id,system_user_id,system_unit_id) VALUES (1,1,1); 

SET IDENTITY_INSERT tipo ON; 

INSERT INTO tipo (id,descricao) VALUES (1,'Pessoal'); 

INSERT INTO tipo (id,descricao) VALUES (2,'Profissional'); 

SET IDENTITY_INSERT tipo OFF; 

SET IDENTITY_INSERT tipo_categoria ON; 

INSERT INTO tipo_categoria (id,descricao) VALUES (1,'Receita'); 

INSERT INTO tipo_categoria (id,descricao) VALUES (2,'Despesa'); 

SET IDENTITY_INSERT tipo_categoria OFF; 

SET IDENTITY_INSERT tipo_conta ON; 

INSERT INTO tipo_conta (id,descricao) VALUES (1,'Conta Corrente'); 

INSERT INTO tipo_conta (id,descricao) VALUES (2,'Conta Poupança'); 

INSERT INTO tipo_conta (id,descricao) VALUES (3,'Investimento'); 

INSERT INTO tipo_conta (id,descricao) VALUES (4,'Digital'); 

SET IDENTITY_INSERT tipo_conta OFF; 

SET IDENTITY_INSERT tipo_lancamento ON; 

INSERT INTO tipo_lancamento (id,descricao) VALUES (1,'Receita'); 

INSERT INTO tipo_lancamento (id,descricao) VALUES (2,'Despesa'); 

SET IDENTITY_INSERT tipo_lancamento OFF; 

SET IDENTITY_INSERT totaliza_receita_despesa ON; 

INSERT INTO totaliza_receita_despesa (id,descricao) VALUES (1,'Sim'); 

INSERT INTO totaliza_receita_despesa (id,descricao) VALUES (2,'Não'); 

SET IDENTITY_INSERT totaliza_receita_despesa OFF; 
