<?php

class SaldoCalculado extends TRecord
{
    const TABLENAME  = 'saldo_calculado';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const SIM = '1';
    const NAO = '2';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('descricao');
            
    }

    /**
     * Method getContas
     */
    public function getContas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('saldo_calculado_id', '=', $this->id));
        return Conta::getObjects( $criteria );
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
    
        $values = Conta::where('saldo_calculado_id', '=', $this->id)->getIndexedArray('tipo_conta_id','{tipo_conta->descricao}');
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
    
        $values = Conta::where('saldo_calculado_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
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
    
        $values = Conta::where('saldo_calculado_id', '=', $this->id)->getIndexedArray('saldo_calculado_id','{saldo_calculado->id}');
        return implode(', ', $values);
    }

    
}

