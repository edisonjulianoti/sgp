<?php

class AgendamentoService
{
   
    // Validação de recorrencia
    public static function validarRecorrencia($agendamento)
    {
        if($agendamento->recorrencia_id != Recorrencia::SEMRECORRENCIA){
            
            if(empty($agendamento->limite_recorrencia)){
                throw new Exception('Ao escolher uma recorrencia, o campo limite da recorrencia deve ser informado!');
            }
            
            if(empty($agendamento->considera_final_semana_id)){
                throw new Exception('Ao escolher uma recorrencia, o campo considera final de semana deve ser informado!');
            }
            
        }
        
    }
    
    // Verifica se uma data é sabado ou domingo!
    public static function verificarSeSabadoDomingo($data){
        
        $retorno = false;
        
        // Converte a data em timestamp
        $timestamp = strtotime($data);
         
        // Exibe informações sobre o timestamp passado como parâmetro
        $array_data = getdate($timestamp);
        
        if($array_data['weekday'] == 'Saturday' || $array_data['weekday'] == 'Sunday'){
          
          $retorno = true;
            
        }
         
         
        return $retorno;
        
    }
    
    
    public static function deletarAgendamentoFilho($object){
        
        $id_do_pai = 0;
        
        if(empty($object->agenda_id)){
           
           $id_do_pai = $object->id;
           
        }else{
            
            $id_do_pai = $object->agenda_id;
        }
      
   
        // Limpando todas as recorrencias para recriar
        Agendamento::where('agenda_id', '=', $id_do_pai)
                ->where('data_inicio', '>', $object->data_inicio)
                ->delete();
                
        return $id_do_pai;
        
    }
    
    
    public static function geraRecorrencia($object){
        
        if($object->recorrencia_id == Recorrencia::SEMRECORRENCIA){
            
            return;
        }
      
        $data_inicio = date('Y-m-d', strtotime($object->data_inicio ));
        $hora_inicio = date('H:i', strtotime($object->data_inicio ));
        
        $data_fim    = date('Y-m-d', strtotime($object->data_fim ));
        $hora_fim    = date('H:i', strtotime($object->data_fim ));
        
        $intervalo = DateService::retornaIntervaloEntreData($data_fim, $object->limite_recorrencia);
        
        $quantida_de_ocorrencias = $intervalo->days;
        
        $id_do_pai = self::deletarAgendamentoFilho($object);
                
        $recorrencia = new Recorrencia($object->recorrencia_id);
        
        $i = 1;
        $frequencia = 1;
        
        while ($i <= $quantida_de_ocorrencias){
            
            // limpo o id para gravar um objeto novo
            unset($object->id);
            
            $object->agenda_id = $id_do_pai;
            
            $frequencia = $i * $recorrencia->qtd_dia;
            
            $nova_data = strtotime("+{$frequencia} day", strtotime($data_fim));
            
            
            $nova_data = date('Y-m-d', $nova_data);
            
            // não deixar gravar apos a data limite
            
            $intervalo = DateService::retornaIntervaloEntreData( $nova_data, $object->limite_recorrencia);
         
            if($intervalo->invert == 1){
                return;
            }
            
            $object->data_inicio = $nova_data . ' '. $hora_inicio;
            
            $object->data_fim = $nova_data . ' '. $hora_fim;
            
            $final_semana = self::verificarSeSabadoDomingo($nova_data);
            
            if($object->considera_final_semana_id == ConsideraFinalSemana::SIM){
                
                $object->store();
               
            }else{
                
                if(!$final_semana){
                    
                     $object->store();
                }
                
            }
            
            $i++;
        }
        
    }
    
}
