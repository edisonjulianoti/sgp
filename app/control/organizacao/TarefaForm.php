<?php

class TarefaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'bd_sgp';
    private static $activeRecord = 'Tarefa';
    private static $primaryKey = 'id';
    private static $formName = 'form_TarefaForm';

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
        $this->form->setFormTitle("Cadastro de Tarefa");

        $criteria_plano_id = new TCriteria();

        $filterVar = TSession::getValue("userid");
        $criteria_plano_id->add(new TFilter('system_users_id', '=', $filterVar)); 

        $descricao = new TEntry('descricao');
        $relevancia_id = new TDBCombo('relevancia_id', 'bd_sgp', 'Relevancia', 'id', '{descricao}','descricao asc'  );
        $tipo_id = new TDBCombo('tipo_id', 'bd_sgp', 'Tipo', 'id', '{descricao}','id asc'  );
        $plano_id = new TDBCombo('plano_id', 'bd_sgp', 'Plano', 'id', '{descricao}','descricao asc' , $criteria_plano_id );
        $conclusao = new TDate('conclusao');
        $detalhe = new TText('detalhe');
        $id = new THidden('id');

        $descricao->addValidation("Descrição", new TRequiredValidator()); 
        $relevancia_id->addValidation("Relevância", new TRequiredValidator()); 
        $tipo_id->addValidation("Tipo", new TRequiredValidator()); 

        $descricao->setMaxLength(200);
        $conclusao->setMask('dd/mm/yyyy');
        $conclusao->setDatabaseMask('yyyy-mm-dd');
        $tipo_id->enableSearch();
        $plano_id->enableSearch();
        $relevancia_id->enableSearch();

        $id->setSize(200);
        $tipo_id->setSize('100%');
        $plano_id->setSize('100%');
        $descricao->setSize('100%');
        $conclusao->setSize('100%');
        $detalhe->setSize('100%', 70);
        $relevancia_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Descrição:", '#607D8B', '14px', 'B', '100%'),$descricao],[new TLabel("Relevância:", '#607D8B', '14px', 'B', '100%'),$relevancia_id],[new TLabel("Tipo:", '#607D8B', '14px', 'B', '100%'),$tipo_id],[new TLabel("Plano:", '#607D8B', '14px', 'B', '100%'),$plano_id],[new TLabel("Conclusão:", '#607D8B', '14px', 'B', '100%'),$conclusao]);
        $row1->layout = [' col-sm-4','col-sm-2','col-sm-2','col-sm-2','col-sm-2'];

        $row2 = $this->form->addFields([new TLabel("Detalhe:", '#607D8B', '14px', 'B', '100%'),$detalhe,$id]);
        $row2->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onactionvoltar = $this->form->addAction("Voltar", new TAction([$this, 'onActionVoltar']), 'fas:arrow-left #000000');
        $this->btn_onactionvoltar = $btn_onactionvoltar;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=TarefaForm]');
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

            $object = new Tarefa(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->system_users_id = TSession::getValue('userid');

            $data_conclusao = $object->conclusao;

            TarefaService::validarDataConclusao($data_conclusao);

            if(empty($object->id)){

                $object->status_tarefa_id = StatusTarefa::PENDENTE;
            }

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle'); 

            $valor = TSession::getValue('origem_registro_tarefa');

            if($valor == 'kanban'){

                $pageParam = []; // ex.: = ['key' => 10]
                TApplication::loadPage('KanbanForm', 'onShow', $pageParam);

            }elseif ($valor == 'listagem') {

                $pageParam = []; // ex.: = ['key' => 10]
                TApplication::loadPage('TarefaList', 'onShow', $pageParam);
            }

            TSession::setValue('origem_registro_tarefa',null);

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
    public function onActionVoltar($param = null) 
    {
        try 
        {
            //code here
            $valor = TSession::getValue('origem_registro_tarefa');

            if($valor == 'kanban'){

                $pageParam = []; // ex.: = ['key' => 10]
                TApplication::loadPage('KanbanForm', 'onShow', $pageParam);

            }elseif ($valor == 'listagem') {

                $pageParam = []; // ex.: = ['key' => 10]
                TApplication::loadPage('TarefaList', 'onShow', $pageParam);
            }

            TSession::setValue('origem_registro_tarefa',null);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {

                TSession::setValue('origem_registro_tarefa',$param['origem_registro_tarefa']);

                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Tarefa($key); // instantiates the Active Record 

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

        TSession::setValue('origem_registro_tarefa',$param['origem_registro_tarefa']);

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

