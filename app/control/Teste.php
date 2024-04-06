<?php

class Teste extends TPage
{
    public function __construct($param)
    {
        parent::__construct();
    }
    
    // função executa ao clicar no item de menu
    public function onShow($param = null)
    {
        TTransaction::open("bd_sgp");
        
        $conta = new Conta(1);
        $conta->saldo_calculado_id = SaldoCalculado::NAO;
        $conta->saldo_atual = 3000;
        
        $conta->store();
        
        var_dump($conta);
        
        TTransaction::close();
        
    }
    
    public function intevaloMensal($param = null){
        
        
        $data = new DateTime('2022-01-10');
        $intervalo = new DateInterval('P1M');
        
        for ($i = 1; $i <= 2; $i++){
            
            $data->add($intervalo);
            echo $data->format('d/m/Y')."<br>";
        }
       
    }
    
    public function onShowInterval($param = null){
        
    	$hoje = date('Y-m-d');
    	
    	var_dump("Data de hoje - " .$hoje);
    	
    	$data_informada = $param['data_saldo'];
    	
    	var_dump("Data de Informada - " .$data_informada);
    	
    	$intervalo = DateService::retornaIntervaloEntreData($hoje, $data_informada);
    	
    	var_dump($intervalo);
    }
   
    
}
