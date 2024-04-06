<?php

class Cliente extends TRecord
{
    const TABLENAME  = 'cliente';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('email');
        parent::addAttribute('telefone');
            
    }

    /**
     * Method getAtendimentos
     */
    public function getAtendimentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_id', '=', $this->id));
        return Atendimento::getObjects( $criteria );
    }
    /**
     * Method getClienteUsuarios
     */
    public function getClienteUsuarios()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_id', '=', $this->id));
        return ClienteUsuario::getObjects( $criteria );
    }
    /**
     * Method getDocumentos
     */
    public function getDocumentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_id', '=', $this->id));
        return Documento::getObjects( $criteria );
    }
    /**
     * Method getGuias
     */
    public function getGuias()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_id', '=', $this->id));
        return Guia::getObjects( $criteria );
    }

    public function set_atendimento_tipo_atendimento_to_string($atendimento_tipo_atendimento_to_string)
    {
        if(is_array($atendimento_tipo_atendimento_to_string))
        {
            $values = TipoAtendimento::where('id', 'in', $atendimento_tipo_atendimento_to_string)->getIndexedArray('nome', 'nome');
            $this->atendimento_tipo_atendimento_to_string = implode(', ', $values);
        }
        else
        {
            $this->atendimento_tipo_atendimento_to_string = $atendimento_tipo_atendimento_to_string;
        }

        $this->vdata['atendimento_tipo_atendimento_to_string'] = $this->atendimento_tipo_atendimento_to_string;
    }

    public function get_atendimento_tipo_atendimento_to_string()
    {
        if(!empty($this->atendimento_tipo_atendimento_to_string))
        {
            return $this->atendimento_tipo_atendimento_to_string;
        }
    
        $values = Atendimento::where('cliente_id', '=', $this->id)->getIndexedArray('tipo_atendimento_id','{tipo_atendimento->nome}');
        return implode(', ', $values);
    }

    public function set_atendimento_setor_to_string($atendimento_setor_to_string)
    {
        if(is_array($atendimento_setor_to_string))
        {
            $values = Setor::where('id', 'in', $atendimento_setor_to_string)->getIndexedArray('nome', 'nome');
            $this->atendimento_setor_to_string = implode(', ', $values);
        }
        else
        {
            $this->atendimento_setor_to_string = $atendimento_setor_to_string;
        }

        $this->vdata['atendimento_setor_to_string'] = $this->atendimento_setor_to_string;
    }

    public function get_atendimento_setor_to_string()
    {
        if(!empty($this->atendimento_setor_to_string))
        {
            return $this->atendimento_setor_to_string;
        }
    
        $values = Atendimento::where('cliente_id', '=', $this->id)->getIndexedArray('setor_id','{setor->nome}');
        return implode(', ', $values);
    }

    public function set_atendimento_cliente_to_string($atendimento_cliente_to_string)
    {
        if(is_array($atendimento_cliente_to_string))
        {
            $values = Cliente::where('id', 'in', $atendimento_cliente_to_string)->getIndexedArray('nome', 'nome');
            $this->atendimento_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->atendimento_cliente_to_string = $atendimento_cliente_to_string;
        }

        $this->vdata['atendimento_cliente_to_string'] = $this->atendimento_cliente_to_string;
    }

    public function get_atendimento_cliente_to_string()
    {
        if(!empty($this->atendimento_cliente_to_string))
        {
            return $this->atendimento_cliente_to_string;
        }
    
        $values = Atendimento::where('cliente_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
        return implode(', ', $values);
    }

    public function set_atendimento_cliente_usuario_to_string($atendimento_cliente_usuario_to_string)
    {
        if(is_array($atendimento_cliente_usuario_to_string))
        {
            $values = ClienteUsuario::where('id', 'in', $atendimento_cliente_usuario_to_string)->getIndexedArray('id', 'id');
            $this->atendimento_cliente_usuario_to_string = implode(', ', $values);
        }
        else
        {
            $this->atendimento_cliente_usuario_to_string = $atendimento_cliente_usuario_to_string;
        }

        $this->vdata['atendimento_cliente_usuario_to_string'] = $this->atendimento_cliente_usuario_to_string;
    }

    public function get_atendimento_cliente_usuario_to_string()
    {
        if(!empty($this->atendimento_cliente_usuario_to_string))
        {
            return $this->atendimento_cliente_usuario_to_string;
        }
    
        $values = Atendimento::where('cliente_id', '=', $this->id)->getIndexedArray('cliente_usuario_id','{cliente_usuario->id}');
        return implode(', ', $values);
    }

    public function set_atendimento_atendente_to_string($atendimento_atendente_to_string)
    {
        if(is_array($atendimento_atendente_to_string))
        {
            $values = Atendente::where('id', 'in', $atendimento_atendente_to_string)->getIndexedArray('id', 'id');
            $this->atendimento_atendente_to_string = implode(', ', $values);
        }
        else
        {
            $this->atendimento_atendente_to_string = $atendimento_atendente_to_string;
        }

        $this->vdata['atendimento_atendente_to_string'] = $this->atendimento_atendente_to_string;
    }

    public function get_atendimento_atendente_to_string()
    {
        if(!empty($this->atendimento_atendente_to_string))
        {
            return $this->atendimento_atendente_to_string;
        }
    
        $values = Atendimento::where('cliente_id', '=', $this->id)->getIndexedArray('atendente_id','{atendente->id}');
        return implode(', ', $values);
    }

    public function set_cliente_usuario_cliente_to_string($cliente_usuario_cliente_to_string)
    {
        if(is_array($cliente_usuario_cliente_to_string))
        {
            $values = Cliente::where('id', 'in', $cliente_usuario_cliente_to_string)->getIndexedArray('nome', 'nome');
            $this->cliente_usuario_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->cliente_usuario_cliente_to_string = $cliente_usuario_cliente_to_string;
        }

        $this->vdata['cliente_usuario_cliente_to_string'] = $this->cliente_usuario_cliente_to_string;
    }

    public function get_cliente_usuario_cliente_to_string()
    {
        if(!empty($this->cliente_usuario_cliente_to_string))
        {
            return $this->cliente_usuario_cliente_to_string;
        }
    
        $values = ClienteUsuario::where('cliente_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
        return implode(', ', $values);
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
    
        $values = Documento::where('cliente_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
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
    
        $values = Documento::where('cliente_id', '=', $this->id)->getIndexedArray('tipo_documento_id','{tipo_documento->nome}');
        return implode(', ', $values);
    }

    public function set_guia_subcategoria_guia_to_string($guia_subcategoria_guia_to_string)
    {
        if(is_array($guia_subcategoria_guia_to_string))
        {
            $values = SubcategoriaGuia::where('id', 'in', $guia_subcategoria_guia_to_string)->getIndexedArray('nome', 'nome');
            $this->guia_subcategoria_guia_to_string = implode(', ', $values);
        }
        else
        {
            $this->guia_subcategoria_guia_to_string = $guia_subcategoria_guia_to_string;
        }

        $this->vdata['guia_subcategoria_guia_to_string'] = $this->guia_subcategoria_guia_to_string;
    }

    public function get_guia_subcategoria_guia_to_string()
    {
        if(!empty($this->guia_subcategoria_guia_to_string))
        {
            return $this->guia_subcategoria_guia_to_string;
        }
    
        $values = Guia::where('cliente_id', '=', $this->id)->getIndexedArray('subcategoria_guia_id','{subcategoria_guia->nome}');
        return implode(', ', $values);
    }

    public function set_guia_cliente_to_string($guia_cliente_to_string)
    {
        if(is_array($guia_cliente_to_string))
        {
            $values = Cliente::where('id', 'in', $guia_cliente_to_string)->getIndexedArray('nome', 'nome');
            $this->guia_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->guia_cliente_to_string = $guia_cliente_to_string;
        }

        $this->vdata['guia_cliente_to_string'] = $this->guia_cliente_to_string;
    }

    public function get_guia_cliente_to_string()
    {
        if(!empty($this->guia_cliente_to_string))
        {
            return $this->guia_cliente_to_string;
        }
    
        $values = Guia::where('cliente_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
        return implode(', ', $values);
    }

    
}

