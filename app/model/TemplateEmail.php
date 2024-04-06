<?php

class TemplateEmail extends TRecord
{
    const TABLENAME  = 'template_email';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const NOVA_GUIA = '1';
    const NOVO_DOCUMENTO = '2';
    const GUIA_EXPIRANDO = '3';
    const NOVO_ATENDIMENTO = '4';
    const NOVA_INTERACAO_CLIENTE = '5';
    const NOVA_INTERACAO_ATENDENTE = '6';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('titulo');
        parent::addAttribute('conteudo');
            
    }

    
}

