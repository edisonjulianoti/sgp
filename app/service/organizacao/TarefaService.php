<?php

class TarefaService
{
    public static function validarDataConclusao($data_conclusao)
    {
        $hoje = date('Y-m-d');
        
        $intervalo = DateService::retornaIntervaloEntreData($hoje, $data_conclusao);

        // Verificando se a data de previsão é anterior a data atual.
        if($intervalo->invert == 1){

        	$mensagem = "Data de conclusão não pode ser anterior a data atual!";
        	
        	throw new Exception($mensagem);
        }
    }
}
