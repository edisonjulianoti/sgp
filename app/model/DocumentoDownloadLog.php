<?php

class DocumentoDownloadLog extends TRecord
{
    const TABLENAME  = 'documento_download_log';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATEDAT  = 'data_download';

    private $documento;
    private $downloaded_by_system_user;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('documento_id');
        parent::addAttribute('downloaded_by_system_user_id');
        parent::addAttribute('data_download');
            
    }

    /**
     * Method set_documento
     * Sample of usage: $var->documento = $object;
     * @param $object Instance of Documento
     */
    public function set_documento(Documento $object)
    {
        $this->documento = $object;
        $this->documento_id = $object->id;
    }

    /**
     * Method get_documento
     * Sample of usage: $var->documento->attribute;
     * @returns Documento instance
     */
    public function get_documento()
    {
    
        // loads the associated object
        if (empty($this->documento))
            $this->documento = new Documento($this->documento_id);
    
        // returns the associated object
        return $this->documento;
    }
    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_downloaded_by_system_user(SystemUsers $object)
    {
        $this->downloaded_by_system_user = $object;
        $this->downloaded_by_system_user_id = $object->id;
    }

    /**
     * Method get_downloaded_by_system_user
     * Sample of usage: $var->downloaded_by_system_user->attribute;
     * @returns SystemUsers instance
     */
    public function get_downloaded_by_system_user()
    {
        TTransaction::open('permission');
        // loads the associated object
        if (empty($this->downloaded_by_system_user))
            $this->downloaded_by_system_user = new SystemUsers($this->downloaded_by_system_user_id);
        TTransaction::close();
        // returns the associated object
        return $this->downloaded_by_system_user;
    }

    
}

