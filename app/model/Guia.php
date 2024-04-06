<?php

class Guia extends TRecord
{
    const TABLENAME  = 'guia';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $subcategoria_guia;
    private $cliente;
    private $created_by_system_user;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('subcategoria_guia_id');
        parent::addAttribute('cliente_id');
        parent::addAttribute('created_by_system_user_id');
        parent::addAttribute('ano_competencia');
        parent::addAttribute('mes_competencia');
        parent::addAttribute('data_vencimento');
        parent::addAttribute('download_pos_vencimento');
        parent::addAttribute('arquivo');
        parent::addAttribute('downloaded');
    
    }

    /**
     * Method set_subcategoria_guia
     * Sample of usage: $var->subcategoria_guia = $object;
     * @param $object Instance of SubcategoriaGuia
     */
    public function set_subcategoria_guia(SubcategoriaGuia $object)
    {
        $this->subcategoria_guia = $object;
        $this->subcategoria_guia_id = $object->id;
    }

    /**
     * Method get_subcategoria_guia
     * Sample of usage: $var->subcategoria_guia->attribute;
     * @returns SubcategoriaGuia instance
     */
    public function get_subcategoria_guia()
    {
    
        // loads the associated object
        if (empty($this->subcategoria_guia))
            $this->subcategoria_guia = new SubcategoriaGuia($this->subcategoria_guia_id);
    
        // returns the associated object
        return $this->subcategoria_guia;
    }
    /**
     * Method set_cliente
     * Sample of usage: $var->cliente = $object;
     * @param $object Instance of Cliente
     */
    public function set_cliente(Cliente $object)
    {
        $this->cliente = $object;
        $this->cliente_id = $object->id;
    }

    /**
     * Method get_cliente
     * Sample of usage: $var->cliente->attribute;
     * @returns Cliente instance
     */
    public function get_cliente()
    {
    
        // loads the associated object
        if (empty($this->cliente))
            $this->cliente = new Cliente($this->cliente_id);
    
        // returns the associated object
        return $this->cliente;
    }
    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_created_by_system_user(SystemUsers $object)
    {
        $this->created_by_system_user = $object;
        $this->created_by_system_user_id = $object->id;
    }

    /**
     * Method get_created_by_system_user
     * Sample of usage: $var->created_by_system_user->attribute;
     * @returns SystemUsers instance
     */
    public function get_created_by_system_user()
    {
        TTransaction::open('permission');
        // loads the associated object
        if (empty($this->created_by_system_user))
            $this->created_by_system_user = new SystemUsers($this->created_by_system_user_id);
        TTransaction::close();
        // returns the associated object
        return $this->created_by_system_user;
    }

    /**
     * Method getGuiaDownloadLogs
     */
    public function getGuiaDownloadLogs()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('guia_id', '=', $this->id));
        return GuiaDownloadLog::getObjects( $criteria );
    }

    public function set_guia_download_log_guia_to_string($guia_download_log_guia_to_string)
    {
        if(is_array($guia_download_log_guia_to_string))
        {
            $values = Guia::where('id', 'in', $guia_download_log_guia_to_string)->getIndexedArray('id', 'id');
            $this->guia_download_log_guia_to_string = implode(', ', $values);
        }
        else
        {
            $this->guia_download_log_guia_to_string = $guia_download_log_guia_to_string;
        }

        $this->vdata['guia_download_log_guia_to_string'] = $this->guia_download_log_guia_to_string;
    }

    public function get_guia_download_log_guia_to_string()
    {
        if(!empty($this->guia_download_log_guia_to_string))
        {
            return $this->guia_download_log_guia_to_string;
        }
    
        $values = GuiaDownloadLog::where('guia_id', '=', $this->id)->getIndexedArray('guia_id','{guia->id}');
        return implode(', ', $values);
    }

    public function get_competencia_vencimento()
    {
        $vencimento = TDate::date2br($this->data_vencimento);
        $meses = TempoService::getMeses();
    
        $mes_competencia = $meses[$this->mes_competencia];
    
        return "<b>Competência:</b> {$mes_competencia}/{$this->ano_competencia}<br><b>Vencimento: </b>{$vencimento}";
    }

    public function get_competencia()
    {
        $meses = TempoService::getMeses();
    
        $mes_competencia = $meses[$this->mes_competencia];
    
        return "{$mes_competencia}/{$this->ano_competencia}";
    }

    public function get_data_vencimento_br()
    {
        return TDate::date2br($this->data_vencimento);
    }

    
}

