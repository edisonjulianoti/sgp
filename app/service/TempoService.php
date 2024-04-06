<?php

class TempoService
{
    public static function getMeses()
    {
        return [
            1=>'Janeiro',
            2=>'Fevereiro',
            3=>'Março',
            4=>'Abril',
            5=>'Maio',
            6=>'Junho',
            7=>'Julho',
            8=>'Agosto',
            9=>'Setembro',
            10=>'Outubro',
            11=>'Novembro',
            12=>'Dezembro'
        ];
    }
    
    public static function getAnos()
    {
        $anoAtual = date('Y');
        $anoAtual -= 5;
        $anos = [];
        for($anoAtual; $anoAtual <= date('Y'); $anoAtual++)
        {
            $anos[$anoAtual] = $anoAtual;
        }
        
        for($anoAtual; $anoAtual <= date('Y') + 5; $anoAtual++)
        {
            $anos[$anoAtual] = $anoAtual;
        }
        
        return $anos;
    }
}
