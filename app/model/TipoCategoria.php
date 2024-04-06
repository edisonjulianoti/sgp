<?php

class TipoCategoria extends TRecord
{
    const TABLENAME  = 'tipo_categoria';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const RECEITA = '1';
    const DESPESA = '2';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('descricao');
            
    }

    /**
     * Method getCategorias
     */
    public function getCategorias()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('tipo_categoria_id', '=', $this->id));
        return Categoria::getObjects( $criteria );
    }

    public function set_categoria_tipo_categoria_to_string($categoria_tipo_categoria_to_string)
    {
        if(is_array($categoria_tipo_categoria_to_string))
        {
            $values = TipoCategoria::where('id', 'in', $categoria_tipo_categoria_to_string)->getIndexedArray('id', 'id');
            $this->categoria_tipo_categoria_to_string = implode(', ', $values);
        }
        else
        {
            $this->categoria_tipo_categoria_to_string = $categoria_tipo_categoria_to_string;
        }

        $this->vdata['categoria_tipo_categoria_to_string'] = $this->categoria_tipo_categoria_to_string;
    }

    public function get_categoria_tipo_categoria_to_string()
    {
        if(!empty($this->categoria_tipo_categoria_to_string))
        {
            return $this->categoria_tipo_categoria_to_string;
        }
    
        $values = Categoria::where('tipo_categoria_id', '=', $this->id)->getIndexedArray('tipo_categoria_id','{tipo_categoria->id}');
        return implode(', ', $values);
    }

    public function set_categoria_totaliza_receita_despesa_to_string($categoria_totaliza_receita_despesa_to_string)
    {
        if(is_array($categoria_totaliza_receita_despesa_to_string))
        {
            $values = TotalizaReceitaDespesa::where('id', 'in', $categoria_totaliza_receita_despesa_to_string)->getIndexedArray('id', 'id');
            $this->categoria_totaliza_receita_despesa_to_string = implode(', ', $values);
        }
        else
        {
            $this->categoria_totaliza_receita_despesa_to_string = $categoria_totaliza_receita_despesa_to_string;
        }

        $this->vdata['categoria_totaliza_receita_despesa_to_string'] = $this->categoria_totaliza_receita_despesa_to_string;
    }

    public function get_categoria_totaliza_receita_despesa_to_string()
    {
        if(!empty($this->categoria_totaliza_receita_despesa_to_string))
        {
            return $this->categoria_totaliza_receita_despesa_to_string;
        }
    
        $values = Categoria::where('tipo_categoria_id', '=', $this->id)->getIndexedArray('totaliza_receita_despesa_id','{totaliza_receita_despesa->id}');
        return implode(', ', $values);
    }

    public function set_categoria_system_users_to_string($categoria_system_users_to_string)
    {
        if(is_array($categoria_system_users_to_string))
        {
            $values = SystemUsers::where('id', 'in', $categoria_system_users_to_string)->getIndexedArray('name', 'name');
            $this->categoria_system_users_to_string = implode(', ', $values);
        }
        else
        {
            $this->categoria_system_users_to_string = $categoria_system_users_to_string;
        }

        $this->vdata['categoria_system_users_to_string'] = $this->categoria_system_users_to_string;
    }

    public function get_categoria_system_users_to_string()
    {
        if(!empty($this->categoria_system_users_to_string))
        {
            return $this->categoria_system_users_to_string;
        }
    
        $values = Categoria::where('tipo_categoria_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
        return implode(', ', $values);
    }

    
}

