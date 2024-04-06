<?php

class TipoLancamento extends TRecord
{
    const TABLENAME  = 'tipo_lancamento';
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
     * Method getLancamentos
     */
    public function getLancamentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('tipo_lancamento_id', '=', $this->id));
        return Lancamento::getObjects( $criteria );
    }

    public function set_lancamento_categoria_to_string($lancamento_categoria_to_string)
    {
        if(is_array($lancamento_categoria_to_string))
        {
            $values = Categoria::where('id', 'in', $lancamento_categoria_to_string)->getIndexedArray('descricao', 'descricao');
            $this->lancamento_categoria_to_string = implode(', ', $values);
        }
        else
        {
            $this->lancamento_categoria_to_string = $lancamento_categoria_to_string;
        }

        $this->vdata['lancamento_categoria_to_string'] = $this->lancamento_categoria_to_string;
    }

    public function get_lancamento_categoria_to_string()
    {
        if(!empty($this->lancamento_categoria_to_string))
        {
            return $this->lancamento_categoria_to_string;
        }
    
        $values = Lancamento::where('tipo_lancamento_id', '=', $this->id)->getIndexedArray('categoria_id','{categoria->descricao}');
        return implode(', ', $values);
    }

    public function set_lancamento_conta_to_string($lancamento_conta_to_string)
    {
        if(is_array($lancamento_conta_to_string))
        {
            $values = Conta::where('id', 'in', $lancamento_conta_to_string)->getIndexedArray('descricao', 'descricao');
            $this->lancamento_conta_to_string = implode(', ', $values);
        }
        else
        {
            $this->lancamento_conta_to_string = $lancamento_conta_to_string;
        }

        $this->vdata['lancamento_conta_to_string'] = $this->lancamento_conta_to_string;
    }

    public function get_lancamento_conta_to_string()
    {
        if(!empty($this->lancamento_conta_to_string))
        {
            return $this->lancamento_conta_to_string;
        }
    
        $values = Lancamento::where('tipo_lancamento_id', '=', $this->id)->getIndexedArray('conta_id','{conta->descricao}');
        return implode(', ', $values);
    }

    public function set_lancamento_status_lancamento_to_string($lancamento_status_lancamento_to_string)
    {
        if(is_array($lancamento_status_lancamento_to_string))
        {
            $values = StatusLancamento::where('id', 'in', $lancamento_status_lancamento_to_string)->getIndexedArray('id', 'id');
            $this->lancamento_status_lancamento_to_string = implode(', ', $values);
        }
        else
        {
            $this->lancamento_status_lancamento_to_string = $lancamento_status_lancamento_to_string;
        }

        $this->vdata['lancamento_status_lancamento_to_string'] = $this->lancamento_status_lancamento_to_string;
    }

    public function get_lancamento_status_lancamento_to_string()
    {
        if(!empty($this->lancamento_status_lancamento_to_string))
        {
            return $this->lancamento_status_lancamento_to_string;
        }
    
        $values = Lancamento::where('tipo_lancamento_id', '=', $this->id)->getIndexedArray('status_lancamento_id','{status_lancamento->id}');
        return implode(', ', $values);
    }

    public function set_lancamento_system_users_to_string($lancamento_system_users_to_string)
    {
        if(is_array($lancamento_system_users_to_string))
        {
            $values = SystemUsers::where('id', 'in', $lancamento_system_users_to_string)->getIndexedArray('name', 'name');
            $this->lancamento_system_users_to_string = implode(', ', $values);
        }
        else
        {
            $this->lancamento_system_users_to_string = $lancamento_system_users_to_string;
        }

        $this->vdata['lancamento_system_users_to_string'] = $this->lancamento_system_users_to_string;
    }

    public function get_lancamento_system_users_to_string()
    {
        if(!empty($this->lancamento_system_users_to_string))
        {
            return $this->lancamento_system_users_to_string;
        }
    
        $values = Lancamento::where('tipo_lancamento_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
        return implode(', ', $values);
    }

    public function set_lancamento_tipo_lancamento_to_string($lancamento_tipo_lancamento_to_string)
    {
        if(is_array($lancamento_tipo_lancamento_to_string))
        {
            $values = TipoLancamento::where('id', 'in', $lancamento_tipo_lancamento_to_string)->getIndexedArray('id', 'id');
            $this->lancamento_tipo_lancamento_to_string = implode(', ', $values);
        }
        else
        {
            $this->lancamento_tipo_lancamento_to_string = $lancamento_tipo_lancamento_to_string;
        }

        $this->vdata['lancamento_tipo_lancamento_to_string'] = $this->lancamento_tipo_lancamento_to_string;
    }

    public function get_lancamento_tipo_lancamento_to_string()
    {
        if(!empty($this->lancamento_tipo_lancamento_to_string))
        {
            return $this->lancamento_tipo_lancamento_to_string;
        }
    
        $values = Lancamento::where('tipo_lancamento_id', '=', $this->id)->getIndexedArray('tipo_lancamento_id','{tipo_lancamento->id}');
        return implode(', ', $values);
    }

    
}

