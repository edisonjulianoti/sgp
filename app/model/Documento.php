<?php

class Documento extends TRecord
{
    const TABLENAME  = 'documento';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $cliente;
    private $tipo_documento;
    private $created_by_system_user;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cliente_id');
        parent::addAttribute('tipo_documento_id');
        parent::addAttribute('created_by_system_user_id');
        parent::addAttribute('vaildade');
        parent::addAttribute('arquivo');
        parent::addAttribute('observacao');
            
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
     * Method set_tipo_documento
     * Sample of usage: $var->tipo_documento = $object;
     * @param $object Instance of TipoDocumento
     */
    public function set_tipo_documento(TipoDocumento $object)
    {
        $this->tipo_documento = $object;
        $this->tipo_documento_id = $object->id;
    }

    /**
     * Method get_tipo_documento
     * Sample of usage: $var->tipo_documento->attribute;
     * @returns TipoDocumento instance
     */
    public function get_tipo_documento()
    {
    
        // loads the associated object
        if (empty($this->tipo_documento))
            $this->tipo_documento = new TipoDocumento($this->tipo_documento_id);
    
        // returns the associated object
        return $this->tipo_documento;
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
     * Method getDocumentoDownloadLogs
     */
    public function getDocumentoDownloadLogs()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('documento_id', '=', $this->id));
        return DocumentoDownloadLog::getObjects( $criteria );
    }

    public function set_documento_download_log_documento_to_string($documento_download_log_documento_to_string)
    {
        if(is_array($documento_download_log_documento_to_string))
        {
            $values = Documento::where('id', 'in', $documento_download_log_documento_to_string)->getIndexedArray('id', 'id');
            $this->documento_download_log_documento_to_string = implode(', ', $values);
        }
        else
        {
            $this->documento_download_log_documento_to_string = $documento_download_log_documento_to_string;
        }

        $this->vdata['documento_download_log_documento_to_string'] = $this->documento_download_log_documento_to_string;
    }

    public function get_documento_download_log_documento_to_string()
    {
        if(!empty($this->documento_download_log_documento_to_string))
        {
            return $this->documento_download_log_documento_to_string;
        }
    
        $values = DocumentoDownloadLog::where('documento_id', '=', $this->id)->getIndexedArray('documento_id','{documento->id}');
        return implode(', ', $values);
    }

    
}

