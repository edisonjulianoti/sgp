<?php

class NotificacaoService
{
    public static function obterHoraParaNotificar($minutos){
        
        $agora = date('Y-m-d H:i');
        
        $hora_para_notificar = date('Y-m-d H:i',strtotime("+{$minutos} minutes", strtotime($agora)));
        
        return $hora_para_notificar;
    }
    
    
    public static function notificarAgendamento($param = null){
        
        
        TTransaction::openFake('bd_sgp');
        
        $contador = 0;

        $lembretes = LembreteAgenda::all();
        
        foreach ($lembretes as $key => $lembrete) {
            
            $mensagem_lembrete = $lembrete->mensagem;
            
            $hora_lemtrete = self::obterHoraParaNotificar($lembrete->minutos);
            
            $agendamentos = Agendamento::where('lembrete_agenda_id', '=', $lembrete->id)
                                  ->where('data_inicio', '=', $hora_lemtrete)->load();
                                  
                                  
            if($agendamentos){
                
                foreach ($agendamentos as $key => $agendamento) {
                
                    $user_id = $agendamento->system_users_id; // id do usuário que receberá a notificação
                    $notificationParam = [];
                    $icon = 'fas fa-calendar-alt';
                    
                    $titulo = $agendamento->titulo . " - " . $mensagem_lembrete;
                    
                    SystemNotification::register( $user_id, $titulo, $agendamento->descricao, new TAction(['AgendamentoCalendarFormView', 'onReload'], $notificationParam), 'Agendamento', $icon);

                    $contador++;
                }
                
                
            }
        }

        TTransaction::close();
        
        return ['notificacao' => $contador];
        
    }
}
