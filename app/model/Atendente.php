<?php

class Atendente extends TRecord
{
    const TABLENAME  = 'atendente';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $system_user;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('system_user_id');
            
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
        $criteria->add(new TFilter('atendente_id', '=', $this->id));
        return Atendimento::getObjects( $criteria );
    }
    /**
     * Method getAtendimentoInteracaos
     */
    public function getAtendimentoInteracaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('atendente_id', '=', $this->id));
        return AtendimentoInteracao::getObjects( $criteria );
    }
    /**
     * Method getSetorAtendentes
     */
    public function getSetorAtendentes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('atendente_id', '=', $this->id));
        return SetorAtendente::getObjects( $criteria );
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
    
        $values = Atendimento::where('atendente_id', '=', $this->id)->getIndexedArray('tipo_atendimento_id','{tipo_atendimento->nome}');
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
    
        $values = Atendimento::where('atendente_id', '=', $this->id)->getIndexedArray('setor_id','{setor->nome}');
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
    
        $values = Atendimento::where('atendente_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
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
    
        $values = Atendimento::where('atendente_id', '=', $this->id)->getIndexedArray('cliente_usuario_id','{cliente_usuario->id}');
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
    
        $values = Atendimento::where('atendente_id', '=', $this->id)->getIndexedArray('atendente_id','{atendente->id}');
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
    
        $values = AtendimentoInteracao::where('atendente_id', '=', $this->id)->getIndexedArray('atendimento_id','{atendimento->id}');
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
    
        $values = AtendimentoInteracao::where('atendente_id', '=', $this->id)->getIndexedArray('atendente_id','{atendente->id}');
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
    
        $values = AtendimentoInteracao::where('atendente_id', '=', $this->id)->getIndexedArray('cliente_usuario_id','{cliente_usuario->id}');
        return implode(', ', $values);
    }

    public function set_setor_atendente_setor_to_string($setor_atendente_setor_to_string)
    {
        if(is_array($setor_atendente_setor_to_string))
        {
            $values = Setor::where('id', 'in', $setor_atendente_setor_to_string)->getIndexedArray('nome', 'nome');
            $this->setor_atendente_setor_to_string = implode(', ', $values);
        }
        else
        {
            $this->setor_atendente_setor_to_string = $setor_atendente_setor_to_string;
        }

        $this->vdata['setor_atendente_setor_to_string'] = $this->setor_atendente_setor_to_string;
    }

    public function get_setor_atendente_setor_to_string()
    {
        if(!empty($this->setor_atendente_setor_to_string))
        {
            return $this->setor_atendente_setor_to_string;
        }
    
        $values = SetorAtendente::where('atendente_id', '=', $this->id)->getIndexedArray('setor_id','{setor->nome}');
        return implode(', ', $values);
    }

    public function set_setor_atendente_atendente_to_string($setor_atendente_atendente_to_string)
    {
        if(is_array($setor_atendente_atendente_to_string))
        {
            $values = Atendente::where('id', 'in', $setor_atendente_atendente_to_string)->getIndexedArray('id', 'id');
            $this->setor_atendente_atendente_to_string = implode(', ', $values);
        }
        else
        {
            $this->setor_atendente_atendente_to_string = $setor_atendente_atendente_to_string;
        }

        $this->vdata['setor_atendente_atendente_to_string'] = $this->setor_atendente_atendente_to_string;
    }

    public function get_setor_atendente_atendente_to_string()
    {
        if(!empty($this->setor_atendente_atendente_to_string))
        {
            return $this->setor_atendente_atendente_to_string;
        }
    
        $values = SetorAtendente::where('atendente_id', '=', $this->id)->getIndexedArray('atendente_id','{atendente->id}');
        return implode(', ', $values);
    }

    
}

