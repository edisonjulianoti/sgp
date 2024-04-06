<?php

class AtendimentoList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'portal';
    private static $activeRecord = 'Atendimento';
    private static $primaryKey = 'id';
    private static $formName = 'form_AtendimentoClienteList';
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
        $this->form->setFormTitle("Listagem de meus atendimentos");
        $this->limit = 20;

        $criteria_setor_id = new TCriteria();

        $filterVar = TSession::getValue('setores_atendente');
        $criteria_setor_id->add(new TFilter('id', 'in', $filterVar)); 

        $id = new TEntry('id');
        $tipo_atendimento_id = new TDBCombo('tipo_atendimento_id', 'portal', 'TipoAtendimento', 'id', '{nome}','nome asc'  );
        $setor_id = new TDBCombo('setor_id', 'portal', 'Setor', 'id', '{nome}','nome asc' , $criteria_setor_id );
        $atendente_id = new TCombo('atendente_id');

        $setor_id->setChangeAction(new TAction([$this,'onChangeSetor']));

        $setor_id->enableSearch();
        $atendente_id->enableSearch();
        $tipo_atendimento_id->enableSearch();

        $id->setSize('100%');
        $setor_id->setSize('100%');
        $atendente_id->setSize('100%');
        $tipo_atendimento_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Tipo atendimento:", null, '14px', null, '100%'),$tipo_atendimento_id],[new TLabel("Setor:", null, '14px', null, '100%'),$setor_id],[new TLabel("Atendente:", null, '14px', null, '100%'),$atendente_id]);
        $row1->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );
        $this->fireEvents( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $this->btn_onsearch = $btn_onsearch;
        $btn_onsearch->addStyleClass('btn-primary'); 

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_id = new TDataGridColumn('id', "Id", 'center' , '70px');
        $column_setor_nome = new TDataGridColumn('setor->nome', "Setor", 'left');
        $column_tipo_atendimento_nome = new TDataGridColumn('tipo_atendimento->nome', "Tipo de atendimento", 'left');
        $column_cliente_nome = new TDataGridColumn('cliente->nome', "Cliente", 'left');
        $column_cliente_usuario_system_user_name = new TDataGridColumn('cliente_usuario->system_user->name', "Solicitante", 'left');
        $column_atendente_system_user_name = new TDataGridColumn('atendente->system_user->name', "Atendente", 'left');
        $column_data_abertura_transformed = new TDataGridColumn('data_abertura', "Data de abertura", 'center');
        $column_data_fechamento_transformed = new TDataGridColumn('data_fechamento', "Data de fechamento", 'center');

        $column_data_abertura_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!empty(trim($value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y H:i');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });

        $column_data_fechamento_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!empty(trim($value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y H:i');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });        

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_setor_nome);
        $this->datagrid->addColumn($column_tipo_atendimento_nome);
        $this->datagrid->addColumn($column_cliente_nome);
        $this->datagrid->addColumn($column_cliente_usuario_system_user_name);
        $this->datagrid->addColumn($column_atendente_system_user_name);
        $this->datagrid->addColumn($column_data_abertura_transformed);
        $this->datagrid->addColumn($column_data_fechamento_transformed);

        $action_onShow = new TDataGridAction(array('AtendimentoFormView', 'onShow'));
        $action_onShow->setUseButton(false);
        $action_onShow->setButtonClass('btn btn-default btn-sm');
        $action_onShow->setLabel("");
        $action_onShow->setImage('fas:search-plus #00BCD4');
        $action_onShow->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onShow);

        $action_onAtenderAtendimento = new TDataGridAction(array('AtendimentoList', 'onAtenderAtendimento'));
        $action_onAtenderAtendimento->setUseButton(false);
        $action_onAtenderAtendimento->setButtonClass('btn btn-default btn-sm');
        $action_onAtenderAtendimento->setLabel("Atender Atendimento");
        $action_onAtenderAtendimento->setImage('fas:hand-lizard #8BC34A');
        $action_onAtenderAtendimento->setField(self::$primaryKey);
        $action_onAtenderAtendimento->setDisplayCondition('AtendimentoList::onExibirAtenderAtendimento');

        $this->datagrid->addAction($action_onAtenderAtendimento);

        $action_onEdit = new TDataGridAction(array('AtendimentoTrocarSetorForm', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Trocar atendimento de setor");
        $action_onEdit->setImage('fas:exchange-alt #3F51B5');
        $action_onEdit->setField(self::$primaryKey);
        $action_onEdit->setDisplayCondition('AtendimentoList::onExibirTrocarAtendimento');

        $this->datagrid->addAction($action_onEdit);

        $action_onFecharAtendimento = new TDataGridAction(array('AtendimentoList', 'onFecharAtendimento'));
        $action_onFecharAtendimento->setUseButton(false);
        $action_onFecharAtendimento->setButtonClass('btn btn-default btn-sm');
        $action_onFecharAtendimento->setLabel("Fechar Atendimento");
        $action_onFecharAtendimento->setImage('fas:flag-checkered #F44336');
        $action_onFecharAtendimento->setField(self::$primaryKey);
        $action_onFecharAtendimento->setDisplayCondition('AtendimentoList::onExibirFecharAtendimento');

        $this->datagrid->addAction($action_onFecharAtendimento);

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup();
        $panel->datagrid = 'datagrid-container';
        $this->datagridPanel = $panel;
        $this->datagrid_form->add($this->datagrid);
        $panel->add($this->datagrid_form);

        $panel->getBody()->class .= ' table-responsive';

        $panel->addFooter($this->pageNavigation);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Atendimento","Atendimentos"]));
        }
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

    }

    public static function onChangeSetor($param = null) 
    {
        try 
        {

            // Código gerado pelo snippet: "Recarregar combo através de filtros" 

            if(!empty($param['setor_id']))
            {
                TTransaction::open(self::$database);
                $criteria = new TCriteria();
                $criteria->add(new TFilter('id', 'in', "(SELECT atendente_id FROM setor_atendente WHERE setor_id = '{$param['setor_id']}')"));

                TCombo::reload(self::$formName, 'atendente_id', Atendente::getIndexedArray('id', '{system_user->name}', $criteria), true);
                TTransaction::close();        
            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onAtenderAtendimento($param = null) 
    {
        try 
        {
            // Código gerado pelo snippet: "Questionamento"
            new TQuestion("Você tem certeza que quer atender este atendimento?", new TAction([__CLASS__, 'onYesAtender'], $param), new TAction([__CLASS__, 'onNoAtender'], $param));
            // -----

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onExibirAtenderAtendimento($object)
    {
        try 
        {
            if($object->atendente_id != TSession::getValue('atendente_id'))
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
    public static function onExibirTrocarAtendimento($object)
    {
        try 
        {
            if(!$object->data_fechamento)
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
    public static function onFecharAtendimento($param = null) 
    {
        try 
        {
            // Código gerado pelo snippet: "Questionamento"
            new TQuestion("Você tem certeza que deseja fechar este atendimento?", new TAction([__CLASS__, 'onYesFecharAtendimento'], $param), new TAction([__CLASS__, 'onNoFecharAtendimento'], $param));
            // -----
            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onExibirFecharAtendimento($object)
    {
        try 
        {
            if(!$object->data_fechamento)
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

    public function fireEvents( $object )
    {
        $obj = new stdClass;
        if(is_object($object) && get_class($object) == 'stdClass')
        {
            if(isset($object->setor_id))
            {
                $value = $object->setor_id;

                $obj->setor_id = $value;
            }
            if(isset($object->atendente_id))
            {
                $value = $object->atendente_id;

                $obj->atendente_id = $value;
            }
        }
        elseif(is_object($object))
        {
            if(isset($object->setor_id))
            {
                $value = $object->setor_id;

                $obj->setor_id = $value;
            }
            if(isset($object->atendente_id))
            {
                $value = $object->atendente_id;

                $obj->atendente_id = $value;
            }
        }
        TForm::sendData(self::$formName, $obj);
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

        if (isset($data->id) AND ( (is_scalar($data->id) AND $data->id !== '') OR (is_array($data->id) AND (!empty($data->id)) )) )
        {

            $filters[] = new TFilter('id', '=', $data->id);// create the filter 
        }

        if (isset($data->tipo_atendimento_id) AND ( (is_scalar($data->tipo_atendimento_id) AND $data->tipo_atendimento_id !== '') OR (is_array($data->tipo_atendimento_id) AND (!empty($data->tipo_atendimento_id)) )) )
        {

            $filters[] = new TFilter('tipo_atendimento_id', '=', $data->tipo_atendimento_id);// create the filter 
        }

        if (isset($data->setor_id) AND ( (is_scalar($data->setor_id) AND $data->setor_id !== '') OR (is_array($data->setor_id) AND (!empty($data->setor_id)) )) )
        {

            $filters[] = new TFilter('setor_id', '=', $data->setor_id);// create the filter 
        }

        if (isset($data->atendente_id) AND ( (is_scalar($data->atendente_id) AND $data->atendente_id !== '') OR (is_array($data->atendente_id) AND (!empty($data->atendente_id)) )) )
        {

            $filters[] = new TFilter('atendente_id', '=', $data->atendente_id);// create the filter 
        }

        $this->fireEvents($data);

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
            // open a transaction with database 'portal'
            TTransaction::open(self::$database);

            // creates a repository for Atendimento
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'id';    
            }

            if (empty($param['direction']))
            {
                $param['direction'] = 'desc';
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

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

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

    public static function onYesAtender($param = null) 
    {
        try 
        {
            if(!empty($param['key']))
            {
                TTransaction::open(self::$database);

                $atendimento = new Atendimento($param['key']);
                $atendimento->atendente_id = TSession::getValue('atendente_id');
                $atendimento->store();

                TTransaction::close();

                $pageParam = [
                    'key' => $atendimento->id
                ];
                TApplication::loadPage('AtendimentoList', 'onShow');
                TApplication::loadPage('AtendimentoFormView', 'onShow', $pageParam);

                // Código gerado pelo snippet: "Mensagem Toast"
                TToast::show("success", "Atendimento vinculado com sucesso", "topRight", "fas:check");
                // -----

            }
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onNoAtender($param = null) 
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

    public static function onYesFecharAtendimento($param = null) 
    {
        try 
        {
            TTransaction::open(self::$database);

            $atendimento = new Atendimento($param['key']);
            $atendimento->data_fechamento = date('Y-m-d H:i:s');
            $atendimento->store();

            TTransaction::close();

            // Código gerado pelo snippet: "Mensagem Toast"
            TToast::show("success", "Atendimento fechado!", "topRight", "fas:flag-checkered");
            // -----

            $pageParam = []; // ex.: = ['key' => 10]

            TApplication::loadPage('AtendimentoList', 'onShow', $pageParam);
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onNoFecharAtendimento($param = null) 
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

    public static function manageRow($id)
    {
        $list = new self([]);

        $openTransaction = TTransaction::getDatabase() != self::$database ? true : false;

        if($openTransaction)
        {
            TTransaction::open(self::$database);    
        }

        $object = new Atendimento($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->id}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

