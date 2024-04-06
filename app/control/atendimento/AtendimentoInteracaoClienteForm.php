<?php

class AtendimentoInteracaoClienteForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'portal';
    private static $activeRecord = 'AtendimentoInteracao';
    private static $primaryKey = 'id';
    private static $formName = 'form_AtendimentoInteracaoClienteForm';

    use Adianti\Base\AdiantiFileSaveTrait;

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Nova interação do cliente");


        $id = new TEntry('id');
        $atendimento_id = new TEntry('atendimento_id');
        $mensagem = new TText('mensagem');
        $arquivos = new TMultiFile('arquivos');

        $atendimento_id->addValidation("Atendimento", new TRequiredValidator()); 

        $atendimento_id->setValue($param["atendimento_id"] ?? "");
        $arquivos->enableFileHandling();
        $id->setEditable(false);
        $atendimento_id->setEditable(false);

        $id->setSize(100);
        $arquivos->setSize('100%');
        $mensagem->setSize('100%', 250);
        $atendimento_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Código do atendimento:", '#ff0000', '14px', null, '100%'),$atendimento_id]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Mensagem:", null, '14px', null, '100%'),$mensagem]);
        $row2->layout = [' col-sm-12'];

        $row3 = $this->form->addFields([new TLabel("Arquivos:", null, '14px', null, '100%'),$arquivos]);
        $row3->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new AtendimentoInteracao(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $arquivos_dir = 'app/arquivos/atendimento/interacoes';  

            $object->cliente_usuario_id = TSession::getValue('cliente_usuario_id');
            $object->data_interacao = date('Y-m-d H:i:s');

            $object->store(); // save the object 

            $this->saveFilesByComma($object, $data, 'arquivos', $arquivos_dir); 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data

            $templateEmail = TemplateEmailService::parseTemplate(TemplateEmail::NOVA_INTERACAO_CLIENTE, $object);
            FilaEmailService::adicionaNaFila([$object->atendimento->atendente->system_user->email], $templateEmail->titulo, $templateEmail->conteudo, 'Nova Interação');

            $notificationParam = [
                'key' => $object->atendimento_id // código do atendimento (id)
            ];
            $icon = 'fas fa-comments';

            SystemNotification::register( $object->atendimento->atendente->system_user_id, "Nova interação #{$object->id}", "Há um nova interação no atendimento #{$object->atendimento_id}", new TAction(['AtendimentoFormView', 'onShow'], $notificationParam), 'Visualizar Atendimento', $icon);    

            TTransaction::close(); // close the transaction

            TelegramService::enviarMensagem("Há um nova interação no atendimento #{$object->atendimento_id}", $object->atendimento->atendente->system_user_id);

            new TMessage('info', "Registro salvo", $messageAction); 

            $pageParam = [
                'atendimento_id' => $object->atendimento_id,
                'target_container' => 'interacoes'
            ];

            TApplication::loadPage('AtendimentoInteracaoClienteTimeLine', 'onShow', $pageParam);

                        TScript::create("Template.closeRightPanel();"); 

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new AtendimentoInteracao($key); // instantiates the Active Record 

                                $object->arquivos = explode(',', $object->arquivos); 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

