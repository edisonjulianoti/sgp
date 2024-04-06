<?php

class AtendimentoInteracao extends TRecord
{
    const TABLENAME  = 'atendimento_interacao';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $atendimento;
    private $atendente;
    private $cliente_usuario;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('atendimento_id');
        parent::addAttribute('atendente_id');
        parent::addAttribute('cliente_usuario_id');
        parent::addAttribute('arquivos');
        parent::addAttribute('mensagem');
        parent::addAttribute('data_interacao');
    
    }

    /**
     * Method set_atendimento
     * Sample of usage: $var->atendimento = $object;
     * @param $object Instance of Atendimento
     */
    public function set_atendimento(Atendimento $object)
    {
        $this->atendimento = $object;
        $this->atendimento_id = $object->id;
    }

    /**
     * Method get_atendimento
     * Sample of usage: $var->atendimento->attribute;
     * @returns Atendimento instance
     */
    public function get_atendimento()
    {
    
        // loads the associated object
        if (empty($this->atendimento))
            $this->atendimento = new Atendimento($this->atendimento_id);
    
        // returns the associated object
        return $this->atendimento;
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
    /**
     * Method set_cliente_usuario
     * Sample of usage: $var->cliente_usuario = $object;
     * @param $object Instance of ClienteUsuario
     */
    public function set_cliente_usuario(ClienteUsuario $object)
    {
        $this->cliente_usuario = $object;
        $this->cliente_usuario_id = $object->id;
    }

    /**
     * Method get_cliente_usuario
     * Sample of usage: $var->cliente_usuario->attribute;
     * @returns ClienteUsuario instance
     */
    public function get_cliente_usuario()
    {
    
        // loads the associated object
        if (empty($this->cliente_usuario))
            $this->cliente_usuario = new ClienteUsuario($this->cliente_usuario_id);
    
        // returns the associated object
        return $this->cliente_usuario;
    }

    public function get_nome_usuario_interacao()
    {
        if(!empty($this->atendente_id))
        {
            return $this->get_atendente()->system_user->name;
        }
        else if(!empty($this->cliente_usuario_id))
        {
        
            return $this->get_cliente_usuario()->system_user->name;
        }
    
        return '';
    }

}

