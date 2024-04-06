<?php

class Transacao extends TRecord
{
    const TABLENAME  = 'transacao';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'updated_at';

    private $conta;
    private $lancamento;
    private $system_users;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('data_transacao');
        parent::addAttribute('conta_id');
        parent::addAttribute('saldo_anterior');
        parent::addAttribute('valor');
        parent::addAttribute('saldo_final');
        parent::addAttribute('lancamento_id');
        parent::addAttribute('system_users_id');
            
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
     * Method set_lancamento
     * Sample of usage: $var->lancamento = $object;
     * @param $object Instance of Lancamento
     */
    public function set_lancamento(Lancamento $object)
    {
        $this->lancamento = $object;
        $this->lancamento_id = $object->id;
    }

    /**
     * Method get_lancamento
     * Sample of usage: $var->lancamento->attribute;
     * @returns Lancamento instance
     */
    public function get_lancamento()
    {
    
        // loads the associated object
        if (empty($this->lancamento))
            $this->lancamento = new Lancamento($this->lancamento_id);
    
        // returns the associated object
        return $this->lancamento;
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

    
}

