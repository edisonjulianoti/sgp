<?php

class UtilServiceAgenda
{
    public function __construct($param)
    {
        
    }
    
    public static function verificaSeSabadoDomingo($data){
        
        $retorno = 0;
        
        // Converte a data em timestamp
        $timestamp = strtotime($data);
         
        // Exibe informações sobre o timestamp passado como parâmetro
        $array_data = getdate($timestamp);
        
        
        
        if($array_data['weekday'] == 'Saturday' || $array_data['weekday'] == 'Sunday'){
          
          $retorno = 1;
            
        }
         
         
        return $retorno;
        
    }
    
    public static function geraRecorrenciaDiaria($object){
        
        $dia_inicio = date('d', strtotime($object->data_inicio ));
        
        $data_inicio = date('Y-m-d', strtotime($object->data_inicio ));
        $hora_inicio = date('H:i', strtotime($object->data_inicio ));
        
        $data_fim    = date('Y-m-d', strtotime($object->data_fim ));
        $hora_fim    = date('H:i', strtotime($object->data_fim ));
        
        $intervalo = UtilService::calculaIntervaloEntreData($data_fim, $object->limite_recorrencia);
        
        $quantida_de_ocorrencias = $intervalo->days;
        
        
        
        $id_do_pai = $object->agenda_id;
        
        // Limpando todas as recorrencias para recriar
        Agenda::where('agenda_id', '=', $id_do_pai)
                ->where('data_inicio', '>', $object->data_inicio)
                ->delete();
        
        $i = 1;
        
        while ($i <= $quantida_de_ocorrencias){
            
            // limpo o id para gravar um objeto novo
            $object->id = "";
            
            $object->agenda_id = $id_do_pai;
            
            if($object->recorrencia_id == Recorrencia::DIARIO){
                
                $nova_data = strtotime("+{$i} day", strtotime($data_fim));    
            }
            
            if($object->recorrencia_id == Recorrencia::SEMANAL){
                
                $frequencia = $i * 7;
                $nova_data = strtotime("+{$frequencia} day", strtotime($data_fim));    
            }
            
            if($object->recorrencia_id == Recorrencia::QUINZENAL){
                
                $frequencia = $i * 15;
                $nova_data = strtotime("+{$frequencia} day", strtotime($data_fim));    
            }
            
            if($object->recorrencia_id == Recorrencia::MENSAL){
                
                $frequencia = $i * 30;
                $nova_data = strtotime("+{$frequencia} day", strtotime($data_fim));    
            }
            
            if($object->recorrencia_id == Recorrencia::TRIMESTRAL){
                
                $frequencia = $i * 90;
                $nova_data = strtotime("+{$frequencia} day", strtotime($data_fim));    
            }
            
            if($object->recorrencia_id == Recorrencia::SEMESTRAL){
                
                $frequencia = $i * 180;
                $nova_data = strtotime("+{$frequencia} day", strtotime($data_fim));    
            }
            
            if($object->recorrencia_id == Recorrencia::ANUAL){
                
                $frequencia = $i * 365;
                $nova_data = strtotime("+{$frequencia} day", strtotime($data_fim));    
            }
            
            
            if($object->recorrencia_id == Recorrencia::PERSONALIZADA){
                
                $frequencia = $i * $object->dias_personalizado;
                $nova_data = strtotime("+{$frequencia} day", strtotime($data_fim));    
            }
            
            $nova_data = date('Y-m-d', $nova_data);
            
            $object->data_inicio = $nova_data . ' '. $hora_inicio;
            
            $object->data_fim = $nova_data . ' '. $hora_fim;
              
           
            
            if($object->recorrencia_id == Recorrencia::DIAESPECIFICO){
                
                $nova_data = strtotime("+{$i} day", strtotime($data_fim)); 
              
                $novo_dia = date('d', $nova_data);
                
                if($novo_dia == $dia_inicio){
                    
                    $nova_data = date('Y-m-d', $nova_data);
                    
                    // não deixar gravar apos a data limite
                    if($nova_data > $object->limite_recorrencia){
                        return;
                    }
                    
                    $object->data_inicio = $nova_data . ' '. $hora_inicio;
            
                    $object->data_fim = $nova_data . ' '. $hora_fim;
                    
                    $e_final_semana = self::verificaSeSabadoDomingo($nova_data);
                    
                    if($object->considera_final_semana_id == ConsideraFinalSemana::NAO){
                        
                        if($e_final_semana == 0){
                            
                             $object->store();
                        }
                        
                    }else{
                        
                        $object->store();
                    }
                    
                   
                
                }
               
                
               
            }else{
                
                 // não deixar gravar apos a data limite
                if($nova_data > $object->limite_recorrencia){
                    return;
                }
                
                $e_final_semana = self::verificaSeSabadoDomingo($nova_data);
         
                    
                if($object->considera_final_semana_id == ConsideraFinalSemana::NAO){
                    
                    if($e_final_semana == 0){
                        
                         $object->store();
                    }
                    
                }else{
                    
                    $object->store();
                }
            }
            
            
            
            
           
            
            $i++;
              
        }
        
        
    }
    
    
    
    public static function validaDataTela($data_inicio, $data_fim)
    {
        $intervalo = UtilService::calculaIntervaloEntreData($data_inicio, $data_fim);
        
        if($intervalo->invert > 0){
            throw new Exception("Data e hora fim deve ser igual ou posterior a data de início!");
        }
    }
    
    
    
    public static function validaDataParaRecorrencia($data_inicio, $data_fim)
    {
        $data_inicial = date('Y-m-d', strtotime($data_inicio));
       
        $data_final   = date('Y-m-d', strtotime($data_fim));
        
        $intervalo = UtilService::calculaIntervaloEntreData($data_inicial, $data_final);
        
        if($intervalo->days != 0){
            
            throw new Exception("Para recorrência, a data de inicio e fim devem ser as mesmas!");
        }
    }
    
    
    public static function validaDataLimite($data_inicio, $data_fim)
    {
        $intervalo = UtilService::calculaIntervaloEntreData($data_inicio, $data_fim);
       
        if($intervalo->invert == 0){
            
            throw new Exception("Data limite deve ser posterior a data fim!");
        }
    }
}
