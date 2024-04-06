<?php

class UtilServiceCron
{
    public function __construct($param)
    {
        
    }
    
    public static function reprocessaFaturasPagueSeguro($param = null){
        
        TTransaction::open('bd_financeiro');
        
        $hoje = date('Y-m-d');
        
        $qtd_dias = 15;
        
        $data_inicio_processamento = date('Y-m-d',strtotime("-{$qtd_dias} day", strtotime($hoje)));
        
        
        $faturas = Fatura::where('status_fatura_id','!=', 4)->where('data_pagamento', '>=', $data_inicio_processamento)->load();
        
        if($faturas){
            
            foreach ($faturas as $key => $fatura) {
                
                $param['numero_pedido'] = $fatura->numero_pedido;
                
                $transacao_pague_seguro = UtilServicePagueSeguro::consultarTransacao($param);
                
                if($transacao_pague_seguro->resultsInThisPage != "0"){
                    
                    // Se já existir transação no pague segura tenta atualizar a fatura.
                    UtilServicePagueSeguro::atualizaStatusFatura($fatura, $transacao_pague_seguro);
                }
            }
            
        }
        
        
        TTransaction::close();
         
    }

    
    public static function processaPagamentosPagueSeguro($param = null){
        
        TTransaction::open('bd_financeiro');
        
        $faturas = Fatura::where('status_fatura_id','in', [1,2])->load();
        
        if($faturas){
            
            foreach ($faturas as $key => $fatura) {
                
                $param['numero_pedido'] = $fatura->numero_pedido;
                
                $transacao_pague_seguro = UtilServicePagueSeguro::consultarTransacao($param);
                
                if($transacao_pague_seguro->resultsInThisPage != "0"){
                    
                    // Se já existir transação no pague segura tenta atualizar a fatura.
                    UtilServicePagueSeguro::atualizaStatusFatura($fatura, $transacao_pague_seguro);
                }
            }
            
        }
        
        
        TTransaction::close();
         
    }
    
    
    public static function teste(){
        
        TTransaction::open('bd_financeiro');
        
        $hora_lemtrete = self::getHoraParaNotificar(5);
        
        UtilService::imprime($hora_lemtrete);
        
        // teste
        $agendas = Agenda::where('data_inicio', '=', $hora_lemtrete)->load();
        
        TTransaction::close();
        
        UtilService::imprime($agendas);
    }
    
    public static function getHoraParaNotificar($minutos){
        
        $agora = date('Y-m-d H:i');
        
        $hora_para_notificar = date('Y-m-d H:i',strtotime("+{$minutos} minutes", strtotime($agora)));
        
        return $hora_para_notificar.":00";
    }
    
    public static function notificaCompromisso($param = null)
    {
        
        try {
           
                TTransaction::open('bd_financeiro');
            
                    $empresas = self::getIdOneSignalNotificar();
                    
                    if($empresas && count($empresas) > 0){
                       
                  
                        foreach ($empresas as $key => $empresa_id) {
                            
                            $lembretes = LembreteAgenda::all();
                            
                            foreach ($lembretes as $lembrete){
                                
                                $hora_lemtrete = self::getHoraParaNotificar($lembrete->minutos);
                                
                                $agendas = Agenda::where('lembrete_agenda_id', '=', $lembrete->id)
                                                  ->where('empresa_id', '=', $empresa_id)
                                                  ->where('data_inicio', '=', $hora_lemtrete)->load();
                                                  
                                if($agendas && count($agendas) > 0){
                                    
                                    foreach ($agendas as $agenda) {
                                        
                                        // pegando o usuario da agenda para enviar a mensagem whatsapp
                                        $cliente = Cliente::where('user_id', '=', $agenda->user_id)->first();
                                        
                                        $destinatarios = array();
                                        
                                        $lista_usuarios = UsuarioOnesignal::where('empresa_id', '=', $empresa_id)->load();
                                        
                                        if($lista_usuarios && count($lista_usuarios) > 0){
                                            
                                            foreach ($lista_usuarios as $usuario) {
                                                
                                                if($usuario->user_id == $agenda->user_id){
                                                    
                                                    array_push($destinatarios, $usuario->onesignal_id);
                                                      
                                                    
                                                }
                                                
                                                
                                            }
                                        }
                                        
                                        
                                        if(count($destinatarios) > 0){
                                            
                                            $mensagem = "O Compromisso " .$agenda->titulo ." " .$lembrete->mensagem;
                                            $link = "https://teempo.app.br/index.php?class=AgendaCalendarFormView";
                                           
                                            $response = UtilServiceNotificacao::sendMessage($mensagem, $link, $destinatarios);
                                            
                                            if($cliente && !empty($cliente->telefone) && $cliente->receber_whatsapp_id == ReceberWhatsapp::SIM){
                                                
                                                $link_curto = UtilService::encurtarUrl($link);
                                                
                                                $link = ($link_curto && array_key_exists('shortUrl',$link_curto)) ? $link_curto['shortUrl'] : $link;
                                                
                                                // quebrando uma linha na mensagem do whatsapp
                                                $mensagem = $mensagem ."\n{$link}";
                                                
                                                
                                                $nome_destinatario = $cliente->nome;
                                                $telefone_destinatario = $cliente->telefone;
                                                $titulo_mensagem = "Notificação de compromisso";
                                                $email_destinatario = $cliente->email;
                                                
                                                if(!empty($telefone_destinatario)){
                                                    WhatsAppService::enviaMensagemTexto($nome_destinatario, $telefone_destinatario, $titulo_mensagem, $mensagem, $email_destinatario);        
                                                }
                                                
                                                 
                                           }
                                            
                                        }
                                        
                                       
                                       
                                       
                                        $destinatarios = null;
                                        
                                       
                                        
                                    }
                                    
                                
                                }
                                
                            }
                            
                            
                            
                        }
                        
                    }
                
                 TTransaction::close();
                 
                 return $empresas;
        
            } catch (Exception $e) {
                
                
                TTransaction::rollback();
                return $e;
            }
        
    }
    
    
    public static function notificaTarefasDodia($param = null)
    {
        
        try {
            
                TTransaction::open('bd_financeiro');
            
                    $empresas = self::getIdOneSignalNotificar();
                    
                    if($empresas && count($empresas) > 0){
                  
                        foreach ($empresas as $key => $empresa_id) {
                            
                            $tarefas_dia = UtilServiceDashboard::getTarefasDia($empresa_id);
                            
                            $clientes = Cliente::where('empresa_id', '=', $empresa_id)->load();
                            
                            if($tarefas_dia > 0){
                                
                                $destinatarios = array();
                                
                                $lista_usuarios = UsuarioOnesignal::where('empresa_id', '=', $empresa_id)->load();
                                
                                if($lista_usuarios && count($lista_usuarios) > 0){
                                    
                                    foreach ($lista_usuarios as $usuario) {
                                        array_push($destinatarios, $usuario->onesignal_id);
                                    }
                                }
                                
                                
                                if($tarefas_dia == 1){
                                    
                                    $mensagem = "Você tem {$tarefas_dia} tarefa para executar hoje!";
                                    
                                }else {
                                    
                                    $mensagem = "Você tem {$tarefas_dia} tarefas para executar hoje!";
                                }
                                
                                
                                if(count($destinatarios) > 0){
                                    
                                     $link = "https://teempo.app.br/index.php?class=TarefaList&method=onShow";
                                
                                    $response = UtilServiceNotificacao::sendMessage($mensagem, $link, $destinatarios);
                                    
                                    
                                }
                                
                                
                                if($clientes){
                                    
                                    foreach ($clientes as $key => $cliente) {
                                        
                                        $link_curto = UtilService::encurtarUrl($link);
                                                
                                        $link = ($link_curto && array_key_exists('shortUrl',$link_curto)) ? $link_curto['shortUrl'] : $link;
                                        
                                        // quebrando uma linha na mensagem do whatsapp
                                        $mensagem = $mensagem ."\n{$link}";
                                        
                                        $nome_destinatario = $cliente->nome;
                                        $telefone_destinatario = $cliente->telefone;
                                        $titulo_mensagem = "Notificação de tarefa";
                                        $email_destinatario = $cliente->email;
                                        
                                        if($cliente && !empty($cliente->telefone) && $cliente->receber_whatsapp_id == ReceberWhatsapp::SIM){
                                            
                                            WhatsAppService::enviaMensagemTexto($nome_destinatario, $telefone_destinatario, $titulo_mensagem, $mensagem, $email_destinatario);        
                                        }
                                    }
                                }
                             
                               
                                
                                $destinatarios = null;
                            }
                            
                        }
                        
                    }
                
                 TTransaction::close();
                 
                 return $empresas;
        
            } catch (Exception $e) {
                
                
                TTransaction::rollback();
                return $e;
            }
        
    }
    
    public static function notificaDespesasVencidas($param = null)
    {
        
        try {
            
                TTransaction::open('bd_financeiro');
            
                    $empresas = self::getIdOneSignalNotificar();
                    
                    if($empresas && count($empresas) > 0){
                  
                        foreach ($empresas as $key => $empresa_id) {
                            
                            $contas      = UtilServiceDashboard::getContasDashboard($empresa_id);
                            $catergorias = UtilServiceDashboard::getCategoriasDashboard($empresa_id);
                            
                            $clientes = Cliente::where('empresa_id', '=', $empresa_id)->load();
                            
                            // Carregando despesas vencendo hoje
                            $total_despesas_vencidas = number_format(UtilServiceDashboard::getDespesasVencidas($contas, $catergorias, $empresa_id),2,',','.');
                            
                            if($total_despesas_vencidas > 0){
                                
                                $destinatarios = array();
                                
                                $lista_usuarios = UsuarioOnesignal::where('empresa_id', '=', $empresa_id)->load();
                                
                                if($lista_usuarios && count($lista_usuarios) > 0){
                                    
                                    foreach ($lista_usuarios as $usuario) {
                                        array_push($destinatarios, $usuario->onesignal_id);
                                    }
                                }
                                
                                
                                if(count($destinatarios) > 0){
                                    
                                    $mensagem = "Você tem um total de R$ {$total_despesas_vencidas} em despesas vencidas, fique atento com os juros!";
                                
                             
                                    $link = "https://teempo.app.br/index.php?class=ContaPagarList&method=onShow&dashboard=despesas_vencidas";
                                  
                                    $response = UtilServiceNotificacao::sendMessage($mensagem, $link, $destinatarios);
                                    
                                    
                                }
                                
                                if($clientes){
                                    
                                    foreach ($clientes as $key => $cliente) {
                                        
                                        $link_curto = UtilService::encurtarUrl($link);
                                                
                                        $link = ($link_curto && array_key_exists('shortUrl',$link_curto)) ? $link_curto['shortUrl'] : $link;
                                        
                                        // quebrando uma linha na mensagem do whatsapp
                                        $mensagem = $mensagem ."\n{$link}";
                                                
                                        $nome_destinatario = $cliente->nome;
                                        $telefone_destinatario = $cliente->telefone;
                                        $titulo_mensagem = "Notificação de Despesa Vencida";
                                        $email_destinatario = $cliente->email;
                                        
                                        if($cliente && !empty($cliente->telefone) && $cliente->receber_whatsapp_id == ReceberWhatsapp::SIM){
                                            
                                            WhatsAppService::enviaMensagemTexto($nome_destinatario, $telefone_destinatario, $titulo_mensagem, $mensagem, $email_destinatario);        
                                        }
                                    }
                                }
                                
                                
                               
                                
                                $destinatarios = null;
                            }
                            
                        }
                        
                    }
                
                 TTransaction::close();
                 
                 return $empresas;
        
            } catch (Exception $e) {
                
                
                TTransaction::rollback();
                return $e;
            }
        
    }
    
    public static function notificaDespesasVencendoHoje($param = null)
    {
        
        try {
            
                TTransaction::open('bd_financeiro');
            
                    $empresas = self::getIdOneSignalNotificar();
                    
                    if($empresas && count($empresas) > 0){
                  
                        foreach ($empresas as $key => $empresa_id) {
                            
                            $contas      = UtilServiceDashboard::getContasDashboard($empresa_id);
                            $catergorias = UtilServiceDashboard::getCategoriasDashboard($empresa_id);
                            
                            $clientes = Cliente::where('empresa_id', '=', $empresa_id)->load();
                            
                            // Carregando despesas vencendo hoje
                            $total_despesas_vencendo_hoje = number_format(UtilServiceDashboard::getDespesasVencendoHoje($contas, $catergorias, $empresa_id),2,',','.');
                            
                            if($total_despesas_vencendo_hoje > 0){
                                
                                $destinatarios = array();
                                
                                $lista_usuarios = UsuarioOnesignal::where('empresa_id', '=', $empresa_id)->load();
                                
                                if($lista_usuarios && count($lista_usuarios) > 0){
                                    
                                    foreach ($lista_usuarios as $usuario) {
                                        array_push($destinatarios, $usuario->onesignal_id);
                                    }
                                }
                                
                                
                                if(count($destinatarios) > 0){
                                    
                                    $mensagem = "Você tem um total de R$ {$total_despesas_vencendo_hoje} em despesas vencendo hoje!";
                                
                             
                                    $link = "https://teempo.app.br/index.php?class=ContaPagarList&method=onReload&dashboard=vencendo_hoje";
                             
                                    $response = UtilServiceNotificacao::sendMessage($mensagem, $link, $destinatarios);
                                    
                                    
                                }
                                
                                if($clientes){
                                    
                                    foreach ($clientes as $key => $cliente) {
                                        
                                        $link_curto = UtilService::encurtarUrl($link);
                                                
                                        $link = ($link_curto && array_key_exists('shortUrl',$link_curto)) ? $link_curto['shortUrl'] : $link;
                                        
                                        // quebrando uma linha na mensagem do whatsapp
                                        $mensagem = $mensagem ."\n{$link}";
                                        
                                        $nome_destinatario = $cliente->nome;
                                        $telefone_destinatario = $cliente->telefone;
                                        $titulo_mensagem = "Notificação de Despesa de Hoje";
                                        $email_destinatario = $cliente->email;
                                        
                                        if($cliente && !empty($cliente->telefone) && $cliente->receber_whatsapp_id == ReceberWhatsapp::SIM){
                                            
                                            WhatsAppService::enviaMensagemTexto($nome_destinatario, $telefone_destinatario, $titulo_mensagem, $mensagem, $email_destinatario);        
                                        }
                                    }
                                }
                                
                                
                                
                                $destinatarios = null;
                            }
                            
                        }
                        
                    }
                
                 TTransaction::close();
                 
                 return $empresas;
        
            } catch (Exception $e) {
                
                
                TTransaction::rollback();
                return $e;
            }
        
    }
    
    
    
    
    
    public static function getIdOneSignalNotificar($param = null){
        
            try {
                 $empresas = UsuarioOnesignal::where('id', '>', 0)->groupBy('empresa_id')->getIndexedArray('empresa_id','empresa_id');
                  return $empresas;
            } catch (Exception $e) {
                
                echo $e->getMessage() ;
            }
    
    }
}
