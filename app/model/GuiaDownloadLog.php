<?php

class GuiaDownloadLog extends TRecord
{
    const TABLENAME  = 'guia_download_log';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATEDAT  = 'data_download';

    private $guia;
    private $downloaded_by_system_user;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('guia_id');
        parent::addAttribute('downloaded_by_system_user_id');
        parent::addAttribute('data_download');
            
    }

    /**
     * Method set_guia
     * Sample of usage: $var->guia = $object;
     * @param $object Instance of Guia
     */
    public function set_guia(Guia $object)
    {
        $this->guia = $object;
        $this->guia_id = $object->id;
    }

    /**
     * Method get_guia
     * Sample of usage: $var->guia->attribute;
     * @returns Guia instance
     */
    public function get_guia()
    {
    
        // loads the associated object
        if (empty($this->guia))
            $this->guia = new Guia($this->guia_id);
    
        // returns the associated object
        return $this->guia;
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

