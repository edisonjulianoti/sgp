<?php

class ClienteConfigForm extends TWindow
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_ClienteConfigForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = null)
    {
        parent::__construct();
        parent::setSize(0.8, null);
        parent::setTitle("Configurações do cliente");
        parent::setProperty('class', 'window_modal');

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Configurações do cliente");


        $link_telegram = new BElement('a');


        $link_telegram->setSize('100%', 80);

        $link_telegram->class = !empty($link_telegram->class) ? $link_telegram->class.' btn btn-link ' : ' btn btn-link ';

        $this->link_telegram = $link_telegram;

        // aqui vamos adicionar a URL no link....

        $link = TelegramService::getBotLink();

        $link_telegram->target = '_blank';
        $link_telegram->href = $link;
        $link_telegram->add($link);

        $row1 = $this->form->addFields([new TLabel("Clique no link a seguir para habilitar as notificações de Telegram:", null, '14px', null, '100%'),$link_telegram]);
        $row1->layout = [' col-sm-12'];

        // create the form actions


        parent::add($this->form);

    }

    public function onShow($param = null)
    {               

    } 

}

