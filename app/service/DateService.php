<?php

class DateService
{
     //  Metodo retorna um objeto da classe DateInterval a partir da diferença entre duas datas
     public static function retornaIntervaloEntreData($data_inicio, $data_fim){
     
        // Instância um objeto DateTime passando a data 1
		$datetime1 = new DateTime($data_inicio);
		
		// Instância um objeto DateTime passando a data 2
		$datetime2 = new DateTime($data_fim);
		
		// Captura a diferença entre a data 1 e a data 2
		$interval = $datetime1->diff($datetime2);
	 
		return $interval;
    	
    }
    
    public static function retornarDataFormatoBanco($data){
        
        if(empty($data)){
            return "";
        }
        
        $array = explode('/', $data);
        
        $data_formatada = $array[2] .'-'. $array[1] .'-'. $array[0];
        
        return $data_formatada;
    }
}
