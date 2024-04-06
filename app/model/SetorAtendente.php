<?php

class SetorAtendente extends TRecord
{
    const TABLENAME  = 'setor_atendente';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $setor;
    private $atendente;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('setor_id');
        parent::addAttribute('atendente_id');
            
    }

    /**
     * Method set_setor
     * Sample of usage: $var->setor = $object;
     * @param $object Instance of Setor
     */
    public function set_setor(Setor $object)
    {
        $this->setor = $object;
        $this->setor_id = $object->id;
    }

    /**
     * Method get_setor
     * Sample of usage: $var->setor->attribute;
     * @returns Setor instance
     */
    public function get_setor()
    {
    
        // loads the associated object
        if (empty($this->setor))
            $this->setor = new Setor($this->setor_id);
    
        // returns the associated object
        return $this->setor;
    }
    /**
     * Method set_atendente
     * Sample of usage: $var->atendente = $object;
     * @param $object Instance of Atendente
     */
    public function set_atendente(Atendente $object)
    {
        $this->atendente = $object;
        $this->atendente_id = $object->id;
    }

    /**
     * Method get_atendente
     * Sample of usage: $var->atendente->attribute;
     * @returns Atendente instance
     */
    public function get_atendente()
    {
    
        // loads the associated object
        if (empty($this->atendente))
            $this->atendente = new Atendente($this->atendente_id);
    
        // returns the associated object
        return $this->atendente;
    }

    
}

