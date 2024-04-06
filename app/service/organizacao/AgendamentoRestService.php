<?php

class AgendamentoRestService extends AdiantiRecordService
{
    const DATABASE      = 'bd_sgp';
    const ACTIVE_RECORD = 'Agendamento';
    const ATTRIBUTES    = ['agenda_id','considera_final_semana_id','data_fim','data_inicio','descricao','dias_personalizado','id','lembrete_agenda_id','limite_recorrencia','plano_id','recorrencia_id','relevancia_id','system_users_id','tipo_id','titulo'];
    
    public function notificarAgendamento($param){
        
        return NotificacaoService::notificarAgendamento($param);
    }
}
