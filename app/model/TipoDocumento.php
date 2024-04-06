<?php

class TipoDocumento extends TRecord
{
    const TABLENAME  = 'tipo_documento';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
            
    }

    /**
     * Method getDocumentos
     */
    public function getDocumentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('tipo_documento_id', '=', $this->id));
        return Documento::getObjects( $criteria );
    }

    public function set_documento_cliente_to_string($documento_cliente_to_string)
    {
        if(is_array($documento_cliente_to_string))
        {
            $values = Cliente::where('id', 'in', $documento_cliente_to_string)->getIndexedArray('nome', 'nome');
            $this->documento_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->documento_cliente_to_string = $documento_cliente_to_string;
        }

        $this->vdata['documento_cliente_to_string'] = $this->documento_cliente_to_string;
    }

    public function get_documento_cliente_to_string()
    {
        if(!empty($this->documento_cliente_to_string))
        {
            return $this->documento_cliente_to_string;
        }
    
        $values = Documento::where('tipo_documento_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
        return implode(', ', $values);
    }

    public function set_documento_tipo_documento_to_string($documento_tipo_documento_to_string)
    {
        if(is_array($documento_tipo_documento_to_string))
        {
            $values = TipoDocumento::where('id', 'in', $documento_tipo_documento_to_string)->getIndexedArray('nome', 'nome');
            $this->documento_tipo_documento_to_string = implode(', ', $values);
        }
        else
        {
            $this->documento_tipo_documento_to_string = $documento_tipo_documento_to_string;
        }

        $this->vdata['documento_tipo_documento_to_string'] = $this->documento_tipo_documento_to_string;
    }

    public function get_documento_tipo_documento_to_string()
    {
        if(!empty($this->documento_tipo_documento_to_string))
        {
            return $this->documento_tipo_documento_to_string;
        }
    
        $values = Documento::where('tipo_documento_id', '=', $this->id)->getIndexedArray('tipo_documento_id','{tipo_documento->nome}');
        return implode(', ', $values);
    }

    
}

