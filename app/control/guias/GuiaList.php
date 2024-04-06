<?php

class GuiaList extends TPage
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

        $id = new TEntry('id');
        $cliente_id = new TDBUniqueSearch('cliente_id', 'portal', 'Cliente', 'id', 'nome','nome asc'  );
        $subcategoria_guia_categoria_guia_id = new TDBCombo('subcategoria_guia_categoria_guia_id', 'portal', 'CategoriaGuia', 'id', '{nome}','nome asc'  );
        $subcategoria_guia_id = new TCombo('subcategoria_guia_id');
        $mes_competencia = new TCombo('mes_competencia');
        $ano_competencia = new TCombo('ano_competencia');
        $data_vencimento = new TDate('data_vencimento');
        $data_vencimento_final = new TDate('data_vencimento_final');
        $download_pos_vencimento = new TCombo('download_pos_vencimento');
        $downloaded = new TCombo('downloaded');

        $subcategoria_guia_categoria_guia_id->setChangeAction(new TAction([$this,'onChangesubcategoria_guia_categoria_guia_id']));

        $cliente_id->setMinLength(0);
        $data_vencimento->setDatabaseMask('yyyy-mm-dd');
        $data_vencimento_final->setDatabaseMask('yyyy-mm-dd');

        $cliente_id->setMask('{nome}');
        $data_vencimento->setMask('dd/mm/yyyy');
        $data_vencimento_final->setMask('dd/mm/yyyy');

        $downloaded->addItems(["T"=>"Sim","F"=>"Não"]);
        $ano_competencia->addItems(TempoService::getAnos());
        $mes_competencia->addItems(TempoService::getMeses());
        $download_pos_vencimento->addItems(["T"=>"Sim","F"=>"Não"]);

        $downloaded->enableSearch();
        $mes_competencia->enableSearch();
        $ano_competencia->enableSearch();
        $subcategoria_guia_id->enableSearch();
        $download_pos_vencimento->enableSearch();
        $subcategoria_guia_categoria_guia_id->enableSearch();

        $id->setSize('100%');
        $cliente_id->setSize('100%');
        $downloaded->setSize('100%');
        $data_vencimento->setSize(150);
        $mes_competencia->setSize('100%');
        $ano_competencia->setSize('100%');
        $data_vencimento_final->setSize(110);
        $subcategoria_guia_id->setSize('100%');
        $download_pos_vencimento->setSize('100%');
        $subcategoria_guia_categoria_guia_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Cliente:", null, '14px', null, '100%'),$cliente_id]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Categoria:", null, '14px', null, '100%'),$subcategoria_guia_categoria_guia_id],[new TLabel("Subcategoria:", null, '14px', null, '100%'),$subcategoria_guia_id]);
        $row2->layout = [' col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Mês de competência:", null, '14px', null, '100%'),$mes_competencia],[new TLabel("Ano de competência:", null, '14px', null, '100%'),$ano_competencia]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Data de vencimento:", null, '14px', null, '100%'),$data_vencimento,new TLabel("até", null, '14px', null),$data_vencimento_final],[new TLabel("Permite download após o vencimento?", null, '14px', null, '100%'),$download_pos_vencimento]);
        $row4->layout = ['col-sm-6','col-sm-6'];

        $row5 = $this->form->addFields([new TLabel("Download realizado?:", null, '14px', null, '100%'),$downloaded]);
        $row5->layout = ['col-sm-6'];

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
        $column_subcategoria_guia_categoria_guia_nome_subcategoria_guia_nome = new TDataGridColumn('{subcategoria_guia->categoria_guia->nome} - {subcategoria_guia->nome}', "Categoria", 'left');
        $column_cliente_nome = new TDataGridColumn('cliente->nome', "Cliente", 'left');
        $column_created_by_system_user_name = new TDataGridColumn('created_by_system_user->name', "Criado por", 'left');
        $column_downloaded_transformed = new TDataGridColumn('downloaded', "Download realizado?", 'center');
        $column_download_pos_vencimento_transformed = new TDataGridColumn('download_pos_vencimento', "Download após o vencimento?", 'center');
        $column_competencia_vencimento = new TDataGridColumn('competencia_vencimento', "Competência / Vencimento", 'left');

        $column_downloaded_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {

            if($value === 'T' || $value === true || $value === 't' || $value === 's')
            {
                return '<span class="label label-success">Sim</span>';
            }

            return '<span class="label label-danger">Não</span>';

        });

        $column_download_pos_vencimento_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {

            if($value === 'T' || $value === true || $value === 't' || $value === 's')
            {
                return '<span class="label label-success">Sim</span>';
            }

            return '<span class="label label-danger">Não</span>';

        });        

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_subcategoria_guia_categoria_guia_nome_subcategoria_guia_nome);
        $this->datagrid->addColumn($column_cliente_nome);
        $this->datagrid->addColumn($column_created_by_system_user_name);
        $this->datagrid->addColumn($column_downloaded_transformed);
        $this->datagrid->addColumn($column_download_pos_vencimento_transformed);
        $this->datagrid->addColumn($column_competencia_vencimento);

        $action_onEdit = new TDataGridAction(array('GuiaForm', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('GuiaList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fas:trash-alt #dd5a43');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

        $action_onDownload = new TDataGridAction(array('GuiaList', 'onDownload'));
        $action_onDownload->setUseButton(false);
        $action_onDownload->setButtonClass('btn btn-default btn-sm');
        $action_onDownload->setLabel("Download da guia");
        $action_onDownload->setImage('fas:file-download #8BC34A');
        $action_onDownload->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDownload);

        $action_onShow = new TDataGridAction(array('GuiaDownloadLogSimpleList', 'onShow'));
        $action_onShow->setUseButton(false);
        $action_onShow->setButtonClass('btn btn-default btn-sm');
        $action_onShow->setLabel("Histórico de download");
        $action_onShow->setImage('fas:history #9C27B0');
        $action_onShow->setField(self::$primaryKey);

        $action_onShow->setParameter('guia_id', '{id}');

        $this->datagrid->addAction($action_onShow);

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup("Listagem de guias");
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

        $button_cadastrar = new TButton('button_button_cadastrar');
        $button_cadastrar->setAction(new TAction(['GuiaForm', 'onShow']), "Cadastrar");
        $button_cadastrar->addStyleClass('btn-default');
        $button_cadastrar->setImage('fas:plus #69aa46');

        $this->datagrid_form->addField($button_cadastrar);

        $btnShowCurtainFilters = new TButton('button_btnShowCurtainFilters');
        $btnShowCurtainFilters->setAction(new TAction(['GuiaList', 'onShowCurtainFilters']), "Filtros");
        $btnShowCurtainFilters->addStyleClass('btn-default');
        $btnShowCurtainFilters->setImage('fas:filter #000000');

        $this->datagrid_form->addField($btnShowCurtainFilters);

        $button_limpar_filtros = new TButton('button_button_limpar_filtros');
        $button_limpar_filtros->setAction(new TAction(['GuiaList', 'onClearFilters']), "Limpar filtros");
        $button_limpar_filtros->addStyleClass('btn-default');
        $button_limpar_filtros->setImage('fas:eraser #f44336');

        $this->datagrid_form->addField($button_limpar_filtros);

        $button_atualizar = new TButton('button_button_atualizar');
        $button_atualizar->setAction(new TAction(['GuiaList', 'onRefresh']), "Atualizar");
        $button_atualizar->addStyleClass('btn-default');
        $button_atualizar->setImage('fas:sync-alt #03a9f4');

        $this->datagrid_form->addField($button_atualizar);

        $head_left_actions->add($button_cadastrar);
        $head_left_actions->add($btnShowCurtainFilters);
        $head_left_actions->add($button_limpar_filtros);
        $head_left_actions->add($button_atualizar);

        $this->btnShowCurtainFilters = $btnShowCurtainFilters;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Guias","Guias"]));
        }

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
                $object = new Guia($key, FALSE); 

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
    public static function onDownload($param = null) 
    {
        try 
        {

            if(!empty($param['key']))
            {
                TTransaction::open(self::$database);

                $guia = new Guia($param['key']);

                TTransaction::close();

                TPage::openFile($guia->arquivo);
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
            $page->setProperty('page-name', 'GuiaListSearch');
            $page->setProperty('page_name', 'GuiaListSearch');
            $page->adianti_target_container = 'adianti_right_panel';
            $page->target_container = 'adianti_right_panel';
            $page->add($filter->form);
            $page->setIsWrapped(true);
            $page->show();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onClearFilters($param = null) 
    {
        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        $this->onReload(['offset' => 0, 'first_page' => 1]);
    }
    public function onRefresh($param = null) 
    {
        $this->onReload([]);
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

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->id) AND ( (is_scalar($data->id) AND $data->id !== '') OR (is_array($data->id) AND (!empty($data->id)) )) )
        {

            $filters[] = new TFilter('id', '=', $data->id);// create the filter 
        }

        if (isset($data->cliente_id) AND ( (is_scalar($data->cliente_id) AND $data->cliente_id !== '') OR (is_array($data->cliente_id) AND (!empty($data->cliente_id)) )) )
        {

            $filters[] = new TFilter('cliente_id', '=', $data->cliente_id);// create the filter 
        }

        if (isset($data->subcategoria_guia_categoria_guia_id) AND ( (is_scalar($data->subcategoria_guia_categoria_guia_id) AND $data->subcategoria_guia_categoria_guia_id !== '') OR (is_array($data->subcategoria_guia_categoria_guia_id) AND (!empty($data->subcategoria_guia_categoria_guia_id)) )) )
        {

            $filters[] = new TFilter('subcategoria_guia_id', 'in', "(SELECT id FROM subcategoria_guia WHERE categoria_guia_id = '{$data->subcategoria_guia_categoria_guia_id}')");// create the filter 
        }

        if (isset($data->subcategoria_guia_id) AND ( (is_scalar($data->subcategoria_guia_id) AND $data->subcategoria_guia_id !== '') OR (is_array($data->subcategoria_guia_id) AND (!empty($data->subcategoria_guia_id)) )) )
        {

            $filters[] = new TFilter('subcategoria_guia_id', '=', $data->subcategoria_guia_id);// create the filter 
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

        if (isset($data->download_pos_vencimento) AND ( (is_scalar($data->download_pos_vencimento) AND $data->download_pos_vencimento !== '') OR (is_array($data->download_pos_vencimento) AND (!empty($data->download_pos_vencimento)) )) )
        {

            $filters[] = new TFilter('download_pos_vencimento', '=', $data->download_pos_vencimento);// create the filter 
        }

        if (isset($data->downloaded) AND ( (is_scalar($data->downloaded) AND $data->downloaded !== '') OR (is_array($data->downloaded) AND (!empty($data->downloaded)) )) )
        {

            $filters[] = new TFilter('downloaded', '=', $data->downloaded);// create the filter 
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

