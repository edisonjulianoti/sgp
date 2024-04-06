<?php

class TipoAtendimento extends TRecord
{
    const TABLENAME  = 'tipo_atendimento';
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
     * Method getAtendimentos
     */
    public function getAtendimentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('tipo_atendimento_id', '=', $this->id));
        return Atendimento::getObjects( $criteria );
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
    
        $values = Atendimento::where('tipo_atendimento_id', '=', $this->id)->getIndexedArray('tipo_atendimento_id','{tipo_atendimento->nome}');
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
    
        $values = Atendimento::where('tipo_atendimento_id', '=', $this->id)->getIndexedArray('setor_id','{setor->nome}');
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
    
        $values = Atendimento::where('tipo_atendimento_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
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
    
        $values = Atendimento::where('tipo_atendimento_id', '=', $this->id)->getIndexedArray('cliente_usuario_id','{cliente_usuario->id}');
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
    
        $values = Atendimento::where('tipo_atendimento_id', '=', $this->id)->getIndexedArray('atendente_id','{atendente->id}');
        return implode(', ', $values);
    }

    
}

