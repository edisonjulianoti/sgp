<?php

class DespesaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'bd_sgp';
    private static $activeRecord = 'Lancamento';
    private static $primaryKey = 'id';
    private static $formName = 'form_DespesaForm';

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
        $this->form->setFormTitle("Cadastro de Despesa");

        $criteria_categoria_id = new TCriteria();
        $criteria_conta_id = new TCriteria();

        $filterVar = TSession::getValue("userid");
        $criteria_categoria_id->add(new TFilter('system_users_id', '=', $filterVar)); 
        $filterVar = TipoCategoria::DESPESA;
        $criteria_categoria_id->add(new TFilter('tipo_categoria_id', '=', $filterVar)); 
        $filterVar = TSession::getValue("userid");
        $criteria_conta_id->add(new TFilter('system_users_id', '=', $filterVar)); 

        $descricao = new TEntry('descricao');
        $id = new THidden('id');
        $vencimento = new TDate('vencimento');
        $valor = new TNumeric('valor', '2', ',', '.' );
        $pagamento = new TDate('pagamento');
        $categoria_id = new TDBCombo('categoria_id', 'bd_sgp', 'Categoria', 'id', '{descricao}','descricao asc' , $criteria_categoria_id );
        $conta_id = new TDBCombo('conta_id', 'bd_sgp', 'Conta', 'id', '{descricao}','descricao asc' , $criteria_conta_id );
        $status_lancamento_id = new TDBCombo('status_lancamento_id', 'bd_sgp', 'StatusLancamento', 'id', '{descricao}','id asc'  );

        $status_lancamento_id->setChangeAction(new TAction([$this,'onChangeValueStatus']));

        $descricao->addValidation("Descrição", new TRequiredValidator()); 
        $vencimento->addValidation("Vencimento", new TRequiredValidator()); 
        $valor->addValidation("Valor", new TRequiredValidator()); 
        $categoria_id->addValidation("Categoria", new TRequiredValidator()); 
        $conta_id->addValidation("Conta", new TRequiredValidator()); 
        $status_lancamento_id->addValidation("Status", new TRequiredValidator()); 

        $descricao->setMaxLength(200);
        $status_lancamento_id->setValue(StatusLancamento::ABERTO);
        $pagamento->setMask('dd/mm/yyyy');
        $vencimento->setMask('dd/mm/yyyy');

        $pagamento->setDatabaseMask('yyyy-mm-dd');
        $vencimento->setDatabaseMask('yyyy-mm-dd');

        $conta_id->enableSearch();
        $categoria_id->enableSearch();
        $status_lancamento_id->enableSearch();

        $id->setSize(200);
        $valor->setSize('100%');
        $conta_id->setSize('100%');
        $descricao->setSize('100%');
        $pagamento->setSize('100%');
        $vencimento->setSize('100%');
        $categoria_id->setSize('100%');
        $status_lancamento_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Descrição:", '#607D8B', '14px', 'B', '100%'),$descricao,$id],[new TLabel("Vencimento:", '#607D8B', '14px', 'B', '100%'),$vencimento],[new TLabel("Valor:", '#607D8B', '14px', 'B', '100%'),$valor],[new TLabel("Pagamento:", '#607D8B', '14px', 'B'),$pagamento]);
        $row1->layout = ['col-12 col-sm-12 col-lg-4 col-xl-4 col-md-12',' col-12 col-sm-12 col-lg-2 col-xl-2 col-md-12',' col-12 col-sm-12 col-lg-2 col-xl-2 col-md-12','col-sm-2'];

        $row2 = $this->form->addFields([new TLabel("Categoria:", '#607D8B', '14px', 'B', '100%'),$categoria_id],[new TLabel("Conta:", '#607D8B', '14px', 'B', '100%'),$conta_id],[new TLabel("Status:", '#607D8B', '14px', 'B', '100%'),$status_lancamento_id]);
        $row2->layout = [' col-12 col-sm-12 col-lg-4 col-xl-4 col-md-12',' col-12 col-sm-12 col-lg-3 col-xl-3 col-md-12',' col-12 col-sm-12 col-lg-3 col-xl-3 col-md-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['DespesaList', 'onShow']), 'fas:arrow-left #000000');
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

        $style = new TStyle('right-panel > .container-part[page-name=DespesaForm]');
        $style->width = '95% !important';   
        $style->show(true);

    }

    public static function onChangeValueStatus($param = null) 
    {
        try 
        {
            //code here
            if($param['status_lancamento_id'] == StatusLancamento::PAGO){
                // Código gerado pelo snippet: "Exibir mensagem"
                new TMessage('info', "A gravação do registro com status PAGO, processará a transação e não permitirá mais alteração desse(s) lançamento(s)!", null,"Atenção");

            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Lancamento(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->system_users_id        = TSession::getValue('userid');
            $object->tipo_lancamento_id     = TipoLancamento::DESPESA;

            $object->store(); // save the object 

            // se o registro for gravado como pago gera a transação
            if($object->status_lancamento_id == StatusLancamento::PAGO){

                if(empty($object->pagamento)){
                    throw new Exception("Para gravar despesa com status pago é necessário informar a data de pagamento.");
                }

                LancamentoService::validarDataPagamento($object);

                $retorno = TransacaoService::retornarSaldoDataInicialCalculo($object);

                $data_saldo =  $retorno['data_saldo'];
                $saldo = $retorno['saldo'];

                TransacaoService::processarTransacao($object, $data_saldo, $saldo);

                TSession::setValue('DespesaListbuilder_datagrid_check', null);

            }

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
            TApplication::loadPage('DespesaList', 'onShow', $loadPageParam); 

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

                $object = new Lancamento($key); // instantiates the Active Record 

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

