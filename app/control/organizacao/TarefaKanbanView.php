<?php

class TarefaKanbanView extends TPage
{
    private static $database = 'bd_sgp';
    private static $activeRecord = 'Tarefa';
    private static $primaryKey = 'id';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        try
        {
            parent::__construct();

            $kanban = new TKanban;
            $kanban->setItemDatabase(self::$database);

            $limit = 20;
            $kanban->setLoadMoreAction(new TAction([$this, 'onLoadMore'], $param), $limit);

            $criteriaStage = new TCriteria();
            $criteriaItem = new TCriteria();

            $criteriaStage->setProperty('order', 'id asc');
            $criteriaItem->setProperty('order', 'id asc');

            TSession::setValue(__CLASS__.'load_filter_conclusao', null);
            TSession::setValue(__CLASS__.'load_filter_conclusao', null);
            TSession::setValue(__CLASS__.'load_filter_tipo_id', null);
            TSession::setValue(__CLASS__.'load_filter_relevancia_id', null);
            TSession::setValue(__CLASS__.'load_filter_plano_id', null);

            $filterVar = DateService::retornarDataFormatoBanco(array_key_exists('conclusao_inicio',$param)?$param['conclusao_inicio'] : "");
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('conclusao', '>=', $filterVar)); 
            }
            $filterVar = DateService::retornarDataFormatoBanco(array_key_exists('conclusao_fim',$param)?$param['conclusao_fim'] : "");
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('conclusao', '<=', $filterVar)); 
            }
            if(!empty($param['tipo_id']))
            {
                TSession::setValue(__CLASS__.'load_filter_tipo_id', $param['tipo_id']);
            }
            $filterVar = TSession::getValue(__CLASS__.'load_filter_tipo_id');
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('tipo_id', '=', $filterVar)); 
            }
            if(!empty($param['relevancia_id']))
            {
                TSession::setValue(__CLASS__.'load_filter_relevancia_id', $param['relevancia_id']);
            }
            $filterVar = TSession::getValue(__CLASS__.'load_filter_relevancia_id');
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('relevancia_id', '=', $filterVar)); 
            }
            if(!empty($param['plano_id']))
            {
                TSession::setValue(__CLASS__.'load_filter_plano_id', $param['plano_id']);
            }
            $filterVar = TSession::getValue(__CLASS__.'load_filter_plano_id');
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('plano_id', '=', $filterVar)); 
            }

            $filterVar = TSession::getValue("userid");
            $criteriaItem->add(new TFilter('system_users_id', '=', $filterVar)); 

            TTransaction::open(self::$database);
            $stages = StatusTarefa::getObjects($criteriaStage);

            if($stages)
            {
                foreach ($stages as $key => $stage)
                {

                    $criteriaItemStage = clone $criteriaItem;
                    $criteriaItemStage->add(new TFilter('status_tarefa_id', '=', $stage->id));
                    $criteriaItemStage->setProperty('limit', $limit);

                    $kanban->addStage($stage->id, "{descricao}", $stage ,$stage->descricao);

                    $items = Tarefa::getObjects($criteriaItemStage);

                    if($items)
                    {
                        foreach ($items as $key => $item)
                        {

                            $kanban->addItem($item->id, $item->status_tarefa_id, "{descricao}", " {detalhe} ", $item->relevancia->cor, $item);

                        }    
                    }
                }    
            }

            $kanbanItemAction_TarefaForm_onEdit = new TAction(['TarefaForm', 'onEdit']);
            $kanbanItemAction_TarefaForm_onEdit->setParameter("origem_registro_tarefa", "kanban");

            $kanban->addItemAction("Editar", $kanbanItemAction_TarefaForm_onEdit, 'fas:edit #2196F3');

            //$kanban->setTemplatePath('app/resources/card.html');

            $kanban->setItemDropAction(new TAction([__CLASS__, 'onUpdateItemDrop']));
            $kanban->setStageDropAction(new TAction([__CLASS__, 'onUpdateStageDrop']));
            TTransaction::close();

            $container = new TVBox;

            $container->style = 'width: 100%';
            $container->class = 'form-container';
            if(empty($param['target_container']))
            {
                $container->add(TBreadCrumb::create(["Organização","TarefaKanbanView"]));
            }
            $container->add($kanban);

            parent::add($container);
        }
        catch(Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public static function onUpdateStageDrop($param)
    {
        try
        {
            TTransaction::open(self::$database);

            if (!empty($param['order']))
            {
                foreach ($param['order'] as $key => $id)
                {
                    $sequence = ++ $key;

                    $stage = new StatusTarefa($id);
                    $stage->id = $sequence;

                    $stage->store();

                }
            }
            TTransaction::close();
        }
        catch (Exception $e)
        {
            TTransaction::rollback();
            new TMessage('error', $e->getMessage());
        }
    }
    /**
     * Update item on drop
     */
    public static function onUpdateItemDrop($param)
    {
        try
        {
            TTransaction::open(self::$database);

            if (!empty($param['order']))
            {
                foreach ($param['order'] as $key => $id)
                {
                    $sequence = ++$key;

                    $item = new Tarefa($id);
                    $item->id = $sequence;
                    $item->status_tarefa_id = $param['stage_id'];

                    $item->store();

                    if($id == $param['key'])
                    {
                        TScript::create("$(\"div[item_id='{$param['key']}']\").css('border-top', '3px solid {$item->relevancia->cor}');");
                    }

                }

                TTransaction::close();
            }
        }
        catch (Exception $e)
        {
            TTransaction::rollback();
            new TMessage('error', $e->getMessage());
        }
    }

    public static function onLoadMore($param)
    {
        try
        {
            TTransaction::open(self::$database);
            $criteriaItem = new TCriteria;

            TSession::setValue(__CLASS__.'load_filter_conclusao', null);
            TSession::setValue(__CLASS__.'load_filter_conclusao', null);
            TSession::setValue(__CLASS__.'load_filter_tipo_id', null);
            TSession::setValue(__CLASS__.'load_filter_relevancia_id', null);
            TSession::setValue(__CLASS__.'load_filter_plano_id', null);

            $filterVar = DateService::retornarDataFormatoBanco(array_key_exists('conclusao_inicio',$param)?$param['conclusao_inicio'] : "");
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('conclusao', '>=', $filterVar)); 
            }
            $filterVar = DateService::retornarDataFormatoBanco(array_key_exists('conclusao_fim',$param)?$param['conclusao_fim'] : "");
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('conclusao', '<=', $filterVar)); 
            }
            if(!empty($param['tipo_id']))
            {
                TSession::setValue(__CLASS__.'load_filter_tipo_id', $param['tipo_id']);
            }
            $filterVar = TSession::getValue(__CLASS__.'load_filter_tipo_id');
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('tipo_id', '=', $filterVar)); 
            }
            if(!empty($param['relevancia_id']))
            {
                TSession::setValue(__CLASS__.'load_filter_relevancia_id', $param['relevancia_id']);
            }
            $filterVar = TSession::getValue(__CLASS__.'load_filter_relevancia_id');
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('relevancia_id', '=', $filterVar)); 
            }
            if(!empty($param['plano_id']))
            {
                TSession::setValue(__CLASS__.'load_filter_plano_id', $param['plano_id']);
            }
            $filterVar = TSession::getValue(__CLASS__.'load_filter_plano_id');
            if (isset($filterVar) AND ( (is_scalar($filterVar) AND $filterVar !== '') OR (is_array($filterVar) AND (!empty($filterVar)))))
            {
                $criteriaItem->add(new TFilter('plano_id', '=', $filterVar)); 
            }

                $filterVar = TSession::getValue("userid");
            $criteriaItem->add(new TFilter('system_users_id', '=', $filterVar)); 

            $criteriaItem->add(new TFilter('status_tarefa_id', '=', $param['key'])); 
            $criteriaItem->setProperty('offset', $param['offset']);
            $criteriaItem->setProperty('limit', $param['limit']);
            $criteriaItem->setProperty('order', 'id asc');

            $items = Tarefa::getObjects($criteriaItem);

            if ($items)
            {
                $actions = [];
                $kanbanItemAction_TarefaForm_onEdit = new TAction(['TarefaForm', 'onEdit']);
                $kanbanItemAction_TarefaForm_onEdit->setParameter("origem_registro_tarefa", "kanban");

                $actions[] = ["Editar", $kanbanItemAction_TarefaForm_onEdit, 'fas:edit #2196F3'];

                foreach($items as $item)
                {

                    TKanban::createItem($item->id, $item->status_tarefa_id, "{descricao}", " {detalhe} ", $item->relevancia->cor, $item, null, $actions);

                }
            }

            TTransaction::close();
        }
        catch(Exception $e)
        {
            TTransaction::rollback();
            new TMessage('error', $e->getMessage());
        }
    }

    public function onShow($param = null)
    {

        TScript::create("$('.kanban-title').filter(function() { return $(this).text() == 'Pendente'; }).css({'background-color': '#ffcdd2', 'border-radius':'4px'});");

        TScript::create("$('.kanban-title').filter(function() { return $(this).text() == 'Em Progresso'; }).css({'background-color': '##fff9c4', 'border-radius':'4px'});");

        TScript::create("$('.kanban-title').filter(function() { return $(this).text() == 'Concluída'; }).css({'background-color': '#a5d6a7', 'border-radius':'4px'});");

    } 

}

