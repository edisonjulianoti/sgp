<?php

class ProcessarRecebimentoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_ProcessarRecebimentoForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = null)
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Recebimento de Receita em Lote");

        $criteria_lancamentos = new TCriteria();

        $filterVar = TSession::getValue('ReceitaListbuilder_datagrid_check');
        $criteria_lancamentos->add(new TFilter('id', 'in', $filterVar)); 

        $data_pagamento = new TDate('data_pagamento');
        $lancamentos = new TCheckList('lancamentos');

        $data_pagamento->addValidation("Data de Pagamento", new TRequiredValidator()); 

        $data_pagamento->setSize('100%');
        $data_pagamento->setMask('dd/mm/yyyy');
        $data_pagamento->setDatabaseMask('yyyy-mm-dd');
        $data_pagamento->setValue(date('d/m/Y'));
        $lancamentos->setValue(TSession::getValue('ReceitaListbuilder_datagrid_check'));

        $lancamentos->setIdColumn('id');

        $column_lancamentos_id = $lancamentos->addColumn('id', "Id", 'center' , '14%');
        $column_lancamentos_conta_data_saldo_inicial_transformed = $lancamentos->addColumn('conta->data_saldo_inicial', "Data Inicial Conta", 'left' , '14%');
        $column_lancamentos_conta_saldo_atual_transformed = $lancamentos->addColumn('conta->saldo_atual', "Saldo Conta", 'left' , '14%');
        $column_lancamentos_conta_descricao = $lancamentos->addColumn('conta->descricao', "Conta", 'center' , '14%');
        $column_lancamentos_descricao = $lancamentos->addColumn('descricao', "Descrição", 'center' , '14%');
        $column_lancamentos_vencimento_transformed = $lancamentos->addColumn('vencimento', "Vencimento", 'center' , '14%');
        $column_lancamentos_valor_transformed = $lancamentos->addColumn('valor', "Valor", 'center' , '14%');

        $column_lancamentos_conta_data_saldo_inicial_transformed->setTransformer(function($value, $object, $row) 
        {
            if(!empty(trim($value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });

        $column_lancamentos_conta_saldo_atual_transformed->setTransformer(function($value, $object, $row) 
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });

        $column_lancamentos_vencimento_transformed->setTransformer(function($value, $object, $row) 
        {
            if(!empty(trim($value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });

        $column_lancamentos_valor_transformed->setTransformer(function($value, $object, $row) 
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });        

        $lancamentos->setHeight(410);
        $lancamentos->makeScrollable();

        $lancamentos->fillWith('bd_sgp', 'Lancamento', 'id', 'descricao asc' , $criteria_lancamentos);


        $row1 = $this->form->addFields([new TLabel("Data do Recebimento:", null, '14px', null, '100%'),$data_pagamento],[]);
        $row1->layout = [' col-sm-3','col-sm-6'];

        $row2 = $this->form->addFields([$lancamentos]);
        $row2->layout = [' col-sm-12'];

        // create the form actions
        $btn_onprocessar = $this->form->addAction("Processar", new TAction([$this, 'onProcessar']), 'fas:cogs #ffffff');
        $this->btn_onprocessar = $btn_onprocessar;
        $btn_onprocessar->addStyleClass('btn-primary'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=ProcessarRecebimentoForm]');
        $style->width = '95% !important';   
        $style->show(true);

    }

    public function onProcessar($param = null) 
    {
        try
        {
              $this->form->validate();
              $data = $this->form->getData();

              if($data->lancamentos){

                   TTransaction::open('bd_sgp');

                  foreach ($data->lancamentos as $key => $lancamento_id) {
                      // code...

                      $lancamento = new Lancamento($lancamento_id);
                      $lancamento->pagamento = $data->data_pagamento;

                      LancamentoService::validarDataPagamento($lancamento);

                      $retorno = TransacaoService::retornarSaldoDataInicialCalculo($lancamento);

                      $data_saldo =  $retorno['data_saldo'];
                      $saldo = $retorno['saldo'];

                      TransacaoService::processarTransacao($lancamento, $data_saldo, $saldo);

                  }

                  TTransaction::close();

                 TSession::setValue('ReceitaListbuilder_datagrid_check', null);

                 TToast::show("success", "Receitas Recebidas com sucesso!", "topRight", "fas:check-square");

                 AdiantiCoreApplication::loadPage('ReceitaList', 'onShow');

              }

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }

    public function onShow($param = null)
    {               

    } 

}

