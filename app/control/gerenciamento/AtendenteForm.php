<?php

class AtendenteForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'portal';
    private static $activeRecord = 'Atendente';
    private static $primaryKey = 'id';
    private static $formName = 'form_AtendenteForm';

    use BuilderMasterDetailFieldListTrait;

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
        $this->form->setFormTitle("Cadastro de atendente");


        $id = new TEntry('id');
        $system_user_id = new TDBCombo('system_user_id', 'permission', 'SystemUsers', 'id', '{name}','name asc'  );
        $setor_atendente_atendente_id = new THidden('setor_atendente_atendente_id[]');
        $setor_atendente_atendente___row__id = new THidden('setor_atendente_atendente___row__id[]');
        $setor_atendente_atendente___row__data = new THidden('setor_atendente_atendente___row__data[]');
        $setor_atendente_atendente_setor_id = new TDBCombo('setor_atendente_atendente_setor_id[]', 'portal', 'Setor', 'id', '{nome}','nome asc'  );
        $this->fieldList_63e5828a28e82 = new TFieldList();

        $this->fieldList_63e5828a28e82->addField(null, $setor_atendente_atendente_id, []);
        $this->fieldList_63e5828a28e82->addField(null, $setor_atendente_atendente___row__id, ['uniqid' => true]);
        $this->fieldList_63e5828a28e82->addField(null, $setor_atendente_atendente___row__data, []);
        $this->fieldList_63e5828a28e82->addField(new TLabel("Setor", null, '14px', null), $setor_atendente_atendente_setor_id, ['width' => '100%']);

        $this->fieldList_63e5828a28e82->width = '100%';
        $this->fieldList_63e5828a28e82->setFieldPrefix('setor_atendente_atendente');
        $this->fieldList_63e5828a28e82->name = 'fieldList_63e5828a28e82';

        $this->criteria_fieldList_63e5828a28e82 = new TCriteria();
        $this->default_item_fieldList_63e5828a28e82 = new stdClass();

        $this->form->addField($setor_atendente_atendente_id);
        $this->form->addField($setor_atendente_atendente___row__id);
        $this->form->addField($setor_atendente_atendente___row__data);
        $this->form->addField($setor_atendente_atendente_setor_id);

        $this->fieldList_63e5828a28e82->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $system_user_id->addValidation("Usuário", new TRequiredValidator()); 
        $setor_atendente_atendente_setor_id->addValidation("Setor", new TRequiredListValidator()); 

        $id->setEditable(false);
        $system_user_id->enableSearch();
        $setor_atendente_atendente_setor_id->enableSearch();

        $id->setSize(100);
        $system_user_id->setSize('100%');
        $setor_atendente_atendente_setor_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Usuário:", '#F44336', '14px', null, '100%'),$system_user_id]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addContent([new TFormSeparator("Setores", '#FE9202', '18', '#eee')]);
        $row3 = $this->form->addFields([$this->fieldList_63e5828a28e82]);
        $row3->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['AtendenteHeaderList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Atendente(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            $setor_atendente_atendente_items = $this->storeItems('SetorAtendente', 'atendente_id', $object, $this->fieldList_63e5828a28e82, function($masterObject, $detailObject){ 

                //code here

            }, $this->criteria_fieldList_63e5828a28e82); 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('AtendenteHeaderList', 'onShow', $loadPageParam); 

                        TScript::create("Template.closeRightPanel();");
            TForm::sendData(self::$formName, (object)['id' => $object->id]);

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
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

                $object = new Atendente($key); // instantiates the Active Record 

                $this->fieldList_63e5828a28e82_items = $this->loadItems('SetorAtendente', 'atendente_id', $object, $this->fieldList_63e5828a28e82, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldList_63e5828a28e82); 

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

        $this->fieldList_63e5828a28e82->addHeader();
        $this->fieldList_63e5828a28e82->addDetail($this->default_item_fieldList_63e5828a28e82);

        $this->fieldList_63e5828a28e82->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    }

    public function onShow($param = null)
    {
        $this->fieldList_63e5828a28e82->addHeader();
        $this->fieldList_63e5828a28e82->addDetail($this->default_item_fieldList_63e5828a28e82);

        $this->fieldList_63e5828a28e82->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

