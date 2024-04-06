<?php

class LancamentoService
{
    
   
    
    // Metodo deve ser chamado em uma transação.
    public static function gerarParcelas($lancamento, $dados_formulario){
        
        $quantidade_parcela         = $dados_formulario->quantidade_parcela;
        $vencimento                 = $dados_formulario->vencimento;
        $descricao                  = $dados_formulario->descricao;
        
        
        $data = new DateTime($vencimento);
          
        $intervalo = new DateInterval('P1M');
 
        for ($i = 1; $i < $quantidade_parcela; $i++){
            
            unset($lancamento->id);
            
            $parcela = $i + 1;
            
            $lancamento->descricao = $descricao . " - (Parcela {$parcela})" ;
            
            $lancamento->status_lancamento_id = StatusLancamento::ABERTO;
            
            $data->add($intervalo);
            
            $lancamento->vencimento = $data->format('Y-m-d'); ;
            
            $lancamento->store();
         
        }
        
    }
    
    public static function validarDataPagamento($lancamento){
        
        $mensagem = '';
        
        $hoje = date('Y-m-d');
        
        $data_pagamento             = $lancamento->pagamento;
        
        $data_saldo_inicial_conta   = $lancamento->conta->data_saldo_inicial;

        $intervalo = DateService::retornaIntervaloEntreData($hoje, $data_pagamento);

        // Verificando se a data informada está no futuro
        if($intervalo->invert == 0 && $intervalo->days > 0){

        	$mensagem = "Data de pagamento não pode ser posterior a data atual!";
        	
        	throw new Exception($mensagem);
        }
        
        $intervalo = DateService::retornaIntervaloEntreData($data_saldo_inicial_conta, $data_pagamento);

        // Verificando se a data de vencimento é anterior a data do saldo inicial da conta.
        if($intervalo->invert == 1){

        	$mensagem = "Data de pagamento não pode ser anterior a data inicial de uma das contas!";
        	
        	throw new Exception($mensagem);
        }
        
    }
}








