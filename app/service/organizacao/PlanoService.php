<?php

class PlanoService
{
    
    public static function validarDataPrevisão($data_previsao)
    {
        $hoje = date('Y-m-d');
        
        $intervalo = DateService::retornaIntervaloEntreData($hoje, $data_previsao);

        // Verificando se a data de previsão é anterior a data atual.
        if($intervalo->invert == 1){

        	$mensagem = "Data de previsão não pode ser anterior a data atual!";
        	
        	throw new Exception($mensagem);
        }
    }
}
