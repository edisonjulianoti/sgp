<?php

class DocumentoClienteList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'portal';
    private static $activeRecord = 'Documento';
    private static $primaryKey = 'id';
    private static $formName = 'form_DocumentoList';
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
        $this->form->setFormTitle("Meus documentos");
        $this->limit = 20;

        $tipo_documento_id = new TDBCombo('tipo_documento_id', 'portal', 'TipoDocumento', 'id', '{nome}','nome asc'  );
        $vaildade = new TDate('vaildade');
        $validade_final = new TDate('validade_final');


        $tipo_documento_id->enableSearch();
        $vaildade->setMask('dd/mm/yyyy');
        $validade_final->setMask('dd/mm/yyyy');

        $vaildade->setDatabaseMask('yyyy-mm-dd');
        $validade_final->setDatabaseMask('yyyy-mm-dd');

        $vaildade->setSize(110);
        $validade_final->setSize(110);
        $tipo_documento_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Tipo de documento:", null, '14px', null, '100%'),$tipo_documento_id],[new TLabel("Vaildade:", null, '14px', null, '100%'),$vaildade,new TLabel("até", null, '14px', null),$validade_final]);
        $row1->layout = ['col-sm-6','col-sm-6'];

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

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $filterVar = TSession::getValue('cliente_id');
        $this->filter_criteria->add(new TFilter('cliente_id', '=', $filterVar));

        $this->datagrid->disableDefaultClick();
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_tipo_documento_nome = new TDataGridColumn('tipo_documento->nome', "Tipo de documento", 'left');
        $column_observacao = new TDataGridColumn('observacao', "Observação", 'left');
        $column_vaildade_transformed = new TDataGridColumn('vaildade', "Vaildade", 'left');

        $column_vaildade_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $this->datagrid->addColumn($column_tipo_documento_nome);
        $this->datagrid->addColumn($column_observacao);
        $this->datagrid->addColumn($column_vaildade_transformed);

        $action_onDownload = new TDataGridAction(array('DocumentoClienteList', 'onDownload'));
        $action_onDownload->setUseButton(true);
        $action_onDownload->setButtonClass('btn btn-default btn-sm');
        $action_onDownload->setLabel("Download");
        $action_onDownload->setImage('fas:file-download #00BCD4');
        $action_onDownload->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDownload);

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
            $container->add(TBreadCrumb::create(["Documentos","Meus documentos"]));
        }
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

    }

    public static function onDownload($param = null) 
    {
        try 
        {

            if(!empty($param['key']))
            {
                TTransaction::open(self::$database);

                $documento = new Documento($param['key']);

                $documentoDownloadLog = new DocumentoDownloadLog();
                $documentoDownloadLog->documento_id = $documento->id;
                $documentoDownloadLog->downloaded_by_system_user_id = TSession::getValue('userid');
                $documentoDownloadLog->store();

                TTransaction::close();

                TPage::openFile($documento->arquivo);
            }

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
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

        if (isset($data->tipo_documento_id) AND ( (is_scalar($data->tipo_documento_id) AND $data->tipo_documento_id !== '') OR (is_array($data->tipo_documento_id) AND (!empty($data->tipo_documento_id)) )) )
        {

            $filters[] = new TFilter('tipo_documento_id', '=', $data->tipo_documento_id);// create the filter 
        }

        if (isset($data->vaildade) AND ( (is_scalar($data->vaildade) AND $data->vaildade !== '') OR (is_array($data->vaildade) AND (!empty($data->vaildade)) )) )
        {

            $filters[] = new TFilter('vaildade', '>=', $data->vaildade);// create the filter 
        }

        if (isset($data->validade_final) AND ( (is_scalar($data->validade_final) AND $data->validade_final !== '') OR (is_array($data->validade_final) AND (!empty($data->validade_final)) )) )
        {

            $filters[] = new TFilter('vaildade', '<=', $data->validade_final);// create the filter 
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
            // open a transaction with database 'portal'
            TTransaction::open(self::$database);

            // creates a repository for Documento
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

    public static function manageRow($id)
    {
        $list = new self([]);

        $openTransaction = TTransaction::getDatabase() != self::$database ? true : false;

        if($openTransaction)
        {
            TTransaction::open(self::$database);    
        }

        $object = new Documento($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->id}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

