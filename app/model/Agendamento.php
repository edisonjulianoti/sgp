<?php

class Agendamento extends TRecord
{
    const TABLENAME  = 'agendamento';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $relevancia;
    private $recorrencia;
    private $plano;
    private $tipo;
    private $considera_final_semana;
    private $lembrete_agenda;
    private $system_users;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('titulo');
        parent::addAttribute('descricao');
        parent::addAttribute('data_inicio');
        parent::addAttribute('data_fim');
        parent::addAttribute('relevancia_id');
        parent::addAttribute('agenda_id');
        parent::addAttribute('recorrencia_id');
        parent::addAttribute('limite_recorrencia');
        parent::addAttribute('plano_id');
        parent::addAttribute('tipo_id');
        parent::addAttribute('considera_final_semana_id');
        parent::addAttribute('dias_personalizado');
        parent::addAttribute('lembrete_agenda_id');
        parent::addAttribute('system_users_id');
            
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
     * Method set_recorrencia
     * Sample of usage: $var->recorrencia = $object;
     * @param $object Instance of Recorrencia
     */
    public function set_recorrencia(Recorrencia $object)
    {
        $this->recorrencia = $object;
        $this->recorrencia_id = $object->id;
    }

    /**
     * Method get_recorrencia
     * Sample of usage: $var->recorrencia->attribute;
     * @returns Recorrencia instance
     */
    public function get_recorrencia()
    {
    
        // loads the associated object
        if (empty($this->recorrencia))
            $this->recorrencia = new Recorrencia($this->recorrencia_id);
    
        // returns the associated object
        return $this->recorrencia;
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
     * Method set_considera_final_semana
     * Sample of usage: $var->considera_final_semana = $object;
     * @param $object Instance of ConsideraFinalSemana
     */
    public function set_considera_final_semana(ConsideraFinalSemana $object)
    {
        $this->considera_final_semana = $object;
        $this->considera_final_semana_id = $object->id;
    }

    /**
     * Method get_considera_final_semana
     * Sample of usage: $var->considera_final_semana->attribute;
     * @returns ConsideraFinalSemana instance
     */
    public function get_considera_final_semana()
    {
    
        // loads the associated object
        if (empty($this->considera_final_semana))
            $this->considera_final_semana = new ConsideraFinalSemana($this->considera_final_semana_id);
    
        // returns the associated object
        return $this->considera_final_semana;
    }
    /**
     * Method set_lembrete_agenda
     * Sample of usage: $var->lembrete_agenda = $object;
     * @param $object Instance of LembreteAgenda
     */
    public function set_lembrete_agenda(LembreteAgenda $object)
    {
        $this->lembrete_agenda = $object;
        $this->lembrete_agenda_id = $object->id;
    }

    /**
     * Method get_lembrete_agenda
     * Sample of usage: $var->lembrete_agenda->attribute;
     * @returns LembreteAgenda instance
     */
    public function get_lembrete_agenda()
    {
    
        // loads the associated object
        if (empty($this->lembrete_agenda))
            $this->lembrete_agenda = new LembreteAgenda($this->lembrete_agenda_id);
    
        // returns the associated object
        return $this->lembrete_agenda;
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

