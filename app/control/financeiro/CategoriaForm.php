<?php

class CategoriaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'bd_sgp';
    private static $activeRecord = 'Categoria';
    private static $primaryKey = 'id';
    private static $formName = 'form_CategoriaForm';

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
        $this->form->setFormTitle("Cadastro de categoria");


        $descricao = new TEntry('descricao');
        $id = new THidden('id');
        $tipo_categoria_id = new TDBRadioGroup('tipo_categoria_id', 'bd_sgp', 'TipoCategoria', 'id', '{descricao}','id asc'  );
        $totaliza_receita_despesa_id = new TDBRadioGroup('totaliza_receita_despesa_id', 'bd_sgp', 'TotalizaReceitaDespesa', 'id', '{descricao}','id asc'  );

        $descricao->addValidation("Descrição", new TRequiredValidator()); 
        $tipo_categoria_id->addValidation("Tipo", new TRequiredValidator()); 
        $totaliza_receita_despesa_id->addValidation("Totaliza", new TRequiredValidator()); 

        $descricao->setMaxLength(200);
        $tipo_categoria_id->setLayout('horizontal');
        $totaliza_receita_despesa_id->setLayout('horizontal');

        $tipo_categoria_id->setUseButton();
        $totaliza_receita_despesa_id->setUseButton();

        $tipo_categoria_id->setBreakItems(2);
        $totaliza_receita_despesa_id->setBreakItems(2);

        $id->setSize(200);
        $descricao->setSize('100%');
        $tipo_categoria_id->setSize('100%');
        $totaliza_receita_despesa_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Descrição:", '#607D8B', '14px', 'B', '100%'),$descricao,$id],[new TLabel("Tipo:", '#607D8B', '14px', 'B', '100%'),$tipo_categoria_id],[new TLabel("Totaliza:", '#607D8B', '14px', 'B', '100%'),$totaliza_receita_despesa_id]);
        $row1->layout = [' col-12 col-sm-12 col-lg-6 col-xl-6 col-md-12',' col-7 col-sm-7 col-lg-3 col-xl-3 col-md-7',' col-5 col-sm-5 col-lg-3 col-xl-3 col-md-5'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['CategoriaHeaderList', 'onShow']), 'fas:arrow-left #000000');
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

        $style = new TStyle('right-panel > .container-part[page-name=CategoriaForm]');
        $style->width = '90% !important';   
        $style->show(true);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Categoria(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->system_users_id = TSession::getValue('userid');

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
            TApplication::loadPage('CategoriaHeaderList', 'onShow', $loadPageParam); 

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

                $object = new Categoria($key); // instantiates the Active Record 

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

