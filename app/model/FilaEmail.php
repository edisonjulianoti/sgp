<?php

class FilaEmail extends TRecord
{
    const TABLENAME  = 'fila_email';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATEDAT  = 'criado_em';

    private $fila_email_status;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('fila_email_status_id');
        parent::addAttribute('titulo');
        parent::addAttribute('conteudo');
        parent::addAttribute('arquivos');
        parent::addAttribute('destinatarios');
        parent::addAttribute('tentativas_envio');
        parent::addAttribute('tipo_origem');
        parent::addAttribute('erro');
        parent::addAttribute('data_envio');
        parent::addAttribute('criado_em');
            
    }

    /**
     * Method set_fila_email_status
     * Sample of usage: $var->fila_email_status = $object;
     * @param $object Instance of FilaEmailStatus
     */
    public function set_fila_email_status(FilaEmailStatus $object)
    {
        $this->fila_email_status = $object;
        $this->fila_email_status_id = $object->id;
    }

    /**
     * Method get_fila_email_status
     * Sample of usage: $var->fila_email_status->attribute;
     * @returns FilaEmailStatus instance
     */
    public function get_fila_email_status()
    {
    
        // loads the associated object
        if (empty($this->fila_email_status))
            $this->fila_email_status = new FilaEmailStatus($this->fila_email_status_id);
    
        // returns the associated object
        return $this->fila_email_status;
    }

    
}

