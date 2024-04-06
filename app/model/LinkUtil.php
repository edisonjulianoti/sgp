<?php

class LinkUtil extends TRecord
{
    const TABLENAME  = 'link_util';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATEDAT  = 'criado_em';

    private $created_by_system_user;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('created_by_system_user_id');
        parent::addAttribute('titulo');
        parent::addAttribute('descricao');
        parent::addAttribute('link');
        parent::addAttribute('ativo');
        parent::addAttribute('criado_em');
            
    }

    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_created_by_system_user(SystemUsers $object)
    {
        $this->created_by_system_user = $object;
        $this->created_by_system_user_id = $object->id;
    }

    /**
     * Method get_created_by_system_user
     * Sample of usage: $var->created_by_system_user->attribute;
     * @returns SystemUsers instance
     */
    public function get_created_by_system_user()
    {
        TTransaction::open('permission');
        // loads the associated object
        if (empty($this->created_by_system_user))
            $this->created_by_system_user = new SystemUsers($this->created_by_system_user_id);
        TTransaction::close();
        // returns the associated object
        return $this->created_by_system_user;
    }

    
}

