<?php

class ClienteForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'portal';
    private static $activeRecord = 'Cliente';
    private static $primaryKey = 'id';
    private static $formName = 'form_ClienteForm';

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
        $this->form->setFormTitle("Cadastro de cliente");


        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $email = new TEntry('email');
        $telefone = new TEntry('telefone');
        $cliente_usuario_cliente_id = new THidden('cliente_usuario_cliente_id[]');
        $cliente_usuario_cliente___row__id = new THidden('cliente_usuario_cliente___row__id[]');
        $cliente_usuario_cliente___row__data = new THidden('cliente_usuario_cliente___row__data[]');
        $cliente_usuario_cliente_system_user_id = new TDBCombo('cliente_usuario_cliente_system_user_id[]', 'permission', 'SystemUsers', 'id', '{name}','name asc'  );
        $cliente_usuario_cliente_ativo = new TCombo('cliente_usuario_cliente_ativo[]');
        $this->fieldList_63e5820e28e7c = new TFieldList();

        $this->fieldList_63e5820e28e7c->addField(null, $cliente_usuario_cliente_id, []);
        $this->fieldList_63e5820e28e7c->addField(null, $cliente_usuario_cliente___row__id, ['uniqid' => true]);
        $this->fieldList_63e5820e28e7c->addField(null, $cliente_usuario_cliente___row__data, []);
        $this->fieldList_63e5820e28e7c->addField(new TLabel("Usuário do sistema", null, '14px', null), $cliente_usuario_cliente_system_user_id, ['width' => '50%']);
        $this->fieldList_63e5820e28e7c->addField(new TLabel("Ativo", null, '14px', null), $cliente_usuario_cliente_ativo, ['width' => '50%']);

        $this->fieldList_63e5820e28e7c->width = '100%';
        $this->fieldList_63e5820e28e7c->setFieldPrefix('cliente_usuario_cliente');
        $this->fieldList_63e5820e28e7c->name = 'fieldList_63e5820e28e7c';

        $this->criteria_fieldList_63e5820e28e7c = new TCriteria();
        $this->default_item_fieldList_63e5820e28e7c = new stdClass();

        $this->form->addField($cliente_usuario_cliente_id);
        $this->form->addField($cliente_usuario_cliente___row__id);
        $this->form->addField($cliente_usuario_cliente___row__data);
        $this->form->addField($cliente_usuario_cliente_system_user_id);
        $this->form->addField($cliente_usuario_cliente_ativo);

        $this->fieldList_63e5820e28e7c->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $nome->addValidation("Nome", new TRequiredValidator()); 

        $id->setEditable(false);
        $cliente_usuario_cliente_ativo->addItems(["T"=>"Sim","F"=>"Não"]);
        $cliente_usuario_cliente_ativo->enableSearch();
        $cliente_usuario_cliente_system_user_id->enableSearch();

        $id->setSize(100);
        $nome->setSize('100%');
        $email->setSize('100%');
        $telefone->setSize('100%');
        $cliente_usuario_cliente_ativo->setSize('100%');
        $cliente_usuario_cliente_system_user_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Nome:", '#F44336', '14px', null, '100%'),$nome]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Email:", null, '14px', null, '100%'),$email],[new TLabel("Telefone:", null, '14px', null, '100%'),$telefone]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addContent([new TFormSeparator("Usuários", '#333333', '18', '#eee')]);
        $row4 = $this->form->addFields([$this->fieldList_63e5820e28e7c]);
        $row4->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['ClienteHeaderList', 'onShow']), 'fas:arrow-left #000000');
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

            $object = new Cliente(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            $cliente_usuario_cliente_items = $this->storeItems('ClienteUsuario', 'cliente_id', $object, $this->fieldList_63e5820e28e7c, function($masterObject, $detailObject){ 

                //code here

            }, $this->criteria_fieldList_63e5820e28e7c); 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('ClienteHeaderList', 'onShow', $loadPageParam); 

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

                $object = new Cliente($key); // instantiates the Active Record 

                $this->fieldList_63e5820e28e7c_items = $this->loadItems('ClienteUsuario', 'cliente_id', $object, $this->fieldList_63e5820e28e7c, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldList_63e5820e28e7c); 

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

        $this->fieldList_63e5820e28e7c->addHeader();
        $this->fieldList_63e5820e28e7c->addDetail($this->default_item_fieldList_63e5820e28e7c);

        $this->fieldList_63e5820e28e7c->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    }

    public function onShow($param = null)
    {
        $this->fieldList_63e5820e28e7c->addHeader();
        $this->fieldList_63e5820e28e7c->addDetail($this->default_item_fieldList_63e5820e28e7c);

        $this->fieldList_63e5820e28e7c->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

