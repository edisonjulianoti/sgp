<?php

class TemplateEmailService
{
    public static function parseTemplate($template_email_id, $object)
    {
        $templateEmail = new TemplateEmail($template_email_id);
        
        $templateEmail->titulo = str_replace('-&gt;', '->', $templateEmail->titulo);
        $templateEmail->conteudo = str_replace('-&gt;', '->', $templateEmail->conteudo);
        
        $templateEmail->titulo  = $object->render($templateEmail->titulo);
        $templateEmail->conteudo = $object->render($templateEmail->conteudo);
        
        return $templateEmail;
    }
}
