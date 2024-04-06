<?php

class PlanoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'bd_sgp';
    private static $activeRecord = 'Plano';
    private static $primaryKey = 'id';
    private static $formName = 'form_PlanoForm';

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
        $this->form->setFormTitle("Cadastro de Plano");


        $titulo = new TEntry('titulo');
        $previsao = new TDate('previsao');
        $descricao = new THtmlEditor('descricao');
        $id = new THidden('id');
        $lista_tarefa = new BPageContainer();

        $previsao->addValidation("Previsão", new TRequiredValidator()); 
        $descricao->addValidation("Descrição", new TRequiredValidator()); 

        $titulo->setMaxLength(200);
        $previsao->setMask('dd/mm/yyyy');
        $previsao->setDatabaseMask('yyyy-mm-dd');
        $lista_tarefa->setAction(new TAction(['TarefaSimpleList', 'onShow'], $param));
        $lista_tarefa->setId('b634aed940f9c2');
        $lista_tarefa->hide();
        $id->setSize(200);
        $titulo->setSize('100%');
        $previsao->setSize('100%');
        $lista_tarefa->setSize('100%');
        $descricao->setSize('100%', 310);

        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $lista_tarefa->add($loadingContainer);

        $this->lista_tarefa = $lista_tarefa;

        $bcontainer_634af03747820 = new BootstrapFormBuilder('bcontainer_634af03747820');
        $this->bcontainer_634af03747820 = $bcontainer_634af03747820;
        $bcontainer_634af03747820->setProperty('style', 'border:none; box-shadow:none;');
        $row1 = $bcontainer_634af03747820->addFields([new TLabel("Titulo:", '#607D8B', '14px', 'B', '100%'),$titulo],[new TLabel("Previsão:", '#607D8B', '14px', 'B', '100%'),$previsao]);
        $row1->layout = [' col-sm-8',' col-sm-4'];

        $row2 = $bcontainer_634af03747820->addFields([new TLabel("Descrição:", '#607D8B', '14px', 'B', '100%'),$descricao,$id]);
        $row2->layout = [' col-sm-12'];

        $bcontainer_634af2214782c = new BootstrapFormBuilder('bcontainer_634af2214782c');
        $this->bcontainer_634af2214782c = $bcontainer_634af2214782c;
        $bcontainer_634af2214782c->setProperty('style', 'border:none; box-shadow:none;');
        $row3 = $bcontainer_634af2214782c->addFields([new TLabel(new TImage('fas:tasks #009688')."Tarefas:", '#009688', '16px', 'B', '100%'),$lista_tarefa]);
        $row3->layout = [' col-12 col-sm-12 col-lg-12 col-xl-12 col-md-12'];

        $row4 = $this->form->addFields([$bcontainer_634af03747820],[$bcontainer_634af2214782c]);
        $row4->layout = [' col-sm-8 col-lg-8 col-xl-8',' col-12 col-sm-12 col-lg-4 col-xl-4 col-md-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['PlanoList', 'onShow']), 'fas:arrow-left #000000');
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

        $style = new TStyle('right-panel > .container-part[page-name=PlanoForm]');
        $style->width = '95% !important';   
        $style->show(true);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Plano(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->system_users_id = TSession::getValue('userid');

            $data_previsao = $object->previsao;

            PlanoService::validarDataPrevisão($data_previsao);

            $object->store(); // save the object 

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('PlanoList', 'onShow', $loadPageParam); 

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

                $object = new Plano($key); // instantiates the Active Record 

                                $this->lista_tarefa->unhide();
                $this->lista_tarefa->setParameter('plano_id', $object->id);

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

