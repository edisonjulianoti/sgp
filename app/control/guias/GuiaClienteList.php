<?php

class GuiaClienteList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'portal';
    private static $activeRecord = 'Guia';
    private static $primaryKey = 'id';
    private static $formName = 'form_GuiaList';
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
        $this->form->setFormTitle("Listagem de guias");
        $this->limit = 20;

        $subcategoria_guia_categoria_guia_id = new TDBCombo('subcategoria_guia_categoria_guia_id', 'portal', 'CategoriaGuia', 'id', '{nome}','nome asc'  );
        $subcategoria_guia_id = new TCombo('subcategoria_guia_id');
        $downloaded = new TCombo('downloaded');
        $mes_competencia = new TCombo('mes_competencia');
        $ano_competencia = new TCombo('ano_competencia');
        $data_vencimento = new TDate('data_vencimento');
        $data_vencimento_final = new TDate('data_vencimento_final');

        $subcategoria_guia_categoria_guia_id->setChangeAction(new TAction([$this,'onChangesubcategoria_guia_categoria_guia_id']));

        $data_vencimento->setMask('dd/mm/yyyy');
        $data_vencimento_final->setMask('dd/mm/yyyy');

        $data_vencimento->setDatabaseMask('yyyy-mm-dd');
        $data_vencimento_final->setDatabaseMask('yyyy-mm-dd');

        $downloaded->addItems(["T"=>"Sim","F"=>"Não"]);
        $ano_competencia->addItems(TempoService::getAnos());
        $mes_competencia->addItems(TempoService::getMeses());

        $downloaded->enableSearch();
        $mes_competencia->enableSearch();
        $ano_competencia->enableSearch();
        $subcategoria_guia_id->enableSearch();
        $subcategoria_guia_categoria_guia_id->enableSearch();

        $downloaded->setSize('100%');
        $data_vencimento->setSize(150);
        $mes_competencia->setSize('100%');
        $ano_competencia->setSize('100%');
        $data_vencimento_final->setSize(110);
        $subcategoria_guia_id->setSize('100%');
        $subcategoria_guia_categoria_guia_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Categoria:", null, '14px', null, '100%'),$subcategoria_guia_categoria_guia_id],[new TLabel("Subcategoria:", null, '14px', null, '100%'),$subcategoria_guia_id],[new TLabel("Download realizado?", null, '14px', null, '100%'),$downloaded]);
        $row1->layout = [' col-sm-3',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Mês de competência:", null, '14px', null, '100%'),$mes_competencia],[new TLabel("Ano de competência:", null, '14px', null, '100%'),$ano_competencia],[new TLabel("Data de vencimento:", null, '14px', null, '100%'),$data_vencimento,new TLabel("até", null, '14px', null),$data_vencimento_final]);
        $row2->layout = [' col-sm-3',' col-sm-3','col-sm-6'];

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

        $filterVar = TSession::getValue('cliente_id');
        $this->filter_criteria->add(new TFilter('cliente_id', '=', $filterVar));

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_subcategoria_guia_categoria_guia_nome_subcategoria_guia_nome = new TDataGridColumn('{subcategoria_guia->categoria_guia->nome} - {subcategoria_guia->nome}', "Categoria", 'left');
        $column_downloaded_transformed = new TDataGridColumn('downloaded', "Download realizado?", 'center');
        $column_competencia = new TDataGridColumn('competencia', "Competência", 'center');
        $column_data_vencimento_transformed = new TDataGridColumn('data_vencimento', "Data de vencimento", 'center');

        $column_downloaded_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {

            if($value === 'T' || $value === true || $value === 't' || $value === 's')
            {
                return '<span class="label label-success">Sim</span>';
            }

            return '<span class="label label-danger">Não</span>';

        });

        $column_data_vencimento_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {

            $data_vencimento = TDate::date2br($value);

            if(date('Y-m-d') > $value )
            {
                return "<span title = 'Vencida' class='label label-danger'>{$data_vencimento}</span>";
            }
            else if(date('Y-m-d') == $value )
            {
                return "<span title = 'Vencendo hoje' class='label label-warning'>{$data_vencimento}</span>";
            }
            else
            {
                return "<span title = 'A vencer' class='label label-success'>{$data_vencimento}</span>";
            }

        });        

        $this->datagrid->addColumn($column_subcategoria_guia_categoria_guia_nome_subcategoria_guia_nome);
        $this->datagrid->addColumn($column_downloaded_transformed);
        $this->datagrid->addColumn($column_competencia);
        $this->datagrid->addColumn($column_data_vencimento_transformed);

        $action_onDownload = new TDataGridAction(array('GuiaClienteList', 'onDownload'));
        $action_onDownload->setUseButton(true);
        $action_onDownload->setButtonClass('btn btn-default btn-sm');
        $action_onDownload->setLabel("Download da guia");
        $action_onDownload->setImage('fas:file-download #8BC34A');
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
            $container->add(TBreadCrumb::create(["Guias","Minhas Guias"]));
        }
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

    }

    public static function onChangesubcategoria_guia_categoria_guia_id($param)
    {
        try
        {

            if (isset($param['subcategoria_guia_categoria_guia_id']) && $param['subcategoria_guia_categoria_guia_id'])
            { 
                $criteria = TCriteria::create(['categoria_guia_id' => $param['subcategoria_guia_categoria_guia_id']]);
                TDBCombo::reloadFromModel(self::$formName, 'subcategoria_guia_id', 'portal', 'SubcategoriaGuia', 'id', '{nome}', 'nome asc', $criteria, TRUE); 
            } 
            else 
            { 
                TCombo::clearField(self::$formName, 'subcategoria_guia_id'); 
            }  

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    } 

    public static function onDownload($param = null) 
    {
        try 
        {
            if(!empty($param['key']))
            {
                TTransaction::open(self::$database);
                $guia = new Guia($param['key']);

                if(date('Y-m-d') > $guia->data_vencimento && $guia->download_pos_vencimento == 'F')
                {
                    throw new Exception('Não é possível fazer o download de uma guia já vencida');
                }

                $guia->downloaded = 'T';
                $guia->store();

                $guiaDownloadLog = new GuiaDownloadLog();
                $guiaDownloadLog->guia_id = $guia->id;
                $guiaDownloadLog->downloaded_by_system_user_id = TSession::getValue('userid');
                $guiaDownloadLog->store();

                TPage::openFile($guia->arquivo);

                TTransaction::close();
            }

            //</autoCode>
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
            if(isset($object->subcategoria_guia_categoria_guia_id))
            {
                $value = $object->subcategoria_guia_categoria_guia_id;

                $obj->subcategoria_guia_categoria_guia_id = $value;
            }
            if(isset($object->subcategoria_guia_id))
            {
                $value = $object->subcategoria_guia_id;

                $obj->subcategoria_guia_id = $value;
            }
        }
        elseif(is_object($object))
        {
            if(isset($object->subcategoria_guia->categoria_guia_id))
            {
                $value = $object->subcategoria_guia->categoria_guia_id;

                $obj->subcategoria_guia_categoria_guia_id = $value;
            }
            if(isset($object->subcategoria_guia_id))
            {
                $value = $object->subcategoria_guia_id;

                $obj->subcategoria_guia_id = $value;
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

        if(!empty($param['filter_downloaded']))
        {
            $data->downloaded = $param['filter_downloaded'];
        }

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->subcategoria_guia_categoria_guia_id) AND ( (is_scalar($data->subcategoria_guia_categoria_guia_id) AND $data->subcategoria_guia_categoria_guia_id !== '') OR (is_array($data->subcategoria_guia_categoria_guia_id) AND (!empty($data->subcategoria_guia_categoria_guia_id)) )) )
        {

            $filters[] = new TFilter('subcategoria_guia_id', 'in', "(SELECT id FROM subcategoria_guia WHERE categoria_guia_id = '{$data->subcategoria_guia_categoria_guia_id}')");// create the filter 
        }

        if (isset($data->subcategoria_guia_id) AND ( (is_scalar($data->subcategoria_guia_id) AND $data->subcategoria_guia_id !== '') OR (is_array($data->subcategoria_guia_id) AND (!empty($data->subcategoria_guia_id)) )) )
        {

            $filters[] = new TFilter('subcategoria_guia_id', '=', $data->subcategoria_guia_id);// create the filter 
        }

        if (isset($data->downloaded) AND ( (is_scalar($data->downloaded) AND $data->downloaded !== '') OR (is_array($data->downloaded) AND (!empty($data->downloaded)) )) )
        {

            $filters[] = new TFilter('downloaded', '=', $data->downloaded);// create the filter 
        }

        if (isset($data->mes_competencia) AND ( (is_scalar($data->mes_competencia) AND $data->mes_competencia !== '') OR (is_array($data->mes_competencia) AND (!empty($data->mes_competencia)) )) )
        {

            $filters[] = new TFilter('mes_competencia', '=', $data->mes_competencia);// create the filter 
        }

        if (isset($data->ano_competencia) AND ( (is_scalar($data->ano_competencia) AND $data->ano_competencia !== '') OR (is_array($data->ano_competencia) AND (!empty($data->ano_competencia)) )) )
        {

            $filters[] = new TFilter('ano_competencia', '=', $data->ano_competencia);// create the filter 
        }

        if (isset($data->data_vencimento) AND ( (is_scalar($data->data_vencimento) AND $data->data_vencimento !== '') OR (is_array($data->data_vencimento) AND (!empty($data->data_vencimento)) )) )
        {

            $filters[] = new TFilter('data_vencimento', '>=', $data->data_vencimento);// create the filter 
        }

        if (isset($data->data_vencimento_final) AND ( (is_scalar($data->data_vencimento_final) AND $data->data_vencimento_final !== '') OR (is_array($data->data_vencimento_final) AND (!empty($data->data_vencimento_final)) )) )
        {

            $filters[] = new TFilter('data_vencimento', '<=', $data->data_vencimento_final);// create the filter 
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

            // creates a repository for Guia
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

        $this->onSearch([
            'filter_downloaded' => 'F'
        ]);

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

        $object = new Guia($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->id}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

