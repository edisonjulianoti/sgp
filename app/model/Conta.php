<?php

class Conta extends TRecord
{
    const TABLENAME  = 'conta';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'updated_at';

    private $tipo_conta;
    private $system_users;
    private $saldo_calculado;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('tipo_conta_id');
        parent::addAttribute('descricao');
        parent::addAttribute('banco');
        parent::addAttribute('data_saldo_inicial');
        parent::addAttribute('saldo_inicial');
        parent::addAttribute('saldo_atual');
        parent::addAttribute('system_users_id');
        parent::addAttribute('updated_at');
        parent::addAttribute('created_at');
        parent::addAttribute('saldo_calculado_id');
            
    }

    /**
     * Method set_tipo_conta
     * Sample of usage: $var->tipo_conta = $object;
     * @param $object Instance of TipoConta
     */
    public function set_tipo_conta(TipoConta $object)
    {
        $this->tipo_conta = $object;
        $this->tipo_conta_id = $object->id;
    }

    /**
     * Method get_tipo_conta
     * Sample of usage: $var->tipo_conta->attribute;
     * @returns TipoConta instance
     */
    public function get_tipo_conta()
    {
    
        // loads the associated object
        if (empty($this->tipo_conta))
            $this->tipo_conta = new TipoConta($this->tipo_conta_id);
    
        // returns the associated object
        return $this->tipo_conta;
    }
    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_system_users(SystemUsers $object)
    {
        $this->system_users = $object;
        $this->system_users_id = $object->id;
    }

    /**
     * Method get_system_users
     * Sample of usage: $var->system_users->attribute;
     * @returns SystemUsers instance
     */
    public function get_system_users()
    {
    
        // loads the associated object
        if (empty($this->system_users))
            $this->system_users = new SystemUsers($this->system_users_id);
    
        // returns the associated object
        return $this->system_users;
    }
    /**
     * Method set_saldo_calculado
     * Sample of usage: $var->saldo_calculado = $object;
     * @param $object Instance of SaldoCalculado
     */
    public function set_saldo_calculado(SaldoCalculado $object)
    {
        $this->saldo_calculado = $object;
        $this->saldo_calculado_id = $object->id;
    }

    /**
     * Method get_saldo_calculado
     * Sample of usage: $var->saldo_calculado->attribute;
     * @returns SaldoCalculado instance
     */
    public function get_saldo_calculado()
    {
    
        // loads the associated object
        if (empty($this->saldo_calculado))
            $this->saldo_calculado = new SaldoCalculado($this->saldo_calculado_id);
    
        // returns the associated object
        return $this->saldo_calculado;
    }

    /**
     * Method getLancamentos
     */
    public function getLancamentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('conta_id', '=', $this->id));
        return Lancamento::getObjects( $criteria );
    }
    /**
     * Method getTransacaos
     */
    public function getTransacaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('conta_id', '=', $this->id));
        return Transacao::getObjects( $criteria );
    }

    public function set_lancamento_categoria_to_string($lancamento_categoria_to_string)
    {
        if(is_array($lancamento_categoria_to_string))
        {
            $values = Categoria::where('id', 'in', $lancamento_categoria_to_string)->getIndexedArray('descricao', 'descricao');
            $this->lancamento_categoria_to_string = implode(', ', $values);
        }
        else
        {
            $this->lancamento_categoria_to_string = $lancamento_categoria_to_string;
        }

        $this->vdata['lancamento_categoria_to_string'] = $this->lancamento_categoria_to_string;
    }

    public function get_lancamento_categoria_to_string()
    {
        if(!empty($this->lancamento_categoria_to_string))
        {
            return $this->lancamento_categoria_to_string;
        }
    
        $values = Lancamento::where('conta_id', '=', $this->id)->getIndexedArray('categoria_id','{categoria->descricao}');
        return implode(', ', $values);
    }

    public function set_lancamento_conta_to_string($lancamento_conta_to_string)
    {
        if(is_array($lancamento_conta_to_string))
        {
            $values = Conta::where('id', 'in', $lancamento_conta_to_string)->getIndexedArray('descricao', 'descricao');
            $this->lancamento_conta_to_string = implode(', ', $values);
        }
        else
        {
            $this->lancamento_conta_to_string = $lancamento_conta_to_string;
        }

        $this->vdata['lancamento_conta_to_string'] = $this->lancamento_conta_to_string;
    }

    public function get_lancamento_conta_to_string()
    {
        if(!empty($this->lancamento_conta_to_string))
        {
            return $this->lancamento_conta_to_string;
        }
    
        $values = Lancamento::where('conta_id', '=', $this->id)->getIndexedArray('conta_id','{conta->descricao}');
        return implode(', ', $values);
    }

    public function set_lancamento_status_lancamento_to_string($lancamento_status_lancamento_to_string)
    {
        if(is_array($lancamento_status_lancamento_to_string))
        {
            $values = StatusLancamento::where('id', 'in', $lancamento_status_lancamento_to_string)->getIndexedArray('id', 'id');
            $this->lancamento_status_lancamento_to_string = implode(', ', $values);
        }
        else
        {
            $this->lancamento_status_lancamento_to_string = $lancamento_status_lancamento_to_string;
        }

        $this->vdata['lancamento_status_lancamento_to_string'] = $this->lancamento_status_lancamento_to_string;
    }

    public function get_lancamento_status_lancamento_to_string()
    {
        if(!empty($this->lancamento_status_lancamento_to_string))
        {
            return $this->lancamento_status_lancamento_to_string;
        }
    
        $values = Lancamento::where('conta_id', '=', $this->id)->getIndexedArray('status_lancamento_id','{status_lancamento->id}');
        return implode(', ', $values);
    }

    public function set_lancamento_system_users_to_string($lancamento_system_users_to_string)
    {
        if(is_array($lancamento_system_users_to_string))
        {
            $values = SystemUsers::where('id', 'in', $lancamento_system_users_to_string)->getIndexedArray('name', 'name');
            $this->lancamento_system_users_to_string = implode(', ', $values);
        }
        else
        {
            $this->lancamento_system_users_to_string = $lancamento_system_users_to_string;
        }

        $this->vdata['lancamento_system_users_to_string'] = $this->lancamento_system_users_to_string;
    }

    public function get_lancamento_system_users_to_string()
    {
        if(!empty($this->lancamento_system_users_to_string))
        {
            return $this->lancamento_system_users_to_string;
        }
    
        $values = Lancamento::where('conta_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
        return implode(', ', $values);
    }

    public function set_lancamento_tipo_lancamento_to_string($lancamento_tipo_lancamento_to_string)
    {
        if(is_array($lancamento_tipo_lancamento_to_string))
        {
            $values = TipoLancamento::where('id', 'in', $lancamento_tipo_lancamento_to_string)->getIndexedArray('id', 'id');
            $this->lancamento_tipo_lancamento_to_string = implode(', ', $values);
        }
        else
        {
            $this->lancamento_tipo_lancamento_to_string = $lancamento_tipo_lancamento_to_string;
        }

        $this->vdata['lancamento_tipo_lancamento_to_string'] = $this->lancamento_tipo_lancamento_to_string;
    }

    public function get_lancamento_tipo_lancamento_to_string()
    {
        if(!empty($this->lancamento_tipo_lancamento_to_string))
        {
            return $this->lancamento_tipo_lancamento_to_string;
        }
    
        $values = Lancamento::where('conta_id', '=', $this->id)->getIndexedArray('tipo_lancamento_id','{tipo_lancamento->id}');
        return implode(', ', $values);
    }

    public function set_transacao_conta_to_string($transacao_conta_to_string)
    {
        if(is_array($transacao_conta_to_string))
        {
            $values = Conta::where('id', 'in', $transacao_conta_to_string)->getIndexedArray('descricao', 'descricao');
            $this->transacao_conta_to_string = implode(', ', $values);
        }
        else
        {
            $this->transacao_conta_to_string = $transacao_conta_to_string;
        }

        $this->vdata['transacao_conta_to_string'] = $this->transacao_conta_to_string;
    }

    public function get_transacao_conta_to_string()
    {
        if(!empty($this->transacao_conta_to_string))
        {
            return $this->transacao_conta_to_string;
        }
    
        $values = Transacao::where('conta_id', '=', $this->id)->getIndexedArray('conta_id','{conta->descricao}');
        return implode(', ', $values);
    }

    public function set_transacao_lancamento_to_string($transacao_lancamento_to_string)
    {
        if(is_array($transacao_lancamento_to_string))
        {
            $values = Lancamento::where('id', 'in', $transacao_lancamento_to_string)->getIndexedArray('descricao', 'descricao');
            $this->transacao_lancamento_to_string = implode(', ', $values);
        }
        else
        {
            $this->transacao_lancamento_to_string = $transacao_lancamento_to_string;
        }

        $this->vdata['transacao_lancamento_to_string'] = $this->transacao_lancamento_to_string;
    }

    public function get_transacao_lancamento_to_string()
    {
        if(!empty($this->transacao_lancamento_to_string))
        {
            return $this->transacao_lancamento_to_string;
        }
    
        $values = Transacao::where('conta_id', '=', $this->id)->getIndexedArray('lancamento_id','{lancamento->descricao}');
        return implode(', ', $values);
    }

    public function set_transacao_system_users_to_string($transacao_system_users_to_string)
    {
        if(is_array($transacao_system_users_to_string))
        {
            $values = SystemUsers::where('id', 'in', $transacao_system_users_to_string)->getIndexedArray('name', 'name');
            $this->transacao_system_users_to_string = implode(', ', $values);
        }
        else
        {
            $this->transacao_system_users_to_string = $transacao_system_users_to_string;
        }

        $this->vdata['transacao_system_users_to_string'] = $this->transacao_system_users_to_string;
    }

    public function get_transacao_system_users_to_string()
    {
        if(!empty($this->transacao_system_users_to_string))
        {
            return $this->transacao_system_users_to_string;
        }
    
        $values = Transacao::where('conta_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
        return implode(', ', $values);
    }

    
}

