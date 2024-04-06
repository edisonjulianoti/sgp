<?php

class AgendamentoCalendarForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'bd_sgp';
    private static $activeRecord = 'Agendamento';
    private static $primaryKey = 'id';
    private static $formName = 'form_AgendamentoCalendarForm';
    private static $startDateField = 'data_inicio';
    private static $endDateField = 'data_fim';

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
        $this->form->setFormTitle("Agendamento");

        $view = new THidden('view');

        $criteria_plano_id = new TCriteria();

        $filterVar = TSession::getValue("userid");
        $criteria_plano_id->add(new TFilter('system_users_id', '=', $filterVar)); 

        $titulo = new TEntry('titulo');
        $data_inicio = new TDateTime('data_inicio');
        $data_fim = new TDateTime('data_fim');
        $plano_id = new TDBCombo('plano_id', 'bd_sgp', 'Plano', 'id', '{descricao}','descricao asc' , $criteria_plano_id );
        $descricao = new TText('descricao');
        $relevancia_id = new TDBCombo('relevancia_id', 'bd_sgp', 'Relevancia', 'id', '{descricao}','descricao asc'  );
        $tipo_id = new TDBCombo('tipo_id', 'bd_sgp', 'Tipo', 'id', '{descricao}','id asc'  );
        $recorrencia_id = new TDBCombo('recorrencia_id', 'bd_sgp', 'Recorrencia', 'id', '{descricao}','id asc'  );
        $limite_recorrencia = new TDate('limite_recorrencia');
        $considera_final_semana_id = new TDBCombo('considera_final_semana_id', 'bd_sgp', 'ConsideraFinalSemana', 'id', '{descricao}','descricao asc'  );
        $lembrete_agenda_id = new TDBCombo('lembrete_agenda_id', 'bd_sgp', 'LembreteAgenda', 'id', '{descricao}','id asc'  );
        $id = new TEntry('id');
        $agenda_id = new TEntry('agenda_id');

        $titulo->addValidation("Titulo", new TRequiredValidator()); 
        $data_inicio->addValidation("Inicio", new TRequiredValidator()); 
        $data_fim->addValidation("Fim", new TRequiredValidator()); 
        $descricao->addValidation("Descrição", new TRequiredValidator()); 
        $relevancia_id->addValidation("Relevância", new TRequiredValidator()); 
        $recorrencia_id->addValidation("Recorrencia id", new TRequiredValidator()); 

        $titulo->setMaxLength(200);
        $id->setEditable(false);
        $agenda_id->setEditable(false);

        $data_fim->setMask('dd/mm/yyyy hh:ii');
        $data_inicio->setMask('dd/mm/yyyy hh:ii');
        $limite_recorrencia->setMask('dd/mm/yyyy');

        $data_fim->setDatabaseMask('yyyy-mm-dd hh:ii');
        $data_inicio->setDatabaseMask('yyyy-mm-dd hh:ii');
        $limite_recorrencia->setDatabaseMask('yyyy-mm-dd');

        $tipo_id->enableSearch();
        $plano_id->enableSearch();
        $relevancia_id->enableSearch();
        $recorrencia_id->enableSearch();
        $lembrete_agenda_id->enableSearch();
        $considera_final_semana_id->enableSearch();

        $id->setSize(100);
        $titulo->setSize('100%');
        $tipo_id->setSize('100%');
        $data_fim->setSize('100%');
        $plano_id->setSize('100%');
        $agenda_id->setSize('100%');
        $data_inicio->setSize('100%');
        $descricao->setSize('100%', 70);
        $relevancia_id->setSize('100%');
        $recorrencia_id->setSize('100%');
        $limite_recorrencia->setSize('100%');
        $lembrete_agenda_id->setSize('100%');
        $considera_final_semana_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Titulo:", '#607D8B', '14px', 'B', '100%'),$titulo],[new TLabel("Inicio:", '#607D8B', '14px', 'B', '100%'),$data_inicio],[new TLabel("Fim:", '#607D8B', '14px', 'B', '100%'),$data_fim],[new TLabel("Plano:", '#607D8B', '14px', 'B', '100%'),$plano_id]);
        $row1->layout = [' col-sm-4',' col-sm-2',' col-sm-2',' col-sm-4'];

        $row2 = $this->form->addFields([new TLabel("Descrição:", '#607D8B', '14px', 'B', '100%'),$descricao]);
        $row2->layout = [' col-sm-12'];

        $row3 = $this->form->addFields([new TLabel("Relevância:", '#607D8B', '14px', 'B', '100%'),$relevancia_id],[new TLabel("Tipo:", '#607D8B', '14px', 'B', '100%'),$tipo_id],[new TLabel("Recorrência:", '#607D8B', '14px', 'B', '100%'),$recorrencia_id],[new TLabel("Limite Recorrência:", '#607D8B', '14px', 'B', '100%'),$limite_recorrencia],[new TLabel("Considera final semana:", '#607D8B', '14px', 'B', '100%'),$considera_final_semana_id],[new TLabel("Lembrete agenda:", '#607D8B', '14px', 'B', '100%'),$lembrete_agenda_id]);
        $row3->layout = [' col-sm-2','col-sm-2',' col-sm-2',' col-sm-2',' col-sm-2',' col-sm-2'];

        $row4 = $this->form->addFields([$id],[$agenda_id]);
        $row4->layout = ['col-sm-2','col-sm-2'];

        $this->form->addFields([$view]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_ondelete = $this->form->addAction("Excluir", new TAction([$this, 'onDelete']), 'fas:trash-alt #dd5a43');
        $this->btn_ondelete = $btn_ondelete;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=AgendamentoCalendarForm]');
        $style->width = '90% !important';   
        $style->show(true);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Agendamento(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->system_users_id =  TSession::getValue('userid');

            AgendamentoService::validarRecorrencia($object);

            $object->store(); // save the object 

            AgendamentoService::geraRecorrencia($object);

            $messageAction = new TAction(['AgendamentoCalendarFormView', 'onReload']);
            $messageAction->setParameter('view', $data->view);
            $messageAction->setParameter('date', explode(' ', $data->data_inicio)[0]);

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

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
    public function onDelete($param = null) 
    {
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                $key = $param[self::$primaryKey];

                // open a transaction with database
                TTransaction::open(self::$database);

                $class = self::$activeRecord;

                // instantiates object
                $object = new $class($key, FALSE);

                AgendamentoService::deletarAgendamentoFilho($object);

                // deletes the object from the database
                $object->delete();

                // close the transaction
                TTransaction::close();

                $messageAction = new TAction(array(__CLASS__.'View', 'onReload'));
                $messageAction->setParameter('view', $param['view']);
                $messageAction->setParameter('date', explode(' ',$param[self::$startDateField])[0]);

                // shows the success message
                new TMessage('info', AdiantiCoreTranslator::translate('Record deleted'), $messageAction);
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
            $action->setParameters((array) $this->form->getData());
            $action->setParameter('delete', 1);
            // shows a dialog to the user
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
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

                $object = new Agendamento($key); // instantiates the Active Record 

                                $object->view = !empty($param['view']) ? $param['view'] : 'agendaWeek'; 

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

    } 

    public function onStartEdit($param)
    {

        $this->form->clear(true);

        $data = new stdClass;
        $data->view = $param['view'] ?? 'agendaWeek'; // calendar view
        $data->relevancia = new stdClass();
        $data->relevancia->cor = '#3a87ad';

        if (!empty($param['date']))
        {
            if(strlen($param['date']) == '10')
                $param['date'].= ' 09:00';

            $data->data_inicio = str_replace('T', ' ', $param['date']);

            $data_fim = new DateTime($data->data_inicio);
            $data_fim->add(new DateInterval('PT1H'));
            $data->data_fim = $data_fim->format('Y-m-d H:i:s');

        }

        $this->form->setData( $data );
    }

    public static function onUpdateEvent($param)
    {
        try
        {
            if (isset($param['id']))
            {
                TTransaction::open(self::$database);

                $class = self::$activeRecord;
                $object = new $class($param['id']);

                $object->data_inicio = str_replace('T', ' ', $param['start_time']);
                $object->data_fim   = str_replace('T', ' ', $param['end_time']);

                $object->store();

                // close the transaction
                TTransaction::close();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', '<b>Error</b> ' . $e->getMessage());
            TTransaction::rollback();
        }
    }

    public static function getFormName()
    {
        return self::$formName;
    }

}

