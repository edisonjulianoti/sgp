<?php

class SubcategoriaGuia extends TRecord
{
    const TABLENAME  = 'subcategoria_guia';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $categoria_guia;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('categoria_guia_id');
            
    }

    /**
     * Method set_categoria_guia
     * Sample of usage: $var->categoria_guia = $object;
     * @param $object Instance of CategoriaGuia
     */
    public function set_categoria_guia(CategoriaGuia $object)
    {
        $this->categoria_guia = $object;
        $this->categoria_guia_id = $object->id;
    }

    /**
     * Method get_categoria_guia
     * Sample of usage: $var->categoria_guia->attribute;
     * @returns CategoriaGuia instance
     */
    public function get_categoria_guia()
    {
    
        // loads the associated object
        if (empty($this->categoria_guia))
            $this->categoria_guia = new CategoriaGuia($this->categoria_guia_id);
    
        // returns the associated object
        return $this->categoria_guia;
    }

    /**
     * Method getGuias
     */
    public function getGuias()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('subcategoria_guia_id', '=', $this->id));
        return Guia::getObjects( $criteria );
    }

    public function set_guia_subcategoria_guia_to_string($guia_subcategoria_guia_to_string)
    {
        if(is_array($guia_subcategoria_guia_to_string))
        {
            $values = SubcategoriaGuia::where('id', 'in', $guia_subcategoria_guia_to_string)->getIndexedArray('nome', 'nome');
            $this->guia_subcategoria_guia_to_string = implode(', ', $values);
        }
        else
        {
            $this->guia_subcategoria_guia_to_string = $guia_subcategoria_guia_to_string;
        }

        $this->vdata['guia_subcategoria_guia_to_string'] = $this->guia_subcategoria_guia_to_string;
    }

    public function get_guia_subcategoria_guia_to_string()
    {
        if(!empty($this->guia_subcategoria_guia_to_string))
        {
            return $this->guia_subcategoria_guia_to_string;
        }
    
        $values = Guia::where('subcategoria_guia_id', '=', $this->id)->getIndexedArray('subcategoria_guia_id','{subcategoria_guia->nome}');
        return implode(', ', $values);
    }

    public function set_guia_cliente_to_string($guia_cliente_to_string)
    {
        if(is_array($guia_cliente_to_string))
        {
            $values = Cliente::where('id', 'in', $guia_cliente_to_string)->getIndexedArray('nome', 'nome');
            $this->guia_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->guia_cliente_to_string = $guia_cliente_to_string;
        }

        $this->vdata['guia_cliente_to_string'] = $this->guia_cliente_to_string;
    }

    public function get_guia_cliente_to_string()
    {
        if(!empty($this->guia_cliente_to_string))
        {
            return $this->guia_cliente_to_string;
        }
    
        $values = Guia::where('subcategoria_guia_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->nome}');
        return implode(', ', $values);
    }

    
}

