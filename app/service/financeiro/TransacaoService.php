<?php

class TransacaoService
{
    // Metodo deve ser chamado dentro de uma transação - Retorna um array com  o saldo e a data inicial para calculo do(s) Lançamentos
    //(Ultima transação ou Saldo inicial da conta)
    public static function retornarSaldoDataInicialCalculo($lancamento)
    {
       $user_id         = $lancamento->system_users_id;
       $conta_id        = $lancamento->conta_id;
       $data_lancamento = $lancamento->pagamento;
        
        $retorno = [];
        
        /*
        
            Essa select cobre o seguinte cenário: 
            Exemplo: Usuário gravou um lançamento com data 03/08/2022, porem já existem movimentos do dia 01/08 e 02/08 calculados.
            Select irá retornar a transação anterior a data do lançamento.
        
        */
  
        $transacao = Transacao::where('data_transacao','<',$data_lancamento)->
                    where('system_users_id','=', $user_id)->
                    where('conta_id', '=', $conta_id)->
                    orderBy('data_transacao desc, id ','asc')->first();
      
       
        if($transacao){
            
            $retorno['data_saldo']  = $transacao->data_transacao;
            $retorno['saldo']       = $transacao->saldo_final;
            return $retorno;
        }
        
        
        /*
        
            Essa select cobre o seguinte cenário:
            Quando a data do lançamento for anterior a data da primeira transação ou se ainda não existir transação (Primeiro calculo).
        
        */
        
        
       $conta = Conta::where('system_users_id', '=', $user_id)->where('id', '=', $conta_id)->first();
        
      
        if($conta){
            
            $retorno['data_saldo']  = $conta->data_saldo_inicial;
            $retorno['saldo']       = $conta->saldo_inicial;
            return $retorno;
           
        }
        
        if(count($retorno) == 0){
            throw new Execption('Ocorreu um problema para obter informações da data inicial ou saldo inicial para processamento');
        }
        
    }
    
    // Metodo deve ser chamado dentro de uma transação
    public static function processarTransacao($lancamento, $data_saldo_inicial, $saldo_final_anterior){
         
         $novo_saldo_final = 0;
         $user_id   = $lancamento->system_users_id;
         $conta_id  = $lancamento->conta_id;
         
          // Gravo a Transacao do lançamento atual e pego a transação gerada.
         $nova_transacao = self::salvarTransacao($lancamento, $saldo_final_anterior);
         
         // pego saldo da transação que foi inserida no processo anterior.
         $novo_saldo_final = $nova_transacao->saldo_final;
         
         // atualizo status do lançamento. 
         $lancamento->status_lancamento_id = StatusLancamento::PAGO;
         $lancamento->store();
         
         // Pegando as demais transações para atualizar informações.
         $transacoes = Transacao::where('system_users_id', '=', $user_id)
                                    ->where('conta_id', '=', $conta_id)
                                    ->where('id', '!=', $nova_transacao->id)
                                    ->where('data_transacao', '>', $data_saldo_inicial)
                                    ->orderBy('data_transacao, id', 'desc')->load();
                    
        
        if($transacoes){
            
         
            // atualizo as transações posteriores
            foreach ($transacoes as $transacao)
            {
                
                // Calculando o final para transação
                $saldo_final_transacao = self::calcularSado($transacao, $novo_saldo_final);
                
                
            	$transacao->saldo_anterior = $novo_saldo_final;
            	$transacao->valor          = $transacao->lancamento->valor;
            	$transacao->saldo_final    = $saldo_final_transacao;
            	$transacao->store();
            	
            	
            	// Calculando o novo saldo anterior para proxima transação
                $novo_saldo_final = self::calcularSado($transacao, $novo_saldo_final);
                
              	// atualizo saldo da conta.
                self::atualizarConta($conta_id, $novo_saldo_final);
            }

        }else{
             // atualizar saldo da conta
            self::atualizarConta($conta_id, $novo_saldo_final); 
        }
        
        
        
     }
     
     
     private static function calcularSado($transacao, $saldo){
        
        $novo_saldo = 0; 
        
        if($transacao->lancamento->tipo_lancamento_id == TipoLancamento::RECEITA){
                    
            $novo_saldo = $saldo + $transacao->lancamento->valor;
        }else{
            
            $novo_saldo = $saldo - $transacao->lancamento->valor;
        }
        
        
        return $novo_saldo;
     }
     
     
     
     private static function salvarTransacao($lancamento,  $saldo_final_anterior){
         
         $saldo_final = 0;
         
         if($lancamento->tipo_lancamento_id == TipoLancamento::RECEITA){
            	    
    	    $saldo_final = $saldo_final_anterior + $lancamento->valor;
    	 }else{
    	    
    	    $saldo_final = $saldo_final_anterior - $lancamento->valor;
	     }   
         
         $obj_transacao                     = new Transacao();
         $obj_transacao->data_transacao     = $lancamento->pagamento;
         $obj_transacao->conta_id           = $lancamento->conta_id;
         $obj_transacao->saldo_anterior     = $saldo_final_anterior;
         $obj_transacao->valor              = $lancamento->valor;
         $obj_transacao->saldo_final        = $saldo_final;
         $obj_transacao->lancamento_id      = $lancamento->id;
         $obj_transacao->system_users_id    = $lancamento->system_users_id;
         $obj_transacao->store();
         
         
         return $obj_transacao;
        
     }
     
     private static function atualizarConta($conta_id, $saldo){
         
         $conta                         = new Conta($conta_id);
         $conta->saldo_atual            = $saldo;
         $conta->saldo_calculado_id     = SaldoCalculado::SIM;
         $conta->store();
         
         
     }
     
}
