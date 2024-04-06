<?php

class AtendimentoClienteForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'portal';
    private static $activeRecord = 'Atendimento';
    private static $primaryKey = 'id';
    private static $formName = 'form_AtendimentoClienteForm';

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
        $this->form->setFormTitle("Novo Atendimento");


        $id = new TEntry('id');
        $setor_id = new TDBCombo('setor_id', 'portal', 'Setor', 'id', '{nome}','nome asc'  );
        $tipo_atendimento_id = new TDBCombo('tipo_atendimento_id', 'portal', 'TipoAtendimento', 'id', '{nome}','nome asc'  );
        $mensagem = new TText('mensagem');
        $arquivos = new TMultiFile('arquivos');

        $setor_id->addValidation("Setor", new TRequiredValidator()); 
        $tipo_atendimento_id->addValidation("Tipo atendimento", new TRequiredValidator()); 

        $id->setEditable(false);
        $arquivos->enableFileHandling();
        $setor_id->enableSearch();
        $tipo_atendimento_id->enableSearch();

        $id->setSize(100);
        $setor_id->setSize('100%');
        $arquivos->setSize('100%');
        $mensagem->setSize('100%', 250);
        $tipo_atendimento_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id]);
        $row1->layout = ['col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Setor:", '#ff0000', '14px', null, '100%'),$setor_id],[new TLabel("Tipo atendimento:", '#ff0000', '14px', null, '100%'),$tipo_atendimento_id]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Mensagem:", null, '14px', null, '100%'),$mensagem]);
        $row3->layout = [' col-sm-12'];

        $row4 = $this->form->addFields([new TLabel("Arquivos:", null, '14px', null, '100%'),$arquivos]);
        $row4->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['AtendimentoClienteList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

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

            $object = new Atendimento(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $arquivos_dir = 'app/arquivos/atendimentos';  

            $object->cliente_id = TSession::getValue('cliente_id');
            $object->cliente_usuario_id = TSession::getValue('cliente_usuario_id');
            $object->data_abertura = date('Y-m-d H:i:s');

            $object->store(); // save the object 

            $this->saveFilesByComma($object, $data, 'arquivos', $arquivos_dir);
            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data

            $criteria = new TCriteria();
            $criteria->add(new TFilter('setor_id', '=', $object->setor_id));

            $emails = SetorAtendente::getIndexedArray('{atendente->system_user_id}', '{atendente->system_user->email}', $criteria);

            if($emails)
            {
                $templateEmail = TemplateEmailService::parseTemplate(TemplateEmail::NOVO_ATENDIMENTO, $object);
                FilaEmailService::adicionaNaFila($emails, $templateEmail->titulo, $templateEmail->conteudo, 'Novo Atendimento');

                foreach($emails as $system_user_id => $email)
                {
                    $notificationParam = [
                        'key' => $object->id // código do atendimento (id)
                    ];
                    $icon = 'fas fa-comments';

                    SystemNotification::register( $system_user_id, "Novo atendimento #{$object->id}", 'Há um novo atendimento aguardando', new TAction(['AtendimentoFormView', 'onShow'], $notificationParam), 'Visualizar Atendimento', $icon);    
                }
            }

            $this->form->setData($data); // fill form data

            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('AtendimentoClienteList', 'onShow', $loadPageParam); 

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

                $object = new Atendimento($key); // instantiates the Active Record 

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

