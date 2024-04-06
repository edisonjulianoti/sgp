<?php

class Relevancia extends TRecord
{
    const TABLENAME  = 'relevancia';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const IMPORTANTE = '1';
    const URGENTE = '2';
    const EVENTUAL = '3';

    

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
     * Method getAgendamentos
     */
    public function getAgendamentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('relevancia_id', '=', $this->id));
        return Agendamento::getObjects( $criteria );
    }
    /**
     * Method getTarefas
     */
    public function getTarefas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('relevancia_id', '=', $this->id));
        return Tarefa::getObjects( $criteria );
    }

    public function set_agendamento_relevancia_to_string($agendamento_relevancia_to_string)
    {
        if(is_array($agendamento_relevancia_to_string))
        {
            $values = Relevancia::where('id', 'in', $agendamento_relevancia_to_string)->getIndexedArray('descricao', 'descricao');
            $this->agendamento_relevancia_to_string = implode(', ', $values);
        }
        else
        {
            $this->agendamento_relevancia_to_string = $agendamento_relevancia_to_string;
        }

        $this->vdata['agendamento_relevancia_to_string'] = $this->agendamento_relevancia_to_string;
    }

    public function get_agendamento_relevancia_to_string()
    {
        if(!empty($this->agendamento_relevancia_to_string))
        {
            return $this->agendamento_relevancia_to_string;
        }
    
        $values = Agendamento::where('relevancia_id', '=', $this->id)->getIndexedArray('relevancia_id','{relevancia->descricao}');
        return implode(', ', $values);
    }

    public function set_agendamento_recorrencia_to_string($agendamento_recorrencia_to_string)
    {
        if(is_array($agendamento_recorrencia_to_string))
        {
            $values = Recorrencia::where('id', 'in', $agendamento_recorrencia_to_string)->getIndexedArray('id', 'id');
            $this->agendamento_recorrencia_to_string = implode(', ', $values);
        }
        else
        {
            $this->agendamento_recorrencia_to_string = $agendamento_recorrencia_to_string;
        }

        $this->vdata['agendamento_recorrencia_to_string'] = $this->agendamento_recorrencia_to_string;
    }

    public function get_agendamento_recorrencia_to_string()
    {
        if(!empty($this->agendamento_recorrencia_to_string))
        {
            return $this->agendamento_recorrencia_to_string;
        }
    
        $values = Agendamento::where('relevancia_id', '=', $this->id)->getIndexedArray('recorrencia_id','{recorrencia->id}');
        return implode(', ', $values);
    }

    public function set_agendamento_plano_to_string($agendamento_plano_to_string)
    {
        if(is_array($agendamento_plano_to_string))
        {
            $values = Plano::where('id', 'in', $agendamento_plano_to_string)->getIndexedArray('descricao', 'descricao');
            $this->agendamento_plano_to_string = implode(', ', $values);
        }
        else
        {
            $this->agendamento_plano_to_string = $agendamento_plano_to_string;
        }

        $this->vdata['agendamento_plano_to_string'] = $this->agendamento_plano_to_string;
    }

    public function get_agendamento_plano_to_string()
    {
        if(!empty($this->agendamento_plano_to_string))
        {
            return $this->agendamento_plano_to_string;
        }
    
        $values = Agendamento::where('relevancia_id', '=', $this->id)->getIndexedArray('plano_id','{plano->descricao}');
        return implode(', ', $values);
    }

    public function set_agendamento_tipo_to_string($agendamento_tipo_to_string)
    {
        if(is_array($agendamento_tipo_to_string))
        {
            $values = Tipo::where('id', 'in', $agendamento_tipo_to_string)->getIndexedArray('id', 'id');
            $this->agendamento_tipo_to_string = implode(', ', $values);
        }
        else
        {
            $this->agendamento_tipo_to_string = $agendamento_tipo_to_string;
        }

        $this->vdata['agendamento_tipo_to_string'] = $this->agendamento_tipo_to_string;
    }

    public function get_agendamento_tipo_to_string()
    {
        if(!empty($this->agendamento_tipo_to_string))
        {
            return $this->agendamento_tipo_to_string;
        }
    
        $values = Agendamento::where('relevancia_id', '=', $this->id)->getIndexedArray('tipo_id','{tipo->id}');
        return implode(', ', $values);
    }

    public function set_agendamento_considera_final_semana_to_string($agendamento_considera_final_semana_to_string)
    {
        if(is_array($agendamento_considera_final_semana_to_string))
        {
            $values = ConsideraFinalSemana::where('id', 'in', $agendamento_considera_final_semana_to_string)->getIndexedArray('descricao', 'descricao');
            $this->agendamento_considera_final_semana_to_string = implode(', ', $values);
        }
        else
        {
            $this->agendamento_considera_final_semana_to_string = $agendamento_considera_final_semana_to_string;
        }

        $this->vdata['agendamento_considera_final_semana_to_string'] = $this->agendamento_considera_final_semana_to_string;
    }

    public function get_agendamento_considera_final_semana_to_string()
    {
        if(!empty($this->agendamento_considera_final_semana_to_string))
        {
            return $this->agendamento_considera_final_semana_to_string;
        }
    
        $values = Agendamento::where('relevancia_id', '=', $this->id)->getIndexedArray('considera_final_semana_id','{considera_final_semana->descricao}');
        return implode(', ', $values);
    }

    public function set_agendamento_lembrete_agenda_to_string($agendamento_lembrete_agenda_to_string)
    {
        if(is_array($agendamento_lembrete_agenda_to_string))
        {
            $values = LembreteAgenda::where('id', 'in', $agendamento_lembrete_agenda_to_string)->getIndexedArray('id', 'id');
            $this->agendamento_lembrete_agenda_to_string = implode(', ', $values);
        }
        else
        {
            $this->agendamento_lembrete_agenda_to_string = $agendamento_lembrete_agenda_to_string;
        }

        $this->vdata['agendamento_lembrete_agenda_to_string'] = $this->agendamento_lembrete_agenda_to_string;
    }

    public function get_agendamento_lembrete_agenda_to_string()
    {
        if(!empty($this->agendamento_lembrete_agenda_to_string))
        {
            return $this->agendamento_lembrete_agenda_to_string;
        }
    
        $values = Agendamento::where('relevancia_id', '=', $this->id)->getIndexedArray('lembrete_agenda_id','{lembrete_agenda->id}');
        return implode(', ', $values);
    }

    public function set_agendamento_system_users_to_string($agendamento_system_users_to_string)
    {
        if(is_array($agendamento_system_users_to_string))
        {
            $values = SystemUsers::where('id', 'in', $agendamento_system_users_to_string)->getIndexedArray('name', 'name');
            $this->agendamento_system_users_to_string = implode(', ', $values);
        }
        else
        {
            $this->agendamento_system_users_to_string = $agendamento_system_users_to_string;
        }

        $this->vdata['agendamento_system_users_to_string'] = $this->agendamento_system_users_to_string;
    }

    public function get_agendamento_system_users_to_string()
    {
        if(!empty($this->agendamento_system_users_to_string))
        {
            return $this->agendamento_system_users_to_string;
        }
    
        $values = Agendamento::where('relevancia_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
        return implode(', ', $values);
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
    
        $values = Tarefa::where('relevancia_id', '=', $this->id)->getIndexedArray('plano_id','{plano->descricao}');
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
    
        $values = Tarefa::where('relevancia_id', '=', $this->id)->getIndexedArray('status_tarefa_id','{status_tarefa->descricao}');
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
    
        $values = Tarefa::where('relevancia_id', '=', $this->id)->getIndexedArray('relevancia_id','{relevancia->descricao}');
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
    
        $values = Tarefa::where('relevancia_id', '=', $this->id)->getIndexedArray('tipo_id','{tipo->id}');
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
    
        $values = Tarefa::where('relevancia_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
        return implode(', ', $values);
    }

    
}

