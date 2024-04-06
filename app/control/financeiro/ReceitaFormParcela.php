<?php

class ReceitaFormParcela extends TPage
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
        $this->form->setFormTitle("Cadastro de Parcelas (Receitas)");

        $criteria_categoria_id = new TCriteria();
        $criteria_conta_id = new TCriteria();

        $filterVar = TSession::getValue("userid");
        $criteria_categoria_id->add(new TFilter('system_users_id', '=', $filterVar)); 
        $filterVar = TipoCategoria::RECEITA;
        $criteria_categoria_id->add(new TFilter('tipo_categoria_id', '=', $filterVar)); 
        $filterVar = TSession::getValue("userid");
        $criteria_conta_id->add(new TFilter('system_users_id', '=', $filterVar)); 

        $valor = new TNumeric('valor', '2', ',', '.' );
        $quantidade_parcela = new TSpinner('quantidade_parcela');
        $total_pagar = new TNumeric('total_pagar', '2', ',', '.' );
        $button_ = new TButton('button_');
        $descricao = new TEntry('descricao');
        $id = new THidden('id');
        $vencimento = new TDate('vencimento');
        $categoria_id = new TDBCombo('categoria_id', 'bd_sgp', 'Categoria', 'id', '{descricao}','descricao asc' , $criteria_categoria_id );
        $conta_id = new TDBCombo('conta_id', 'bd_sgp', 'Conta', 'id', '{descricao}','descricao asc' , $criteria_conta_id );

        $valor->addValidation("Valor", new TRequiredValidator()); 
        $quantidade_parcela->addValidation("Quantidade de Parcela", new TRequiredValidator()); 
        $descricao->addValidation("Descrição", new TRequiredValidator()); 
        $vencimento->addValidation("Vencimento", new TRequiredValidator()); 
        $categoria_id->addValidation("Categoria", new TRequiredValidator()); 
        $conta_id->addValidation("Conta", new TRequiredValidator()); 

        $valor->setAllowNegative(false);
        $quantidade_parcela->setRange(2, 2000, 1);
        $total_pagar->setEditable(false);
        $button_->setAction(new TAction([$this, 'calcularParcelas']), "");
        $button_->addStyleClass('btn-default');
        $button_->setImage('fas:calculator #673AB7');
        $descricao->setMaxLength(200);
        $vencimento->setMask('dd/mm/yyyy');
        $vencimento->setDatabaseMask('yyyy-mm-dd');
        $quantidade_parcela->setValue('0');
        $vencimento->setValue(date('d/m/Y'));

        $conta_id->enableSearch();
        $categoria_id->enableSearch();

        $id->setSize(200);
        $valor->setSize('100%');
        $conta_id->setSize('100%');
        $descricao->setSize('100%');
        $total_pagar->setSize('60%');
        $vencimento->setSize('100%');
        $categoria_id->setSize('100%');
        $quantidade_parcela->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Valor:", '#607D8B', '14px', 'B', '100%'),$valor],[new TLabel("Qtd Parcelas:", null, '14px', null),$quantidade_parcela],[new TLabel("Total a Pagar:", null, '14px', null, '100%'),$total_pagar,$button_]);
        $row1->layout = [' col-12 col-sm-12 col-lg-2 col-xl-2 col-md-12',' col-12 col-sm-12 col-lg-2 col-xl-2 col-md-12','col-12 col-sm-12 col-lg-3 col-xl-3 col-md-12'];

        $row2 = $this->form->addFields([new TLabel("Descrição:", '#607D8B', '14px', 'B', '100%'),$descricao,$id],[new TLabel("Vencimento:", '#607D8B', '14px', 'B', '100%'),$vencimento]);
        $row2->layout = [' col-12 col-sm-12 col-lg-4 col-xl-4 col-md-12  esconder_campo',' col-12 col-sm-12 col-lg-3 col-xl-3 col-md-12  esconder_campo'];

        $row3 = $this->form->addFields([new TLabel("Categoria:", '#607D8B', '14px', 'B', '100%'),$categoria_id],[new TLabel("Conta:", '#607D8B', '14px', 'B', '100%'),$conta_id]);
        $row3->layout = [' col-12 col-sm-12 col-lg-4 col-xl-4 col-md-12  esconder_campo',' col-12 col-sm-12 col-lg-3 col-xl-3 col-md-12  esconder_campo'];

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

        $style = new TStyle('right-panel > .container-part[page-name=ReceitaFormParcela]');
        $style->width = '95% !important';   
        $style->show(true);

    }

    public  function calcularParcelas($param = null) 
    {
        try 
        {
            //code here

            $data = $this->form->getData();

            if(empty($data->valor)){

                new TMessage('error', 'Valor é obrigatórios!', null, "Campo obrigatório");
                TScript::create("$('.esconder_campo').hide();");
                TScript::create("$('#tbutton_btn_salvar').hide();");

            }else{

                TScript::create("$('.esconder_campo').show();");
                TScript::create("$('#tbutton_btn_salvar').show();");

                // Código gerado pelo snippet: "Cálculos com campos"

                $valor = (double) str_replace(',', '.', str_replace('.', '', $param['valor']));
                $parcelas = (double) str_replace(',', '.', str_replace('.', '', $param['quantidade_parcela']));

                $total_pagar = $valor * $parcelas ;

                $data->total_pagar = number_format($total_pagar, 2, ',', '.');

                $this->form->setData( $data );

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
            $object->tipo_lancamento_id     = TipoLancamento::RECEITA;

            $object->descricao = $object->descricao . " - (Parcela 1)";

            $object->status_lancamento_id = StatusLancamento::ABERTO;

            $object->store(); // save the object 

            LancamentoService::gerarParcelas($object, $data);

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
            TApplication::loadPage('ReceitaList', 'onShow', $loadPageParam); 

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

        TScript::create("$('.esconder_campo').hide();");

        TScript::create("$('#tbutton_btn_salvar').hide();");

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

