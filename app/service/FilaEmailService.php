<?php

class FilaEmailService
{
    
    public static function adicionaNaFila($destinatarios, $titulo, $conteudo, $tipo_origem, $arquivos = [])
    {
        $filaEmail = new FilaEmail();
        
        $filaEmail->destinatarios = implode(',', $destinatarios);
        $filaEmail->titulo = $titulo;
        $filaEmail->conteudo = $conteudo;
        $filaEmail->tipo_origem = $tipo_origem;
        $filaEmail->arquivos = implode(',', $arquivos);
        $filaEmail->fila_email_status_id = FilaEmailStatus::AGUARDANDO;
        $filaEmail->tentativas_envio = 0;
        
        $filaEmail->store();
    }
    
    public static function send($fila_email_id)
    {
        $filaEmail = new FilaEmail($fila_email_id);
        
        if($filaEmail->fila_email_status_id == FilaEmailStatus::AGUARDANDO || $filaEmail->fila_email_status_id == FilaEmailStatus::ERRO || $filaEmail->fila_email_status_id == FilaEmailStatus::ENVIANDO)
        {
            $arquivos = [];
            
            $filaEmail->tentativas_envio++;
            if($filaEmail->arquivos)
            {
                $arquivosExploded = explode(',', $filaEmail->arquivos);
                
                foreach($arquivosExploded as $arquivoExploded)
                {
                    $pedacos = explode('/', $arquivoExploded);
                    $nomeArquivo = end($pedacos);
                    $arquivos[] = [$arquivoExploded, $nomeArquivo];
                }
            }
            
            try 
            {
                $filaEmail->data_envio = date('Y-m-d H:i:s');
                
                MailService::send($filaEmail->destinatarios, $filaEmail->titulo, $filaEmail->conteudo, 'html', $arquivos);    
                
                $filaEmail->fila_email_status_id = FilaEmailStatus::ENVIADO;
                $filaEmail->store();
            } 
            catch (Exception $e) 
            {
                $filaEmail->erro = $e->getMessage();
                $filaEmail->fila_email_status_id = FilaEmailStatus::ERRO;
                $filaEmail->store();
            }
            
        }
    }
    
    public static function processaFila()
    {
        TTransaction::open('portal');
        
        $emails = FilaEmail::where('fila_email_status_id', 'in', [FilaEmailStatus::ERRO, FilaEmailStatus::AGUARDANDO])->load();
        
        if($emails)
        {
            foreach($emails as $email)
            {
                // trocamos o status para enviando
                $email->fila_email_status_id = FilaEmailStatus::ENVIANDO;
                $email->store();
            }    
        }
        
        TTransaction::close();
        
        if($emails)
        {
            TTransaction::open('portal');
            foreach($emails as $email)
            {
                self::send($email->id);
            }    
            
            TTransaction::close();
        }
    }
    
}
