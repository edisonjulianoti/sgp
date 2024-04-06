<?php

class FilaEmailStatus extends TRecord
{
    const TABLENAME  = 'fila_email_status';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const AGUARDANDO = '1';
    const ENVIANDO = '2';
    const ENVIADO = '3';
    const ERRO = '4';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
            
    }

    /**
     * Method getFilaEmails
     */
    public function getFilaEmails()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('fila_email_status_id', '=', $this->id));
        return FilaEmail::getObjects( $criteria );
    }

    public function set_fila_email_fila_email_status_to_string($fila_email_fila_email_status_to_string)
    {
        if(is_array($fila_email_fila_email_status_to_string))
        {
            $values = FilaEmailStatus::where('id', 'in', $fila_email_fila_email_status_to_string)->getIndexedArray('id', 'id');
            $this->fila_email_fila_email_status_to_string = implode(', ', $values);
        }
        else
        {
            $this->fila_email_fila_email_status_to_string = $fila_email_fila_email_status_to_string;
        }

        $this->vdata['fila_email_fila_email_status_to_string'] = $this->fila_email_fila_email_status_to_string;
    }

    public function get_fila_email_fila_email_status_to_string()
    {
        if(!empty($this->fila_email_fila_email_status_to_string))
        {
            return $this->fila_email_fila_email_status_to_string;
        }
    
        $values = FilaEmail::where('fila_email_status_id', '=', $this->id)->getIndexedArray('fila_email_status_id','{fila_email_status->id}');
        return implode(', ', $values);
    }

    
}

