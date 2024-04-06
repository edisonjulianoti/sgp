<?php

class Lancamento extends TRecord
{
    const TABLENAME  = 'lancamento';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'updated_at';

    private $categoria;
    private $conta;
    private $status_lancamento;
    private $system_users;
    private $tipo_lancamento;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('descricao');
        parent::addAttribute('vencimento');
        parent::addAttribute('pagamento');
        parent::addAttribute('valor');
        parent::addAttribute('categoria_id');
        parent::addAttribute('conta_id');
        parent::addAttribute('status_lancamento_id');
        parent::addAttribute('system_users_id');
        parent::addAttribute('updated_at');
        parent::addAttribute('created_at');
        parent::addAttribute('tipo_lancamento_id');
            
    }

    /**
     * Method set_categoria
     * Sample of usage: $var->categoria = $object;
     * @param $object Instance of Categoria
     */
    public function set_categoria(Categoria $object)
    {
        $this->categoria = $object;
        $this->categoria_id = $object->id;
    }

    /**
     * Method get_categoria
     * Sample of usage: $var->categoria->attribute;
     * @returns Categoria instance
     */
    public function get_categoria()
    {
    
        // loads the associated object
        if (empty($this->categoria))
            $this->categoria = new Categoria($this->categoria_id);
    
        // returns the associated object
        return $this->categoria;
    }
    /**
     * Method set_conta
     * Sample of usage: $var->conta = $object;
     * @param $object Instance of Conta
     */
    public function set_conta(Conta $object)
    {
        $this->conta = $object;
        $this->conta_id = $object->id;
    }

    /**
     * Method get_conta
     * Sample of usage: $var->conta->attribute;
     * @returns Conta instance
     */
    public function get_conta()
    {
    
        // loads the associated object
        if (empty($this->conta))
            $this->conta = new Conta($this->conta_id);
    
        // returns the associated object
        return $this->conta;
    }
    /**
     * Method set_status_lancamento
     * Sample of usage: $var->status_lancamento = $object;
     * @param $object Instance of StatusLancamento
     */
    public function set_status_lancamento(StatusLancamento $object)
    {
        $this->status_lancamento = $object;
        $this->status_lancamento_id = $object->id;
    }

    /**
     * Method get_status_lancamento
     * Sample of usage: $var->status_lancamento->attribute;
     * @returns StatusLancamento instance
     */
    public function get_status_lancamento()
    {
    
        // loads the associated object
        if (empty($this->status_lancamento))
            $this->status_lancamento = new StatusLancamento($this->status_lancamento_id);
    
        // returns the associated object
        return $this->status_lancamento;
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
     * Method set_tipo_lancamento
     * Sample of usage: $var->tipo_lancamento = $object;
     * @param $object Instance of TipoLancamento
     */
    public function set_tipo_lancamento(TipoLancamento $object)
    {
        $this->tipo_lancamento = $object;
        $this->tipo_lancamento_id = $object->id;
    }

    /**
     * Method get_tipo_lancamento
     * Sample of usage: $var->tipo_lancamento->attribute;
     * @returns TipoLancamento instance
     */
    public function get_tipo_lancamento()
    {
    
        // loads the associated object
        if (empty($this->tipo_lancamento))
            $this->tipo_lancamento = new TipoLancamento($this->tipo_lancamento_id);
    
        // returns the associated object
        return $this->tipo_lancamento;
    }

    /**
     * Method getTransacaos
     */
    public function getTransacaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('lancamento_id', '=', $this->id));
        return Transacao::getObjects( $criteria );
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
    
        $values = Transacao::where('lancamento_id', '=', $this->id)->getIndexedArray('conta_id','{conta->descricao}');
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
    
        $values = Transacao::where('lancamento_id', '=', $this->id)->getIndexedArray('lancamento_id','{lancamento->descricao}');
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
    
        $values = Transacao::where('lancamento_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
        return implode(', ', $values);
    }

    
}

