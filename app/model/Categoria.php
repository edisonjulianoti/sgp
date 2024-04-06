<?php

class Categoria extends TRecord
{
    const TABLENAME  = 'categoria';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATEDAT  = 'created_at';
    const UPDATEDAT  = 'updated_at';

    private $tipo_categoria;
    private $totaliza_receita_despesa;
    private $system_users;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('descricao');
        parent::addAttribute('tipo_categoria_id');
        parent::addAttribute('totaliza_receita_despesa_id');
        parent::addAttribute('system_users_id');
    
    }

    /**
     * Method set_tipo_categoria
     * Sample of usage: $var->tipo_categoria = $object;
     * @param $object Instance of TipoCategoria
     */
    public function set_tipo_categoria(TipoCategoria $object)
    {
        $this->tipo_categoria = $object;
        $this->tipo_categoria_id = $object->id;
    }

    /**
     * Method get_tipo_categoria
     * Sample of usage: $var->tipo_categoria->attribute;
     * @returns TipoCategoria instance
     */
    public function get_tipo_categoria()
    {
    
        // loads the associated object
        if (empty($this->tipo_categoria))
            $this->tipo_categoria = new TipoCategoria($this->tipo_categoria_id);
    
        // returns the associated object
        return $this->tipo_categoria;
    }
    /**
     * Method set_totaliza_receita_despesa
     * Sample of usage: $var->totaliza_receita_despesa = $object;
     * @param $object Instance of TotalizaReceitaDespesa
     */
    public function set_totaliza_receita_despesa(TotalizaReceitaDespesa $object)
    {
        $this->totaliza_receita_despesa = $object;
        $this->totaliza_receita_despesa_id = $object->id;
    }

    /**
     * Method get_totaliza_receita_despesa
     * Sample of usage: $var->totaliza_receita_despesa->attribute;
     * @returns TotalizaReceitaDespesa instance
     */
    public function get_totaliza_receita_despesa()
    {
    
        // loads the associated object
        if (empty($this->totaliza_receita_despesa))
            $this->totaliza_receita_despesa = new TotalizaReceitaDespesa($this->totaliza_receita_despesa_id);
    
        // returns the associated object
        return $this->totaliza_receita_despesa;
    }
    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_system_users(SystemUsers $object)
    {
        $this->system_users = $object;
        $this->system_users_id = $object->id;
    }

    /**
     * Method get_system_users
     * Sample of usage: $var->system_users->attribute;
     * @returns SystemUsers instance
     */
    public function get_system_users()
    {
    
        // loads the associated object
        if (empty($this->system_users))
            $this->system_users = new SystemUsers($this->system_users_id);
    
        // returns the associated object
        return $this->system_users;
    }

    /**
     * Method getLancamentos
     */
    public function getLancamentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('categoria_id', '=', $this->id));
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
    
        $values = Lancamento::where('categoria_id', '=', $this->id)->getIndexedArray('categoria_id','{categoria->descricao}');
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
    
        $values = Lancamento::where('categoria_id', '=', $this->id)->getIndexedArray('conta_id','{conta->descricao}');
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
    
        $values = Lancamento::where('categoria_id', '=', $this->id)->getIndexedArray('status_lancamento_id','{status_lancamento->id}');
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
    
        $values = Lancamento::where('categoria_id', '=', $this->id)->getIndexedArray('system_users_id','{system_users->name}');
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
    
        $values = Lancamento::where('categoria_id', '=', $this->id)->getIndexedArray('tipo_lancamento_id','{tipo_lancamento->id}');
        return implode(', ', $values);
    }

  public static function getcategoriasPadrao(){
  
      $categorias = array(
                
                    ["Alimentação", TipoCategoria::DESPESA, TotalizaReceitaDespesa::SIM],
                    ["Educação", TipoCategoria::DESPESA, TotalizaReceitaDespesa::SIM],
                    ["Família", TipoCategoria::DESPESA, TotalizaReceitaDespesa::SIM],
                    ["Impostos", TipoCategoria::DESPESA, TotalizaReceitaDespesa::SIM],
                    ["Lazer", TipoCategoria::DESPESA, TotalizaReceitaDespesa::SIM],
                    ["Moradia", TipoCategoria::DESPESA, TotalizaReceitaDespesa::SIM],
                    ["Moveis e Ultencílios", TipoCategoria::DESPESA, TotalizaReceitaDespesa::SIM],
                    ["Presentes e doações", TipoCategoria::DESPESA, TotalizaReceitaDespesa::SIM],
                    ["Roupa", TipoCategoria::DESPESA, TotalizaReceitaDespesa::SIM],
                    ["Saúde", TipoCategoria::DESPESA, TotalizaReceitaDespesa::SIM],
                    ["Tarifas bancárias", TipoCategoria::DESPESA, TotalizaReceitaDespesa::SIM],
                    ["Transporte", TipoCategoria::DESPESA, TotalizaReceitaDespesa::SIM],
                    ["Salário", TipoCategoria::RECEITA, TotalizaReceitaDespesa::SIM],
                    ["Entrada por Transfêrencia", TipoCategoria::RECEITA, TotalizaReceitaDespesa::NAO],
                    ["Saida para Transfêrencia", TipoCategoria::DESPESA, TotalizaReceitaDespesa::NAO]
              
            );
        
            return $categorias;
  
  
  }
  
  
  
  
    
}

