<?php

class Atendimento extends TRecord
{
    const TABLENAME  = 'atendimento';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $tipo_atendimento;
    private $setor;
    private $cliente;
    private $atendente;
    private $cliente_usuario;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('tipo_atendimento_id');
        parent::addAttribute('setor_id');
        parent::addAttribute('cliente_id');
        parent::addAttribute('cliente_usuario_id');
        parent::addAttribute('atendente_id');
        parent::addAttribute('arquivos');
        parent::addAttribute('data_abertura');
        parent::addAttribute('data_fechamento');
        parent::addAttribute('mensagem');
            
    }

    /**
     * Method set_tipo_atendimento
     * Sample of usage: $var->tipo_atendimento = $object;
     * @param $object Instance of TipoAtendimento
     */
    public function set_tipo_atendimento(TipoAtendimento $object)
    {
        $this->tipo_atendimento = $object;
        $this->tipo_atendimento_id = $object->id;
    }

    /**
     * Method get_tipo_atendimento
     * Sample of usage: $var->tipo_atendimento->attribute;
     * @returns TipoAtendimento instance
     */
    public function get_tipo_atendimento()
    {
    
        // loads the associated object
        if (empty($this->tipo_atendimento))
            $this->tipo_atendimento = new TipoAtendimento($this->tipo_atendimento_id);
    
        // returns the associated object
        return $this->tipo_atendimento;
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

    /**
     * Method getAtendimentoInteracaos
     */
    public function getAtendimentoInteracaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('atendimento_id', '=', $this->id));
        return AtendimentoInteracao::getObjects( $criteria );
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
    
        $values = AtendimentoInteracao::where('atendimento_id', '=', $this->id)->getIndexedArray('atendimento_id','{atendimento->id}');
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
    
        $values = AtendimentoInteracao::where('atendimento_id', '=', $this->id)->getIndexedArray('atendente_id','{atendente->id}');
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
    
        $values = AtendimentoInteracao::where('atendimento_id', '=', $this->id)->getIndexedArray('cliente_usuario_id','{cliente_usuario->id}');
        return implode(', ', $values);
    }

    
}

