<?php

class ReceitaList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'bd_sgp';
    private static $activeRecord = 'Lancamento';
    private static $primaryKey = 'id';
    private static $formName = 'form_DespesaList';
    private $showMethods = ['onReload', 'onSearch', 'onRefresh', 'onClearFilters'];
    private $limit = 20;

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param = null)
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Listagem de Receitas");
        $this->limit = 20;

        $criteria_categoria_id = new TCriteria();
        $criteria_conta_id = new TCriteria();

        $filterVar = TSession::getValue("userid");
        $criteria_categoria_id->add(new TFilter('system_users_id', '=', $filterVar)); 
        $filterVar = TipoCategoria::RECEITA;
        $criteria_categoria_id->add(new TFilter('tipo_categoria_id', '=', $filterVar)); 
        $filterVar = TSession::getValue("userid");
        $criteria_conta_id->add(new TFilter('system_users_id', '=', $filterVar)); 

        $descricao = new TEntry('descricao');
        $vencimento = new TDate('vencimento');
        $vencimento_final = new TDate('vencimento_final');
        $categoria_id = new TDBCombo('categoria_id', 'bd_sgp', 'Categoria', 'id', '{descricao}','descricao asc' , $criteria_categoria_id );
        $conta_id = new TDBCombo('conta_id', 'bd_sgp', 'Conta', 'id', '{descricao}','descricao asc' , $criteria_conta_id );
        $status_lancamento_id = new TDBCombo('status_lancamento_id', 'bd_sgp', 'StatusLancamento', 'id', '{descricao}','id asc'  );


        $descricao->setMaxLength(200);
        $vencimento->setMask('dd/mm/yyyy');
        $vencimento_final->setMask('dd/mm/yyyy');

        $vencimento->setDatabaseMask('yyyy-mm-dd');
        $vencimento_final->setDatabaseMask('yyyy-mm-dd');

        $conta_id->enableSearch();
        $categoria_id->enableSearch();
        $status_lancamento_id->enableSearch();

        $conta_id->setSize('100%');
        $descricao->setSize('100%');
        $vencimento->setSize('43%');
        $categoria_id->setSize('100%');
        $vencimento_final->setSize('43%');
        $status_lancamento_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Descrição:", null, '14px', null, '100%'),$descricao],[new TLabel("Vencimento:", null, '14px', null, '100%'),$vencimento,new TLabel("Até", null, '14px', null),$vencimento_final],[new TLabel("Categoria:", null, '14px', null),$categoria_id]);
        $row1->layout = [' col-12 col-sm-12 col-lg-4 col-xl-4 col-md-12',' col-12 col-sm-12 col-lg-4 col-xl-4 col-md-12',' col-12 col-sm-12 col-lg-4 col-xl-4 col-md-12'];

        $row2 = $this->form->addFields([new TLabel("Conta:", null, '14px', null, '100%'),$conta_id],[new TLabel("Status:", null, '14px', null, '100%'),$status_lancamento_id]);
        $row2->layout = [' col-12 col-sm-12 col-lg-6 col-xl-6 col-md-12',' col-12 col-sm-12 col-lg-6 col-xl-6 col-md-12'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $this->btn_onsearch = $btn_onsearch;
        $btn_onsearch->addStyleClass('btn-primary'); 

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid->setActionSide('right');
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $filterVar = TSession::getValue("userid");
        $this->filter_criteria->add(new TFilter('system_users_id', '=', $filterVar));
        $filterVar = TipoLancamento::RECEITA;
        $this->filter_criteria->add(new TFilter('tipo_lancamento_id', '=', $filterVar));

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_status_lancamento_descricao_transformed = new TDataGridColumn('status_lancamento->descricao', "Status", 'left');
        $column_vencimento_transformed = new TDataGridColumn('vencimento', "Vencimento", 'left');
        $column_pagamento_transformed = new TDataGridColumn('pagamento', "Recebimento", 'left');
        $column_descricao = new TDataGridColumn('descricao', "Descrição", 'left');
        $column_categoria_descricao = new TDataGridColumn('categoria->descricao', "Categoria", 'left');
        $column_conta_descricao = new TDataGridColumn('conta->descricao', "Conta", 'left');
        $column_valor_transformed = new TDataGridColumn('valor', "Valor", 'left');

        $column_categoria_descricao->enableAutoHide('800');
        $column_conta_descricao->enableAutoHide('800');

        $column_valor_transformed->setTotalFunction( function($values) { 
            return array_sum((array) $values); 
        }); 

        $column_status_lancamento_descricao_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here

            if($object->status_lancamento_id == StatusLancamento::ABERTO){

                return "<span class='badge badge-danger'>{$value}</span>";
            }

            if($object->status_lancamento_id == StatusLancamento::PAGO){

                return "<span class='badge badge-success'>{$value}</span>";
            }

        });

        $column_vencimento_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_pagamento_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_valor_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $this->builder_datagrid_check_all = new TCheckButton('builder_datagrid_check_all');
        $this->builder_datagrid_check_all->setIndexValue('on');
        $this->builder_datagrid_check_all->onclick = "Builder.checkAll(this)";
        $this->builder_datagrid_check_all->style = 'cursor:pointer';
        $this->builder_datagrid_check_all->setProperty('class', 'filled-in');
        $this->builder_datagrid_check_all->id = 'builder_datagrid_check_all';

        $label = new TLabel('');
        $label->style = 'margin:0';
        $label->class = 'checklist-label';
        $this->builder_datagrid_check_all->after($label);
        $label->for = 'builder_datagrid_check_all';

        $this->builder_datagrid_check = $this->datagrid->addColumn( new TDataGridColumn('builder_datagrid_check', $this->builder_datagrid_check_all, 'center',  '1%') );

        $this->datagrid->addColumn($column_status_lancamento_descricao_transformed);
        $this->datagrid->addColumn($column_vencimento_transformed);
        $this->datagrid->addColumn($column_pagamento_transformed);
        $this->datagrid->addColumn($column_descricao);
        $this->datagrid->addColumn($column_categoria_descricao);
        $this->datagrid->addColumn($column_conta_descricao);
        $this->datagrid->addColumn($column_valor_transformed);

        $action_onEdit = new TDataGridAction(array('ReceitaForm', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);
        $action_onEdit->setDisplayCondition('ReceitaList::onExibeEditar');

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('ReceitaList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fas:trash-alt #dd5a43');
        $action_onDelete->setField(self::$primaryKey);
        $action_onDelete->setDisplayCondition('ReceitaList::onExibeDeletar');

        $this->datagrid->addAction($action_onDelete);

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup("Listagem de receitas");
        $panel->datagrid = 'datagrid-container';
        $this->datagridPanel = $panel;
        $this->datagrid_form->add($this->datagrid);
        $panel->add($this->datagrid_form);

        $panel->getBody()->class .= ' table-responsive';

        $panel->addFooter($this->pageNavigation);

        $headerActions = new TElement('div');
        $headerActions->class = ' datagrid-header-actions ';
        $headerActions->style = 'justify-content: space-between;';

        $head_left_actions = new TElement('div');
        $head_left_actions->class = ' datagrid-header-actions-left-actions ';

        $head_right_actions = new TElement('div');
        $head_right_actions->class = ' datagrid-header-actions-left-actions ';

        $headerActions->add($head_left_actions);
        $headerActions->add($head_right_actions);

        $panel->getBody()->insert(0, $headerActions);

        $button_receita = new TButton('button_button_receita');
        $button_receita->setAction(new TAction(['ReceitaForm', 'onShow']), "Receita");
        $button_receita->addStyleClass('btn-default');
        $button_receita->setImage('fas:plus #69aa46');

        $this->datagrid_form->addField($button_receita);

        $button_receber_em_lote = new TButton('button_button_receber_em_lote');
        $button_receber_em_lote->setAction(new TAction(['ReceitaList', 'onPagarAll']), "Receber em Lote");
        $button_receber_em_lote->addStyleClass('btn-default');
        $button_receber_em_lote->setImage('fas:money-bill-alt #4CAF50');

        $this->datagrid_form->addField($button_receber_em_lote);

        $btnShowCurtainFilters = new TButton('button_btnShowCurtainFilters');
        $btnShowCurtainFilters->setAction(new TAction(['ReceitaList', 'onShowCurtainFilters']), "Filtrar");
        $btnShowCurtainFilters->addStyleClass('btn-default');
        $btnShowCurtainFilters->setImage('fas:filter #000000');

        $this->datagrid_form->addField($btnShowCurtainFilters);

        $button_deletar = new TButton('button_button_deletar');
        $button_deletar->setAction(new TAction(['ReceitaList', 'onDeleteBatchArray']), "Deletar");
        $button_deletar->addStyleClass('btn-default');
        $button_deletar->setImage('far:trash-alt #dd5a43');

        $this->datagrid_form->addField($button_deletar);

        $button_parcelas = new TButton('button_button_parcelas');
        $button_parcelas->setAction(new TAction(['ReceitaFormParcela', 'onShow']), "Parcelas");
        $button_parcelas->addStyleClass('btn-default');
        $button_parcelas->setImage('fas:align-justify #673AB7');

        $this->datagrid_form->addField($button_parcelas);

        $head_left_actions->add($button_receita);
        $head_left_actions->add($button_receber_em_lote);
        $head_left_actions->add($btnShowCurtainFilters);
        $head_left_actions->add($button_deletar);
        $head_left_actions->add($button_parcelas);

        $this->btnShowCurtainFilters = $btnShowCurtainFilters;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Financeiro","Receitas"]));
        }

        $container->add($panel);

        parent::add($container);

    }

    public static function onExibeEditar($object)
    {
        try 
        {
            if($object->status_lancamento_id == StatusLancamento::ABERTO)
            {
                return true;
            }

            return false;
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onDelete($param = null) 
    { 
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                // get the paramseter $key
                $key = $param['key'];
                // open a transaction with database
                TTransaction::open(self::$database);

                // instantiates object
                $object = new Lancamento($key, FALSE); 

                // deletes the object from the database
                $object->delete();

                // close the transaction
                TTransaction::close();

                // reload the listing
                $this->onReload( $param );
                // shows the success message
                new TMessage('info', AdiantiCoreTranslator::translate('Record deleted'));
            }
            catch (Exception $e) // in case of exception
            {
                // shows the exception error message
                new TMessage('error', $e->getMessage());
                // undo all pending operations
                TTransaction::rollback();
            }
        }
        else
        {
            // define the delete action
            $action = new TAction(array($this, 'onDelete'));
            $action->setParameters($param); // pass the key paramseter ahead
            $action->setParameter('delete', 1);
            // shows a dialog to the user
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
        }
    }
    public static function onExibeDeletar($object)
    {
        try 
        {
            if($object->status_lancamento_id == StatusLancamento::ABERTO)
            {
                return true;
            }

            return false;
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onPagarAll($param = null) 
    {
        try 
        {

            //code here
            if(array_key_exists('builder_datagrid_check', $param)){

               AdiantiCoreApplication::loadPage('ProcessarRecebimentoForm', 'onShow', $param);
            }else{

                // Código gerado pelo snippet: "Exibir mensagem"
                new TMessage('info', "Para processar em lote é necessário selecionar um ou mais registros!");

            }

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onShowCurtainFilters($param = null) 
    {
        try 
        {
            //code here

                        $filter = new self([]);

            $btnClose = new TButton('closeCurtain');
            $btnClose->class = 'btn btn-sm btn-default';
            $btnClose->style = 'margin-right:10px;';
            $btnClose->onClick = "Template.closeRightPanel();";
            $btnClose->setLabel("Fechar");
            $btnClose->setImage('fas:times');

            $filter->form->addHeaderWidget($btnClose);

            $page = new TPage();
            $page->setTargetContainer('adianti_right_panel');
            $page->setProperty('page-name', 'ReceitaListSearch');
            $page->setProperty('page_name', 'ReceitaListSearch');
            $page->adianti_target_container = 'adianti_right_panel';
            $page->target_container = 'adianti_right_panel';
            $page->add($filter->form);
            $page->setIsWrapped(true);
            $page->show();

            $style = new TStyle('right-panel > .container-part[page-name=ReceitaListSearch]');
            $style->width = '95% !important';
            $style->show(true);

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onDeleteBatchArray($param = null) 
    {
        if(isset($param['confirmAction']) && $param['confirmAction'] == 1)
        {
            try
            {
                if($param['builder_datagrid_check'])
                {
                    TTransaction::open(self::$database);
                    foreach($param['builder_datagrid_check'] as $check_id)
                    {
                        $object = new Lancamento($check_id);
                        $object->delete();
                    }
                    TTransaction::close();

                    TToast::show("success", "Registros deletados", "topRight", "fas fa-info-circle");                
                    TApplication::loadPage(__CLASS__, 'onShow', []);
                }
            }
            catch (Exception $e) // in case of exception
            {
                new TMessage('error', $e->getMessage()); // shows the exception error message
                TTransaction::rollback(); // undo all pending operations
            }
        }
        else
        {
           if(array_key_exists('builder_datagrid_check',$param)){

                // define the delete action
                $action = new TAction(array(__CLASS__, 'onDeleteBatchArray'));
                $action->setParameters($param); // pass the key paramseter ahead
                $action->setParameter('confirmAction', 1);

                $quantidade = count($param['builder_datagrid_check']);

                $delecao = "<span class='badge badge-danger'>deleção</span>";

                new TQuestion("Voce confirma a {$delecao} de {$quantidade} registro(s)?", $action, null, "Operação Irreversível", "Deletar");
           }else{
               new TMessage('error', 'Para deletar é necessário selecionar um ou mais registros.');
           }
        }
    }

    /**
     * Register the filter in the session
     */
    public function onSearch($param = null)
    {
        $data = $this->form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->descricao) AND ( (is_scalar($data->descricao) AND $data->descricao !== '') OR (is_array($data->descricao) AND (!empty($data->descricao)) )) )
        {

            $filters[] = new TFilter('descricao', 'like', "%{$data->descricao}%");// create the filter 
        }

        if (isset($data->vencimento) AND ( (is_scalar($data->vencimento) AND $data->vencimento !== '') OR (is_array($data->vencimento) AND (!empty($data->vencimento)) )) )
        {

            $filters[] = new TFilter('vencimento', '>=', $data->vencimento);// create the filter 
        }

        if (isset($data->vencimento_final) AND ( (is_scalar($data->vencimento_final) AND $data->vencimento_final !== '') OR (is_array($data->vencimento_final) AND (!empty($data->vencimento_final)) )) )
        {

            $filters[] = new TFilter('vencimento', '<=', $data->vencimento_final);// create the filter 
        }

        if (isset($data->categoria_id) AND ( (is_scalar($data->categoria_id) AND $data->categoria_id !== '') OR (is_array($data->categoria_id) AND (!empty($data->categoria_id)) )) )
        {

            $filters[] = new TFilter('categoria_id', '=', $data->categoria_id);// create the filter 
        }

        if (isset($data->conta_id) AND ( (is_scalar($data->conta_id) AND $data->conta_id !== '') OR (is_array($data->conta_id) AND (!empty($data->conta_id)) )) )
        {

            $filters[] = new TFilter('conta_id', '=', $data->conta_id);// create the filter 
        }

        if (isset($data->status_lancamento_id) AND ( (is_scalar($data->status_lancamento_id) AND $data->status_lancamento_id !== '') OR (is_array($data->status_lancamento_id) AND (!empty($data->status_lancamento_id)) )) )
        {

            $filters[] = new TFilter('status_lancamento_id', '=', $data->status_lancamento_id);// create the filter 
        }

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        $this->onReload(['offset' => 0, 'first_page' => 1]);
    }

    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'bd_sgp'
            TTransaction::open(self::$database);

            // creates a repository for Lancamento
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'vencimento';    
            }

            if (empty($param['direction']))
            {
                $param['direction'] = 'asc';
            }

            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $this->limit);

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            $session_checks = TSession::getValue(__CLASS__.'builder_datagrid_check');

            //</blockLine><btnShowCurtainFiltersAutoCode>
            if(!empty($this->btnShowCurtainFilters) && empty($this->btnShowCurtainFiltersAdjusted))
            {
                $this->btnShowCurtainFiltersAdjusted = true;
                $this->btnShowCurtainFilters->style = 'position: relative';
                $countFilters = count($filters ?? []);
                $this->btnShowCurtainFilters->setLabel($this->btnShowCurtainFilters->getLabel(). "<span class='badge badge-success' style='position: absolute'>{$countFilters}<span>");
            }
            //</blockLine></btnShowCurtainFiltersAutoCode>

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    $check = new TCheckGroup('builder_datagrid_check');
                    $check->addItems([$object->id => '']);
                    $check->getButtons()[$object->id]->onclick = 'event.stopPropagation()';

                    if(!$this->datagrid_form->getField('builder_datagrid_check[]'))
                    {
                        $this->datagrid_form->setFields([$check]);
                    }

                    $check->setChangeAction(new TAction([$this, 'builderSelectCheck']));
                    $object->builder_datagrid_check = $check;

                    if(!empty($session_checks[$object->id]))
                    {
                        $object->builder_datagrid_check->setValue([$object->id=>$object->id]);
                    }

                    if($object->status_lancamento_id == StatusLancamento::PAGO){
                        unset($object->builder_datagrid_check);
                    }

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->id}";

                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($this->limit); // limit

            // close the transaction
            TTransaction::close();
            $this->loaded = true;

            return $objects;
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    public function onShow($param = null)
    {

    }

    /**
     * method show()
     * Shows the page
     */
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  $this->showMethods))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
        }
        parent::show();
    }

    public static function onYesDeleteAll($param = null) 
    {
        try 
        {
            $quantidade = count($param['builder_datagrid_check']);

            $registros = $param['builder_datagrid_check'];

            TTransaction::open(self::$database);

            foreach ($registros as $key => $id) {
                Lancamento::where('id', '=', $id)->delete();
            }

            TTransaction::close();

            // Código gerado pelo snippet: "Mensagem Toast"
            TToast::show("show", "Deletado(s) {$quantidade} registro(s) com successo!", "topRight", "fas:check-square");

            AdiantiCoreApplication::loadPage('DespesaList', 'onShow');

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }

    public static function onNoDeleteAll($param = null) 
    {
        try 
        {
            //code here
            TToast::show("show", "Operação cancelada, nenhum registro deletado!", "topRight", "fas:check-square");
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onYesProcessarAll($param = null) 
    {
        try 
        {
            //code here
            $quantidade = count($param['builder_datagrid_check']);

            $registros = $param['builder_datagrid_check'];

            TTransaction::open(self::$database);

            foreach ($registros as $key => $id) {

                $lancamento = new Lancamento($id);

                LancamentoService::validarDataLancamento($lancamento);

                $retorno = TransacaoService::retornarSaldoDataInicialCalculo($lancamento);

                $data_saldo =  $retorno['data_saldo'];
                $saldo = $retorno['saldo'];

                TransacaoService::processarTransacao($lancamento, $data_saldo, $saldo);

            }

            TTransaction::close();

            // Código gerado pelo snippet: "Mensagem Toast"
            TToast::show("show", "Pago(s) {$quantidade} registro(s) com successo!", "topRight", "fas:check-square");

            AdiantiCoreApplication::loadPage('DespesaList', 'onShow');
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage()); 
            TTransaction::rollback();
        }
    }

    public static function onNoProcessarAll($param = null) 
    {
        try 
        {
            //code here
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function builderSelectCheck($param)
    {
        $session_checks = TSession::getValue(__CLASS__.'builder_datagrid_check');

        $valueOn = null;
        if(!empty($param['_field_data_json']))
        {
            $obj = json_decode($param['_field_data_json']);
            if($obj)
            {
                $valueOn = $obj->valueOn;
            }
        }

        $key = empty($param['key']) ? $valueOn : $param['key'];

        if(empty($param['builder_datagrid_check']) && !empty($session_checks[$key]))
        {
            unset($session_checks[$key]);
        }
        elseif(!empty($param['builder_datagrid_check']) && !in_array($key, $param['builder_datagrid_check']) && !empty($session_checks[$key]))
        {
            unset($session_checks[$key]);
        }
        elseif(!empty($param['builder_datagrid_check']) && in_array($key, $param['builder_datagrid_check']))
        {
            $session_checks[$key] = $key;
        }

        TSession::setValue(__CLASS__.'builder_datagrid_check', $session_checks);
    }

    public static function manageRow($id)
    {
        $list = new self([]);

        $openTransaction = TTransaction::getDatabase() != self::$database ? true : false;

        if($openTransaction)
        {
            TTransaction::open(self::$database);    
        }

        $object = new Lancamento($id);

        $session_checks = TSession::getValue(__CLASS__.'builder_datagrid_check');

        $check = new TCheckGroup('builder_datagrid_check');
        $check->addItems([$object->id => '']);
        $check->getButtons()[$object->id]->onclick = 'event.stopPropagation()';

        if(!$list->datagrid_form->getField('builder_datagrid_check[]'))
        {
            $list->datagrid_form->setFields([$check]);
        }

        $check->setChangeAction(new TAction([$list, 'builderSelectCheck']));
        $object->builder_datagrid_check = $check;

        if(!empty($session_checks[$object->id]))
        {
            $object->builder_datagrid_check->setValue([$object->id=>$object->id]);
        }

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->id}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

