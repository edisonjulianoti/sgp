<?php

class LembreteAgenda extends TRecord
{
    const TABLENAME  = 'lembrete_agenda';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CINCOMINUTOS = '1';
    const DEZMINUTOS = '2';
    const QUIZEMINUTOS = '3';
    const VINTEMINUTOS = '4';
    const TRINTAMINUTOS = '5';
    const QUARENTAECINCOMINUTOS = '6';
    const UMAHORA = '7';
    const DUASHORA = '8';
    const TRESHORAS = '9';
    const QUATROHORAS = '10';
    const CINCOHORAS = '11';
    const SEISHORAS = '12';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('minutos');
        parent::addAttribute('descricao');
        parent::addAttribute('mensagem');
            
    }

    /**
     * Method getAgendamentos
     */
    public function getAgendamentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('lembrete_agenda_id', '=', $this->id));
        return Agendamento::getObjects( $criteria );
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
    
        $values = Agendamento::where('lembrete_agenda_id', '=', $this->id)->getIndexedArray('relevancia_id','{relevancia->descricao}');
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
    
        $values = Agendamento::where('lembrete_agenda_id', '=', $this->id)->getIndexedArray('recorrencia_id','{recorrencia->id}');
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
    
        $values = Agendamento::where('lembrete_agenda_id', '=', $this->id)->getIndexedArray('plano_id','{plano->descricao}');
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
    
        $values = Agendamento::where('lembrete_agenda_id', '=', $this->id)->getIndexedArray('tipo_id','{tipo->id}');
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
    
        $values = Agendamento::where('lembrete_agenda_id', '=', $this->id)->getIndexedArray('considera_final_semana_id','{considera_final_semana->descricao}');
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
    
        $values = Agendamento::where('lembrete_agenda_id', '=', $this->id)->getIndexedArray('lembrete_agenda_id','{lembrete_agenda->id}');
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
    
        $values = Agendamento::where('lembrete_agenda_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
        return implode(', ', $values);
    }

    
}

