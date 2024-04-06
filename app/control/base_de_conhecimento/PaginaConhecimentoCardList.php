<?php

class PaginaConhecimentoCardList extends TPage
{
    private $form; // form
    private $cardView; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'portal';
    private static $activeRecord = 'PaginaConhecimento';
    private static $primaryKey = 'id';
    private static $formName = 'form_PaginaConhecimentoCardList';
    private $showMethods = ['onReload', 'onSearch'];

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param = null)
    {
        parent::__construct();
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Base de conhecimento");

        $titulo = new TEntry('titulo');
        $conteudo = new TEntry('conteudo');
        $descricao_resumida = new TEntry('descricao_resumida');

        $titulo->setSize('100%');
        $conteudo->setSize('100%');
        $descricao_resumida->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Título:", null, '14px', null, '100%'),$titulo],[new TLabel("Conteúdo:", null, '14px', null, '100%'),$conteudo],[new TLabel("Descrição resumida:", null, '14px', null, '100%'),$descricao_resumida]);
        $row1->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $this->btn_onsearch = $btn_onsearch;
        $btn_onsearch->addStyleClass('btn-primary'); 

        $this->cardView = new TCardView;

        $this->cardView->setContentHeight(170);
        $this->cardView->setTitleTemplate('{titulo}');
        $this->cardView->setItemTemplate("<b> {descricao_resumida} </b>");

        $this->cardView->setItemDatabase(self::$database);

        $this->filter_criteria = new TCriteria;

        $filterVar = "T";
        $this->filter_criteria->add(new TFilter('ativo', '=', $filterVar));

        $action_PaginaConhecimentoFormView_onShow = new TAction(['PaginaConhecimentoFormView', 'onShow'], ['key'=> '{id}']);

        $this->cardView->addAction($action_PaginaConhecimentoFormView_onShow, "Visualizar", 'fas:search-plus #00BCD4', null, "Visualizar", true); 

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));

        $panel = new TPanelGroup;
        $panel->add($this->cardView);

        $panel->addFooter($this->pageNavigation);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["Base de Conhecimento","Base de conhecimento"]));
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

    }

    /**
     * Register the filter in the session
     */
    public function onSearch($param = null)
    {
        // get the search form data
        $data = $this->form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->titulo) AND ( (is_scalar($data->titulo) AND $data->titulo !== '') OR (is_array($data->titulo) AND (!empty($data->titulo)) )) )
        {

            $filters[] = new TFilter('titulo', 'like', "%{$data->titulo}%");// create the filter 
        }

        if (isset($data->conteudo) AND ( (is_scalar($data->conteudo) AND $data->conteudo !== '') OR (is_array($data->conteudo) AND (!empty($data->conteudo)) )) )
        {

            $filters[] = new TFilter('conteudo', 'like', "%{$data->conteudo}%");// create the filter 
        }

        if (isset($data->descricao_resumida) AND ( (is_scalar($data->descricao_resumida) AND $data->descricao_resumida !== '') OR (is_array($data->descricao_resumida) AND (!empty($data->descricao_resumida)) )) )
        {

            $filters[] = new TFilter('descricao_resumida', 'like', "%{$data->descricao_resumida}%");// create the filter 
        }

        $param = array();
        $param['offset']     = 0;
        $param['first_page'] = 1;

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        $this->onReload($param);
    }

    public function onReload($param = NULL)
    {
        try
        {

            // open a transaction with database 'portal'
            TTransaction::open(self::$database);

            // creates a repository for PaginaConhecimento
            $repository = new TRepository(self::$activeRecord);
            $limit = 20;

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
            $criteria->setProperty('limit', $limit);

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->cardView->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $this->cardView->addItem($object);

                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($limit); // limit

            // close the transaction
            TTransaction::close();
            $this->loaded = true;
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

}

