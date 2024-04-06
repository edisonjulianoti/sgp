<?php

class ContaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'bd_sgp';
    private static $activeRecord = 'Conta';
    private static $primaryKey = 'id';
    private static $formName = 'form_ContaForm';

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
        $this->form->setFormTitle("Cadastro de conta");


        $tipo_conta_id = new TDBCombo('tipo_conta_id', 'bd_sgp', 'TipoConta', 'id', '{descricao}','descricao asc'  );
        $id = new THidden('id');
        $descricao = new TEntry('descricao');
        $saldo_calculado_id = new THidden('saldo_calculado_id');
        $banco = new TEntry('banco');
        $data_saldo_inicial = new TDate('data_saldo_inicial');
        $saldo_inicial = new TNumeric('saldo_inicial', '2', ',', '.' );

        $tipo_conta_id->addValidation("Tipo conta id", new TRequiredValidator()); 
        $descricao->addValidation("Descrição", new TRequiredValidator()); 
        $data_saldo_inicial->addValidation("Data saldo inicial", new TRequiredValidator()); 
        $saldo_inicial->addValidation("Saldo Inicial", new TRequiredValidator()); 

        $tipo_conta_id->enableSearch();
        $saldo_calculado_id->setValue(SaldoCalculado::NAO);
        $data_saldo_inicial->setMask('dd/mm/yyyy');
        $data_saldo_inicial->setDatabaseMask('yyyy-mm-dd');
        $banco->setMaxLength(200);
        $descricao->setMaxLength(200);

        $id->setSize(200);
        $banco->setSize('100%');
        $descricao->setSize('100%');
        $tipo_conta_id->setSize('100%');
        $saldo_inicial->setSize('100%');
        $saldo_calculado_id->setSize(200);
        $data_saldo_inicial->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Tipo de  Conta:", '#607D8B', '14px', 'B', '100%'),$tipo_conta_id,$id],[new TLabel("Descrição:", '#607D8B', '14px', 'B', '100%'),$descricao,$saldo_calculado_id],[new TLabel("Banco:", '#607D8B', '14px', 'B', '100%'),$banco],[new TLabel("Data saldo inicial:", '#607D8B', '14px', 'B', '100%'),$data_saldo_inicial],[new TLabel("Saldo Inicial:", '#607D8B', '14px', 'B', '100%'),$saldo_inicial]);
        $row1->layout = [' col-12 col-sm-12 col-lg-2 col-xl-2 col-md-12',' col-12 col-sm-12 col-lg-4 col-xl-4 col-md-12',' col-12 col-sm-12 col-lg-2 col-xl-2 col-md-12',' col-12 col-sm-12 col-lg-2 col-xl-2 col-md-12',' col-12 col-sm-12 col-lg-2 col-xl-2 col-md-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['ContaHeaderList', 'onShow']), 'fas:arrow-left #000000');
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

        $style = new TStyle('right-panel > .container-part[page-name=ContaForm]');
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

            $object = new Conta(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            // Preenchendo is do usuario da sessão
            $object->system_users_id = TSession::getValue('userid');

            /*  
            	Se não existir calculo de saldo para a conta, 
            	então o saldo atual da conta recebe o saldo inicial informado na tela.
            	Caso contrario os campos não serão mais editaveis. (Tratamento no onEdit)

            */

            if($object->saldo_calculado_id != SaldoCalculado::SIM){
            	$object->saldo_atual = $object->saldo_inicial;    
            }

            // a partir daqui tratativas na data do saldo

            $data_saldo_inicial = $object->data_saldo_inicial;

            $hoje = date('Y-m-d');

            $intervalo = DateService::retornaIntervaloEntreData($hoje, $data_saldo_inicial);

            // Verificando se a data informada está no futuro
            if($intervalo->invert == 0 && $intervalo->days > 0){

            	$obj = new stdclass;
            	$obj->data_saldo_inicial = "";
            	TForm::sendData(self::$formName, $obj);

            	throw new Exception("Data do saldo inicial não pode ser no futuro!");
            }

            // Verificando se a data informada é anterior a 30 dias da data atual.
            if($intervalo->invert == 1 && $intervalo->days > 30){

            	$obj = new stdclass;
            	$obj->data_saldo_inicial = "";
            	TForm::sendData(self::$formName, $obj);

            	throw new Exception("Data do saldo inicial não pode ser anterior a 30 dias da data atual!");
            }

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
            TApplication::loadPage('ContaHeaderList', 'onShow', $loadPageParam); 

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

                $object = new Conta($key); // instantiates the Active Record 

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

