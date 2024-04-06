<?php

class ClienteUsuario extends TRecord
{
    const TABLENAME  = 'cliente_usuario';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $cliente;
    private $system_user;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cliente_id');
        parent::addAttribute('system_user_id');
        parent::addAttribute('ativo');
            
    }

    /**
     * Method set_cliente
     * Sample of usage: $var->cliente = $object;
     * @param $object Instance of Cliente
     */
    public function set_cliente(Cliente $object)
    {
        $this->cliente = $object;
        $this->cliente_id = $object->id;
    }

    /**
     * Method get_cliente
     * Sample of usage: $var->cliente->attribute;
     * @returns Cliente instance
     */
    public function get_cliente()
    {
    
        // loads the associated object
        if (empty($this->cliente))
            $this->cliente = new Cliente($this->cliente_id);
    
        // returns the associated object
        return $this->cliente;
    }
    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_system_user(SystemUsers $object)
    {
        $this->system_user = $object;
        $this->system_user_id = $object->id;
    }

    /**
     * Method get_system_user
     * Sample of usage: $var->system_user->attribute;
     * @returns SystemUsers instance
     */
    public function get_system_user()
    {
        TTransaction::open('permission');
        // loads the associated object
        if (empty($this->system_user))
            $this->system_user = new SystemUsers($this->system_user_id);
        TTransaction::close();
        // returns the associated object
        return $this->system_user;
    }

    /**
     * Method getAtendimentos
     */
    public function getAtendimentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_usuario_id', '=', $this->id));
        return Atendimento::getObjects( $criteria );
    }
    /**
     * Method getAtendimentoInteracaos
     */
    public function getAtendimentoInteracaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_usuario_id', '=', $this->id));
        return AtendimentoInteracao::getObjects( $criteria );
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
    
        $values = Atendimento::where('cliente_usuario_id', '=', $this->id)->getIndexedArray('tipo_atendimento_id','{tipo_atendimento->nome}');
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
    
        $values = Atendimento::where('cliente_usuario_id', '=', $this->id)->getIndexedArray('setor_id','{setor->nome}');
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
    
        $values = Atendimento::where('cliente_usuario_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
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
    
        $values = Atendimento::where('cliente_usuario_id', '=', $this->id)->getIndexedArray('cliente_usuario_id','{cliente_usuario->id}');
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
    
        $values = Atendimento::where('cliente_usuario_id', '=', $this->id)->getIndexedArray('atendente_id','{atendente->id}');
        return implode(', ', $values);
    }

    public function set_atendimento_interacao_atendimento_to_string($atendimento_interacao_atendimento_to_string)
    {
        if(is_array($atendimento_interacao_atendimento_to_string))
        {
            $values = Atendimento::where('id', 'in', $atendimento_interacao_atendimento_to_string)->getIndexedArray('id', 'id');
            $this->atendimento_interacao_atendimento_to_string = implode(', ', $values);
        }
        else
        {
            $this->atendimento_interacao_atendimento_to_string = $atendimento_interacao_atendimento_to_string;
        }

        $this->vdata['atendimento_interacao_atendimento_to_string'] = $this->atendimento_interacao_atendimento_to_string;
    }

    public function get_atendimento_interacao_atendimento_to_string()
    {
        if(!empty($this->atendimento_interacao_atendimento_to_string))
        {
            return $this->atendimento_interacao_atendimento_to_string;
        }
    
        $values = AtendimentoInteracao::where('cliente_usuario_id', '=', $this->id)->getIndexedArray('atendimento_id','{atendimento->id}');
        return implode(', ', $values);
    }

    public function set_atendimento_interacao_atendente_to_string($atendimento_interacao_atendente_to_string)
    {
        if(is_array($atendimento_interacao_atendente_to_string))
        {
            $values = Atendente::where('id', 'in', $atendimento_interacao_atendente_to_string)->getIndexedArray('id', 'id');
            $this->atendimento_interacao_atendente_to_string = implode(', ', $values);
        }
        else
        {
            $this->atendimento_interacao_atendente_to_string = $atendimento_interacao_atendente_to_string;
        }

        $this->vdata['atendimento_interacao_atendente_to_string'] = $this->atendimento_interacao_atendente_to_string;
    }

    public function get_atendimento_interacao_atendente_to_string()
    {
        if(!empty($this->atendimento_interacao_atendente_to_string))
        {
            return $this->atendimento_interacao_atendente_to_string;
        }
    
        $values = AtendimentoInteracao::where('cliente_usuario_id', '=', $this->id)->getIndexedArray('atendente_id','{atendente->id}');
        return implode(', ', $values);
    }

    public function set_atendimento_interacao_cliente_usuario_to_string($atendimento_interacao_cliente_usuario_to_string)
    {
        if(is_array($atendimento_interacao_cliente_usuario_to_string))
        {
            $values = ClienteUsuario::where('id', 'in', $atendimento_interacao_cliente_usuario_to_string)->getIndexedArray('id', 'id');
            $this->atendimento_interacao_cliente_usuario_to_string = implode(', ', $values);
        }
        else
        {
            $this->atendimento_interacao_cliente_usuario_to_string = $atendimento_interacao_cliente_usuario_to_string;
        }

        $this->vdata['atendimento_interacao_cliente_usuario_to_string'] = $this->atendimento_interacao_cliente_usuario_to_string;
    }

    public function get_atendimento_interacao_cliente_usuario_to_string()
    {
        if(!empty($this->atendimento_interacao_cliente_usuario_to_string))
        {
            return $this->atendimento_interacao_cliente_usuario_to_string;
        }
    
        $values = AtendimentoInteracao::where('cliente_usuario_id', '=', $this->id)->getIndexedArray('cliente_usuario_id','{cliente_usuario->id}');
        return implode(', ', $values);
    }

    
}

