<?php

class GuiaService
{
    public static function verificaGuiasExpirando()
    {
        TTransaction::open('portal');
        
        $hoje = new DateTime(date('Y-m-d')); // 2023-03-16
        $hoje->modify('+1 day');
        $amanha = $hoje->format('Y-m-d'); // 2023-03-17
        
        $guias = Guia::where('data_vencimento', '=', $amanha)->where('downloaded', '=', 'F')->load();
        
        if($guias)
        {
            foreach($guias as $guia)
            {
                if($guia->cliente->email)
                {
                    $templateEmail = TemplateEmailService::parseTemplate(TemplateEmail::GUIA_EXPIRANDO, $guia);
                    FilaEmailService::adicionaNaFila([$guia->cliente->email], $templateEmail->titulo, $templateEmail->conteudo, 'GUIA EXPIRANDO');
                }
            }
        }
        
        TTransaction::close();
    }
}
