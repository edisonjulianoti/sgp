<?php

class Tarefa extends TRecord
{
    const TABLENAME  = 'tarefa';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'max'; // {max, serial}

    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'update_at';

    private $plano;
    private $status_tarefa;
    private $relevancia;
    private $tipo;
    private $system_users;

    

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('descricao');
        parent::addAttribute('detalhe');
        parent::addAttribute('conclusao');
        parent::addAttribute('plano_id');
        parent::addAttribute('status_tarefa_id');
        parent::addAttribute('relevancia_id');
        parent::addAttribute('created_at');
        parent::addAttribute('update_at');
        parent::addAttribute('tipo_id');
        parent::addAttribute('system_users_id');
            
    }

    /**
     * Method set_plano
     * Sample of usage: $var->plano = $object;
     * @param $object Instance of Plano
     */
    public function set_plano(Plano $object)
    {
        $this->plano = $object;
        $this->plano_id = $object->id;
    }

    /**
     * Method get_plano
     * Sample of usage: $var->plano->attribute;
     * @returns Plano instance
     */
    public function get_plano()
    {
    
        // loads the associated object
        if (empty($this->plano))
            $this->plano = new Plano($this->plano_id);
    
        // returns the associated object
        return $this->plano;
    }
    /**
     * Method set_status_tarefa
     * Sample of usage: $var->status_tarefa = $object;
     * @param $object Instance of StatusTarefa
     */
    public function set_status_tarefa(StatusTarefa $object)
    {
        $this->status_tarefa = $object;
        $this->status_tarefa_id = $object->id;
    }

    /**
     * Method get_status_tarefa
     * Sample of usage: $var->status_tarefa->attribute;
     * @returns StatusTarefa instance
     */
    public function get_status_tarefa()
    {
    
        // loads the associated object
        if (empty($this->status_tarefa))
            $this->status_tarefa = new StatusTarefa($this->status_tarefa_id);
    
        // returns the associated object
        return $this->status_tarefa;
    }
    /**
     * Method set_relevancia
     * Sample of usage: $var->relevancia = $object;
     * @param $object Instance of Relevancia
     */
    public function set_relevancia(Relevancia $object)
    {
        $this->relevancia = $object;
        $this->relevancia_id = $object->id;
    }

    /**
     * Method get_relevancia
     * Sample of usage: $var->relevancia->attribute;
     * @returns Relevancia instance
     */
    public function get_relevancia()
    {
    
        // loads the associated object
        if (empty($this->relevancia))
            $this->relevancia = new Relevancia($this->relevancia_id);
    
        // returns the associated object
        return $this->relevancia;
    }
    /**
     * Method set_tipo
     * Sample of usage: $var->tipo = $object;
     * @param $object Instance of Tipo
     */
    public function set_tipo(Tipo $object)
    {
        $this->tipo = $object;
        $this->tipo_id = $object->id;
    }

    /**
     * Method get_tipo
     * Sample of usage: $var->tipo->attribute;
     * @returns Tipo instance
     */
    public function get_tipo()
    {
    
        // loads the associated object
        if (empty($this->tipo))
            $this->tipo = new Tipo($this->tipo_id);
    
        // returns the associated object
        return $this->tipo;
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

