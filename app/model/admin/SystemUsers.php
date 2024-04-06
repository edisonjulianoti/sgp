<?php

class SystemUsers extends TRecord
{
    const TABLENAME  = 'system_users';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'max'; // {max, serial}

    private $system_unit;
    private $frontpage;

    private $unit;
    private $system_user_groups = array();
    private $system_user_programs = array();
    private $system_user_units = array();
            

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('name');
        parent::addAttribute('login');
        parent::addAttribute('password');
        parent::addAttribute('email');
        parent::addAttribute('frontpage_id');
        parent::addAttribute('system_unit_id');
        parent::addAttribute('active');
        parent::addAttribute('accepted_term_policy_at');
        parent::addAttribute('accepted_term_policy');
    
    }

    /**
     * Method set_system_unit
     * Sample of usage: $var->system_unit = $object;
     * @param $object Instance of SystemUnit
     */
    public function set_system_unit(SystemUnit $object)
    {
        $this->system_unit = $object;
        $this->system_unit_id = $object->id;
    }

    /**
     * Method get_system_unit
     * Sample of usage: $var->system_unit->attribute;
     * @returns SystemUnit instance
     */
    public function get_system_unit()
    {
    
        // loads the associated object
        if (empty($this->system_unit))
            $this->system_unit = new SystemUnit($this->system_unit_id);
    
        // returns the associated object
        return $this->system_unit;
    }
    /**
     * Method set_system_program
     * Sample of usage: $var->system_program = $object;
     * @param $object Instance of SystemProgram
     */
    public function set_frontpage(SystemProgram $object)
    {
        $this->frontpage = $object;
        $this->frontpage_id = $object->id;
    }

    /**
     * Method get_frontpage
     * Sample of usage: $var->frontpage->attribute;
     * @returns SystemProgram instance
     */
    public function get_frontpage()
    {
    
        // loads the associated object
        if (empty($this->frontpage))
            $this->frontpage = new SystemProgram($this->frontpage_id);
    
        // returns the associated object
        return $this->frontpage;
    }

    /**
     * Method getAgendamentos
     */
    public function getAgendamentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_users_id', '=', $this->id));
        return Agendamento::getObjects( $criteria );
    }
    /**
     * Method getCategorias
     */
    public function getCategorias()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_users_id', '=', $this->id));
        return Categoria::getObjects( $criteria );
    }
    /**
     * Method getContas
     */
    public function getContas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_users_id', '=', $this->id));
        return Conta::getObjects( $criteria );
    }
    /**
     * Method getLancamentos
     */
    public function getLancamentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_users_id', '=', $this->id));
        return Lancamento::getObjects( $criteria );
    }
    /**
     * Method getPlanos
     */
    public function getPlanos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_users_id', '=', $this->id));
        return Plano::getObjects( $criteria );
    }
    /**
     * Method getTarefas
     */
    public function getTarefas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_users_id', '=', $this->id));
        return Tarefa::getObjects( $criteria );
    }
    /**
     * Method getTransacaos
     */
    public function getTransacaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_users_id', '=', $this->id));
        return Transacao::getObjects( $criteria );
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
    
        $values = Agendamento::where('system_users_id', '=', $this->id)->getIndexedArray('relevancia_id','{relevancia->descricao}');
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
    
        $values = Agendamento::where('system_users_id', '=', $this->id)->getIndexedArray('recorrencia_id','{recorrencia->id}');
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
    
        $values = Agendamento::where('system_users_id', '=', $this->id)->getIndexedArray('plano_id','{plano->descricao}');
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
    
        $values = Agendamento::where('system_users_id', '=', $this->id)->getIndexedArray('tipo_id','{tipo->id}');
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
    
        $values = Agendamento::where('system_users_id', '=', $this->id)->getIndexedArray('considera_final_semana_id','{considera_final_semana->descricao}');
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
    
        $values = Agendamento::where('system_users_id', '=', $this->id)->getIndexedArray('lembrete_agenda_id','{lembrete_agenda->id}');
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
    
        $values = Agendamento::where('system_users_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
        return implode(', ', $values);
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
    
        $values = Categoria::where('system_users_id', '=', $this->id)->getIndexedArray('tipo_categoria_id','{tipo_categoria->id}');
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
    
        $values = Categoria::where('system_users_id', '=', $this->id)->getIndexedArray('totaliza_receita_despesa_id','{totaliza_receita_despesa->id}');
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
    
        $values = Categoria::where('system_users_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
        return implode(', ', $values);
    }

    public function set_conta_tipo_conta_to_string($conta_tipo_conta_to_string)
    {
        if(is_array($conta_tipo_conta_to_string))
        {
            $values = TipoConta::where('id', 'in', $conta_tipo_conta_to_string)->getIndexedArray('descricao', 'descricao');
            $this->conta_tipo_conta_to_string = implode(', ', $values);
        }
        else
        {
            $this->conta_tipo_conta_to_string = $conta_tipo_conta_to_string;
        }

        $this->vdata['conta_tipo_conta_to_string'] = $this->conta_tipo_conta_to_string;
    }

    public function get_conta_tipo_conta_to_string()
    {
        if(!empty($this->conta_tipo_conta_to_string))
        {
            return $this->conta_tipo_conta_to_string;
        }
    
        $values = Conta::where('system_users_id', '=', $this->id)->getIndexedArray('tipo_conta_id','{tipo_conta->descricao}');
        return implode(', ', $values);
    }

    public function set_conta_system_users_to_string($conta_system_users_to_string)
    {
        if(is_array($conta_system_users_to_string))
        {
            $values = SystemUsers::where('id', 'in', $conta_system_users_to_string)->getIndexedArray('name', 'name');
            $this->conta_system_users_to_string = implode(', ', $values);
        }
        else
        {
            $this->conta_system_users_to_string = $conta_system_users_to_string;
        }

        $this->vdata['conta_system_users_to_string'] = $this->conta_system_users_to_string;
    }

    public function get_conta_system_users_to_string()
    {
        if(!empty($this->conta_system_users_to_string))
        {
            return $this->conta_system_users_to_string;
        }
    
        $values = Conta::where('system_users_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
        return implode(', ', $values);
    }

    public function set_conta_saldo_calculado_to_string($conta_saldo_calculado_to_string)
    {
        if(is_array($conta_saldo_calculado_to_string))
        {
            $values = SaldoCalculado::where('id', 'in', $conta_saldo_calculado_to_string)->getIndexedArray('id', 'id');
            $this->conta_saldo_calculado_to_string = implode(', ', $values);
        }
        else
        {
            $this->conta_saldo_calculado_to_string = $conta_saldo_calculado_to_string;
        }

        $this->vdata['conta_saldo_calculado_to_string'] = $this->conta_saldo_calculado_to_string;
    }

    public function get_conta_saldo_calculado_to_string()
    {
        if(!empty($this->conta_saldo_calculado_to_string))
        {
            return $this->conta_saldo_calculado_to_string;
        }
    
        $values = Conta::where('system_users_id', '=', $this->id)->getIndexedArray('saldo_calculado_id','{saldo_calculado->id}');
        return implode(', ', $values);
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
    
        $values = Lancamento::where('system_users_id', '=', $this->id)->getIndexedArray('categoria_id','{categoria->descricao}');
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
    
        $values = Lancamento::where('system_users_id', '=', $this->id)->getIndexedArray('conta_id','{conta->descricao}');
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
    
        $values = Lancamento::where('system_users_id', '=', $this->id)->getIndexedArray('status_lancamento_id','{status_lancamento->id}');
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
    
        $values = Lancamento::where('system_users_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
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
    
        $values = Lancamento::where('system_users_id', '=', $this->id)->getIndexedArray('tipo_lancamento_id','{tipo_lancamento->id}');
        return implode(', ', $values);
    }

    public function set_plano_system_users_to_string($plano_system_users_to_string)
    {
        if(is_array($plano_system_users_to_string))
        {
            $values = SystemUsers::where('id', 'in', $plano_system_users_to_string)->getIndexedArray('name', 'name');
            $this->plano_system_users_to_string = implode(', ', $values);
        }
        else
        {
            $this->plano_system_users_to_string = $plano_system_users_to_string;
        }

        $this->vdata['plano_system_users_to_string'] = $this->plano_system_users_to_string;
    }

    public function get_plano_system_users_to_string()
    {
        if(!empty($this->plano_system_users_to_string))
        {
            return $this->plano_system_users_to_string;
        }
    
        $values = Plano::where('system_users_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
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
    
        $values = Tarefa::where('system_users_id', '=', $this->id)->getIndexedArray('plano_id','{plano->descricao}');
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
    
        $values = Tarefa::where('system_users_id', '=', $this->id)->getIndexedArray('status_tarefa_id','{status_tarefa->descricao}');
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
    
        $values = Tarefa::where('system_users_id', '=', $this->id)->getIndexedArray('relevancia_id','{relevancia->descricao}');
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
    
        $values = Tarefa::where('system_users_id', '=', $this->id)->getIndexedArray('tipo_id','{tipo->id}');
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
    
        $values = Tarefa::where('system_users_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
        return implode(', ', $values);
    }

    public function set_transacao_conta_to_string($transacao_conta_to_string)
    {
        if(is_array($transacao_conta_to_string))
        {
            $values = Conta::where('id', 'in', $transacao_conta_to_string)->getIndexedArray('descricao', 'descricao');
            $this->transacao_conta_to_string = implode(', ', $values);
        }
        else
        {
            $this->transacao_conta_to_string = $transacao_conta_to_string;
        }

        $this->vdata['transacao_conta_to_string'] = $this->transacao_conta_to_string;
    }

    public function get_transacao_conta_to_string()
    {
        if(!empty($this->transacao_conta_to_string))
        {
            return $this->transacao_conta_to_string;
        }
    
        $values = Transacao::where('system_users_id', '=', $this->id)->getIndexedArray('conta_id','{conta->descricao}');
        return implode(', ', $values);
    }

    public function set_transacao_lancamento_to_string($transacao_lancamento_to_string)
    {
        if(is_array($transacao_lancamento_to_string))
        {
            $values = Lancamento::where('id', 'in', $transacao_lancamento_to_string)->getIndexedArray('descricao', 'descricao');
            $this->transacao_lancamento_to_string = implode(', ', $values);
        }
        else
        {
            $this->transacao_lancamento_to_string = $transacao_lancamento_to_string;
        }

        $this->vdata['transacao_lancamento_to_string'] = $this->transacao_lancamento_to_string;
    }

    public function get_transacao_lancamento_to_string()
    {
        if(!empty($this->transacao_lancamento_to_string))
        {
            return $this->transacao_lancamento_to_string;
        }
    
        $values = Transacao::where('system_users_id', '=', $this->id)->getIndexedArray('lancamento_id','{lancamento->descricao}');
        return implode(', ', $values);
    }

    public function set_transacao_system_users_to_string($transacao_system_users_to_string)
    {
        if(is_array($transacao_system_users_to_string))
        {
            $values = SystemUsers::where('id', 'in', $transacao_system_users_to_string)->getIndexedArray('name', 'name');
            $this->transacao_system_users_to_string = implode(', ', $values);
        }
        else
        {
            $this->transacao_system_users_to_string = $transacao_system_users_to_string;
        }

        $this->vdata['transacao_system_users_to_string'] = $this->transacao_system_users_to_string;
    }

    public function get_transacao_system_users_to_string()
    {
        if(!empty($this->transacao_system_users_to_string))
        {
            return $this->transacao_system_users_to_string;
        }
    
        $values = Transacao::where('system_users_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
        return implode(', ', $values);
    }

    /**
     * Return the user' group's
     * @return Collection of SystemGroup
     */
    public function getSystemUserGroups()
    {
        return parent::loadAggregate('SystemGroup', 'SystemUserGroup', 'system_user_id', 'system_group_id', $this->id);
    }

    /**
     * Return the user' unit's
     * @return Collection of SystemUnit
     */
    public function getSystemUserUnits()
    {
        return parent::loadAggregate('SystemUnit', 'SystemUserUnit', 'system_user_id', 'system_unit_id', $this->id);
    }

    /**
     * Return the user' program's
     * @return Collection of SystemProgram
     */
    public function getSystemUserPrograms()
    {
        return parent::loadAggregate('SystemProgram', 'SystemUserProgram', 'system_user_id', 'system_program_id', $this->id);
    }

    /**
     * Returns the frontpage name
     */
    public function get_frontpage_name()
    {
        // loads the associated object
        if (empty($this->frontpage))
            $this->frontpage = new SystemProgram($this->frontpage_id);

        // returns the associated object
        return $this->frontpage->name;
    }

    /**
     * Returns the unit
     */
    public function get_unit()
    {
        // loads the associated object
        if (empty($this->unit))
            $this->unit = new SystemUnit($this->system_unit_id);

        // returns the associated object
        return $this->unit;
    }

    /**
     * Add a Group to the user
     * @param $object Instance of SystemGroup
     */
    public function addSystemUserGroup(SystemGroup $systemgroup)
    {
        $object = new SystemUserGroup;
        $object->system_group_id = $systemgroup->id;
        $object->system_user_id = $this->id;
        $object->store();
    }

    /**
     * Add a Unit to the user
     * @param $object Instance of SystemUnit
     */
    public function addSystemUserUnit(SystemUnit $systemunit)
    {
        $object = new SystemUserUnit;
        $object->system_unit_id = $systemunit->id;
        $object->system_user_id = $this->id;
        $object->store();
    }

    /**
     * Add a program to the user
     * @param $object Instance of SystemProgram
     */
    public function addSystemUserProgram(SystemProgram $systemprogram)
    {
        $object = new SystemUserProgram;
        $object->system_program_id = $systemprogram->id;
        $object->system_user_id = $this->id;
        $object->store();
    }

    /**
     * Get user group ids
     */
    public function getSystemUserGroupIds( $as_string = false )
    {
        $groupids = array();
        $groups = $this->getSystemUserGroups();
        if ($groups)
        {
            foreach ($groups as $group)
            {
                $groupids[] = $group->id;
            }
        }
    
        if ($as_string)
        {
            return implode(',', $groupids);
        }
    
        return $groupids;
    }

    /**
     * Get user unit ids
     */
    public function getSystemUserUnitIds( $as_string = false )
    {
        $unitids = array();
        $units = $this->getSystemUserUnits();
        if ($units)
        {
            foreach ($units as $unit)
            {
                $unitids[] = $unit->id;
            }
        }
    
        if ($as_string)
        {
            return implode(',', $unitids);
        }
    
        return $unitids;
    }

    /**
     * Get user group names
     */
    public function getSystemUserGroupNames()
    {
        $groupnames = array();
        $groups = $this->getSystemUserGroups();
        if ($groups)
        {
            foreach ($groups as $group)
            {
                $groupnames[] = $group->name;
            }
        }
    
        return implode(',', $groupnames);
    }

    /**
     * Reset aggregates
     */
    public function clearParts()
    {
        SystemUserGroup::where('system_user_id', '=', $this->id)->delete();
        SystemUserUnit::where('system_user_id', '=', $this->id)->delete();
        SystemUserProgram::where('system_user_id', '=', $this->id)->delete();
    }

    /**
     * Delete the object and its aggregates
     * @param $id object ID
     */
    public function delete($id = NULL)
    {
        // delete the related System_userSystem_user_group objects
        $id = isset($id) ? $id : $this->id;
    
        SystemUserGroup::where('system_user_id', '=', $id)->delete();
        SystemUserUnit::where('system_user_id', '=', $id)->delete();
        SystemUserProgram::where('system_user_id', '=', $id)->delete();
    
        // delete the object itself
        parent::delete($id);
    }

    /**
     * Validate user login
     * @param $login String with user login
     */
    public static function validate($login)
    {
        $user = self::newFromLogin($login);
    
        if ($user instanceof SystemUsers)
        {
            if ($user->active == 'N')
            {
                throw new Exception(_t('Inactive user'));
            }
        }
        else
        {
            throw new Exception(_t('User not found'));
        }
    
        return $user;
    }

    /**
     * Authenticate the user
     * @param $login String with user login
     * @param $password String with user password
     * @returns TRUE if the password matches, otherwise throw Exception
     */
    public static function authenticate($login, $password)
    {
        $user = self::newFromLogin($login);
        if ($user->password !== md5($password))
        {
            throw new Exception(_t('Wrong password'));
        }
    
        return $user;
    }

    /**
     * Returns a SystemUser object based on its login
     * @param $login String with user login
     */
    static public function newFromLogin($login)
    {
        return SystemUsers::where('login', '=', $login)->first();
    }

    /**
     * Returns a SystemUser object based on its e-mail
     * @param $email String with user email
     */
    static public function newFromEmail($email)
    {
        return SystemUsers::where('email', '=', $email)->first();
    }

    /**
     * Return the programs the user has permission to run
     */
    public function getPrograms()
    {
        $programs = array();
    
        foreach( $this->getSystemUserGroups() as $group )
        {
            foreach( $group->getSystemPrograms() as $prog )
            {
                $programs[$prog->controller] = true;
            }
        }
            
        foreach( $this->getSystemUserPrograms() as $prog )
        {
            $programs[$prog->controller] = true;
        }
    
        return $programs;
    }

    /**
     * Return the programs the user has permission to run
     */
    public function getProgramsList()
    {
        $programs = array();
    
        foreach( $this->getSystemUserGroups() as $group )
        {
            foreach( $group->getSystemPrograms() as $prog )
            {
                $programs[$prog->controller] = $prog->name;
            }
        }
            
        foreach( $this->getSystemUserPrograms() as $prog )
        {
            $programs[$prog->controller] = $prog->name;
        }
    
        asort($programs);
        return $programs;
    }

    /**
     * Check if the user is within a group
     */
    public function checkInGroup( SystemGroup $group )
    {
        $user_groups = array();
        foreach( $this->getSystemUserGroups() as $user_group )
        {
            $user_groups[] = $user_group->id;
        }

        return in_array($group->id, $user_groups);
    }

    /**
     *
     */
    public static function getInGroups( $groups )
    {
        $collection = [];
        $users = self::all();
        if ($users)
        {
            foreach ($users as $user)
            {
                foreach ($groups as $group)
                {
                    if ($user->checkInGroup($group))
                    {
                        $collection[] = $user;
                    }
                }
            }
        }
        return $collection;
    }

    /**
     * Clone the entire object and related ones
     */
    public function cloneUser()
    {
        $groups   = $this->getSystemUserGroups();
        $units    = $this->getSystemUserUnits();
        $programs = $this->getSystemUserPrograms();
        unset($this->id);
        $this->name .= ' (clone)';
        $this->store();
        if ($groups)
        {
            foreach ($groups as $group)
            {
                $this->addSystemUserGroup( $group );
            }
        }
        if ($units)
        {
            foreach ($units as $unit)
            {
                $this->addSystemUserUnit( $unit );
            }
        }
        if ($programs)
        {
            foreach ($programs as $program)
            {
                $this->addSystemUserProgram( $program );
            }
        }
    }

            
}

