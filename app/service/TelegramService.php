<?php

class TelegramService
{
    const IS_ATIVO = false; // trocar aqui para true quando estiver tudo configurado
    const URL = 'URL do seu sistema aqui../rest.php?class=TelegramService&method='; // exemplo: https://www.meusistema.com.br/rest.php?class=TelegramService&method=
    const BASIC_TOKEN = 'Basic definir rest key do projeto da api'; // exemplo: Basic eb8fwe7gf7wefhy923hg9e7gwe8fryweg
    
    const BOT_NAME = 'Definir o nome do bot aqui'; // exemplo: telegramBotNameBot
    
    public static function enviarMensagem($mensagem, $system_user_id)
    {
        try 
        {
            if(!self::IS_ATIVO)
            {
                return false;
            }
            
            BuilderHttpClientService::post(self::URL.'enviarMensagem', [
                'sistema' => 'pc',
                'mensagem' => $mensagem,
                'system_user_id' => $system_user_id
            ], self::BASIC_TOKEN);    
        } 
        catch (Exception $e) 
        {
            // aqui pode ser adicionado um log em base de dados caso de algum erro
            // para evitar "quebrar" a aplicação
            var_dump($e->getMessage());
        }
    }
    
    public static function getBotLink()
    {
        if(!self::IS_ATIVO)
        {
            return false;
        }
            
        $botName = self::BOT_NAME;
        
        $startParametros = base64_encode(json_encode([
            'sis' => 'pc', // sistema
            'uid' => TSession::getValue('userid') 
        ]));
        
        // existe uma limitação de quantidade de caracteres que o telegram aceita
        // para o parametro START que é de 64 caracteres...
        $link = "https://t.me/{$botName}?start={$startParametros}";
        
        return $link;
    }
}
