<?php

class CategoriaGuia extends TRecord
{
    const TABLENAME  = 'categoria_guia';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
            
    }

    /**
     * Method getSubcategoriaGuias
     */
    public function getSubcategoriaGuias()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('categoria_guia_id', '=', $this->id));
        return SubcategoriaGuia::getObjects( $criteria );
    }

    public function set_subcategoria_guia_categoria_guia_to_string($subcategoria_guia_categoria_guia_to_string)
    {
        if(is_array($subcategoria_guia_categoria_guia_to_string))
        {
            $values = CategoriaGuia::where('id', 'in', $subcategoria_guia_categoria_guia_to_string)->getIndexedArray('nome', 'nome');
            $this->subcategoria_guia_categoria_guia_to_string = implode(', ', $values);
        }
        else
        {
            $this->subcategoria_guia_categoria_guia_to_string = $subcategoria_guia_categoria_guia_to_string;
        }

        $this->vdata['subcategoria_guia_categoria_guia_to_string'] = $this->subcategoria_guia_categoria_guia_to_string;
    }

    public function get_subcategoria_guia_categoria_guia_to_string()
    {
        if(!empty($this->subcategoria_guia_categoria_guia_to_string))
        {
            return $this->subcategoria_guia_categoria_guia_to_string;
        }
    
        $values = SubcategoriaGuia::where('categoria_guia_id', '=', $this->id)->getIndexedArray('categoria_guia_id','{categoria_guia->nome}');
        return implode(', ', $values);
    }

    
}

