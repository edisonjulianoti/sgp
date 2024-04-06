<?php

class StatusTarefa extends TRecord
{
    const TABLENAME  = 'status_tarefa';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const PENDENTE = '1';
    const EMPROGRESSO = '2';
    const CONCLUIDA = '3';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('descricao');
        parent::addAttribute('cor');
            
    }

    /**
     * Method getTarefas
     */
    public function getTarefas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('status_tarefa_id', '=', $this->id));
        return Tarefa::getObjects( $criteria );
    }

    public function set_tarefa_plano_to_string($tarefa_plano_to_string)
    {
        if(is_array($tarefa_plano_to_string))
        {
            $values = Plano::where('id', 'in', $tarefa_plano_to_string)->getIndexedArray('descricao', 'descricao');
            $this->tarefa_plano_to_string = implode(', ', $values);
        }
        else
        {
            $this->tarefa_plano_to_string = $tarefa_plano_to_string;
        }

        $this->vdata['tarefa_plano_to_string'] = $this->tarefa_plano_to_string;
    }

    public function get_tarefa_plano_to_string()
    {
        if(!empty($this->tarefa_plano_to_string))
        {
            return $this->tarefa_plano_to_string;
        }
    
        $values = Tarefa::where('status_tarefa_id', '=', $this->id)->getIndexedArray('plano_id','{plano->descricao}');
        return implode(', ', $values);
    }

    public function set_tarefa_status_tarefa_to_string($tarefa_status_tarefa_to_string)
    {
        if(is_array($tarefa_status_tarefa_to_string))
        {
            $values = StatusTarefa::where('id', 'in', $tarefa_status_tarefa_to_string)->getIndexedArray('descricao', 'descricao');
            $this->tarefa_status_tarefa_to_string = implode(', ', $values);
        }
        else
        {
            $this->tarefa_status_tarefa_to_string = $tarefa_status_tarefa_to_string;
        }

        $this->vdata['tarefa_status_tarefa_to_string'] = $this->tarefa_status_tarefa_to_string;
    }

    public function get_tarefa_status_tarefa_to_string()
    {
        if(!empty($this->tarefa_status_tarefa_to_string))
        {
            return $this->tarefa_status_tarefa_to_string;
        }
    
        $values = Tarefa::where('status_tarefa_id', '=', $this->id)->getIndexedArray('status_tarefa_id','{status_tarefa->descricao}');
        return implode(', ', $values);
    }

    public function set_tarefa_relevancia_to_string($tarefa_relevancia_to_string)
    {
        if(is_array($tarefa_relevancia_to_string))
        {
            $values = Relevancia::where('id', 'in', $tarefa_relevancia_to_string)->getIndexedArray('descricao', 'descricao');
            $this->tarefa_relevancia_to_string = implode(', ', $values);
        }
        else
        {
            $this->tarefa_relevancia_to_string = $tarefa_relevancia_to_string;
        }

        $this->vdata['tarefa_relevancia_to_string'] = $this->tarefa_relevancia_to_string;
    }

    public function get_tarefa_relevancia_to_string()
    {
        if(!empty($this->tarefa_relevancia_to_string))
        {
            return $this->tarefa_relevancia_to_string;
        }
    
        $values = Tarefa::where('status_tarefa_id', '=', $this->id)->getIndexedArray('relevancia_id','{relevancia->descricao}');
        return implode(', ', $values);
    }

    public function set_tarefa_tipo_to_string($tarefa_tipo_to_string)
    {
        if(is_array($tarefa_tipo_to_string))
        {
            $values = Tipo::where('id', 'in', $tarefa_tipo_to_string)->getIndexedArray('id', 'id');
            $this->tarefa_tipo_to_string = implode(', ', $values);
        }
        else
        {
            $this->tarefa_tipo_to_string = $tarefa_tipo_to_string;
        }

        $this->vdata['tarefa_tipo_to_string'] = $this->tarefa_tipo_to_string;
    }

    public function get_tarefa_tipo_to_string()
    {
        if(!empty($this->tarefa_tipo_to_string))
        {
            return $this->tarefa_tipo_to_string;
        }
    
        $values = Tarefa::where('status_tarefa_id', '=', $this->id)->getIndexedArray('tipo_id','{tipo->id}');
        return implode(', ', $values);
    }

    public function set_tarefa_system_users_to_string($tarefa_system_users_to_string)
    {
        if(is_array($tarefa_system_users_to_string))
        {
            $values = SystemUsers::where('id', 'in', $tarefa_system_users_to_string)->getIndexedArray('name', 'name');
            $this->tarefa_system_users_to_string = implode(', ', $values);
        }
        else
        {
            $this->tarefa_system_users_to_string = $tarefa_system_users_to_string;
        }

        $this->vdata['tarefa_system_users_to_string'] = $this->tarefa_system_users_to_string;
    }

    public function get_tarefa_system_users_to_string()
    {
        if(!empty($this->tarefa_system_users_to_string))
        {
            return $this->tarefa_system_users_to_string;
        }
    
        $values = Tarefa::where('status_tarefa_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
        return implode(', ', $values);
    }

    
}

