<?php

class KanbanForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_KanbanForm';

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
        $this->form->setFormTitle("Kanban");

        $criteria_plano_id = new TCriteria();

        $filterVar = TSession::getValue("userid");
        $criteria_plano_id->add(new TFilter('system_users_id', '=', $filterVar)); 

        $conclusao_inicio = new TDate('conclusao_inicio');
        $conclusao_fim = new TDate('conclusao_fim');
        $tipo_id = new TDBCombo('tipo_id', 'bd_sgp', 'Tipo', 'id', '{descricao}','id asc'  );
        $relevancia_id = new TDBCombo('relevancia_id', 'bd_sgp', 'Relevancia', 'id', '{descricao}','descricao asc'  );
        $plano_id = new TDBCombo('plano_id', 'bd_sgp', 'Plano', 'id', '{descricao}','descricao asc' , $criteria_plano_id );
        $button_buscar = new TButton('button_buscar');
        $kanba = new BPageContainer();
        $button_nova_tarefa = new TButton('button_nova_tarefa');


        $kanba->setId('b634abe18697bd');
        $conclusao_fim->setMask('dd/mm/yyyy');
        $conclusao_inicio->setMask('dd/mm/yyyy');

        $conclusao_fim->setDatabaseMask('yyyy-mm-dd');
        $conclusao_inicio->setDatabaseMask('yyyy-mm-dd');

        $button_buscar->addStyleClass('btn-info');
        $button_nova_tarefa->addStyleClass('btn-success');

        $button_buscar->setImage('fas:search #FFFFFF');
        $button_nova_tarefa->setImage('fas:plus-square #FFFFFF');

        $tipo_id->enableSearch();
        $plano_id->enableSearch();
        $relevancia_id->enableSearch();

        $kanba->setAction(new TAction(['TarefaKanbanView', 'onShow'], $param));
        $button_buscar->setAction(new TAction(['KanbanForm', 'onShow']), "Buscar");
        $button_nova_tarefa->setAction(new TAction(['TarefaForm', 'onShow'],["origem_registro_tarefa" => "kanban"]), "Nova Tarefa");

        $tipo_id->setValue($param['tipo_id'] ?? null);
        $plano_id->setValue($param['plano_id'] ?? null);
        $conclusao_fim->setValue($param['conclusao_fim'] ?? null);
        $relevancia_id->setValue($param['relevancia_id'] ?? null);
        $conclusao_inicio->setValue($param['conclusao_inicio'] ?? null);

        $kanba->setSize('100%');
        $tipo_id->setSize('100%');
        $plano_id->setSize('100%');
        $conclusao_fim->setSize('40%');
        $relevancia_id->setSize('100%');
        $conclusao_inicio->setSize('40%');

        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $kanba->add($loadingContainer);

        $this->kanba = $kanba;

        $row1 = $this->form->addFields([new TLabel("Data Conclusão:", null, '14px', null, '100%'),$conclusao_inicio,new TLabel(" até ", null, '14px', null),$conclusao_fim],[new TLabel("Tipo:", null, '14px', null),$tipo_id],[new TLabel("Relevancia:", null, '14px', null),$relevancia_id],[new TLabel("Plano:", null, '14px', null),$plano_id],[new TLabel(" ", null, '16px', 'B', '100%'),$button_buscar]);
        $row1->layout = ['col-sm-4','col-sm-2','col-sm-2',' col-sm-2','col-sm-2'];

        $row2 = $this->form->addFields([$kanba]);
        $row2->layout = [' col-sm-12'];

        $row3 = $this->form->addFields([$button_nova_tarefa],[],[]);
        $row3->layout = ['col-sm-3','col-sm-3','col-sm-6'];

        // create the form actions

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Organização","Kanban"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onShow($param = null)
    {               

    } 

}

