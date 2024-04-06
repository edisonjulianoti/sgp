<?php

class GuiaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'portal';
    private static $activeRecord = 'Guia';
    private static $primaryKey = 'id';
    private static $formName = 'form_GuiaForm';

    use Adianti\Base\AdiantiFileSaveTrait;

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
        $this->form->setFormTitle("Cadastro de guia");


        $id = new TEntry('id');
        $cliente_id = new TDBUniqueSearch('cliente_id', 'portal', 'Cliente', 'id', 'nome','nome asc'  );
        $mes_competencia = new TCombo('mes_competencia');
        $ano_competencia = new TCombo('ano_competencia');
        $data_vencimento = new TDate('data_vencimento');
        $download_pos_vencimento = new TCombo('download_pos_vencimento');
        $subcategoria_guia_categoria_guia_id = new TDBCombo('subcategoria_guia_categoria_guia_id', 'portal', 'CategoriaGuia', 'id', '{nome}','nome asc'  );
        $subcategoria_guia_id = new TCombo('subcategoria_guia_id');
        $arquivo = new TFile('arquivo');

        $subcategoria_guia_categoria_guia_id->setChangeAction(new TAction([$this,'onChangesubcategoria_guia_categoria_guia_id']));

        $cliente_id->addValidation("Cliente", new TRequiredValidator()); 
        $mes_competencia->addValidation("Mês de competência", new TRequiredValidator()); 
        $ano_competencia->addValidation("Ano de competência", new TRequiredValidator()); 
        $data_vencimento->addValidation("Data de vencimento", new TRequiredValidator()); 
        $download_pos_vencimento->addValidation("Permite download após o vencimento?", new TRequiredValidator()); 
        $subcategoria_guia_categoria_guia_id->addValidation("Categoria", new TRequiredValidator()); 
        $subcategoria_guia_id->addValidation("Subcategoria", new TRequiredValidator()); 
        $arquivo->addValidation("Arquivo", new TRequiredValidator()); 

        $id->setEditable(false);
        $cliente_id->setMinLength(0);
        $data_vencimento->setDatabaseMask('yyyy-mm-dd');
        $download_pos_vencimento->setValue('F');
        $arquivo->enableFileHandling();
        $cliente_id->setMask('{nome}');
        $data_vencimento->setMask('dd/mm/yyyy');

        $ano_competencia->addItems(TempoService::getAnos());
        $mes_competencia->addItems(TempoService::getMeses());
        $download_pos_vencimento->addItems(["T"=>"Sim","F"=>"Não"]);

        $mes_competencia->enableSearch();
        $ano_competencia->enableSearch();
        $subcategoria_guia_id->enableSearch();
        $download_pos_vencimento->enableSearch();
        $subcategoria_guia_categoria_guia_id->enableSearch();

        $id->setSize(100);
        $arquivo->setSize('100%');
        $cliente_id->setSize('100%');
        $mes_competencia->setSize('100%');
        $ano_competencia->setSize('100%');
        $data_vencimento->setSize('100%');
        $subcategoria_guia_id->setSize('100%');
        $download_pos_vencimento->setSize('100%');
        $subcategoria_guia_categoria_guia_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id]);
        $row1->layout = ['col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Cliente:", '#ff0000', '14px', null, '100%'),$cliente_id]);
        $row2->layout = [' col-sm-12'];

        $row3 = $this->form->addFields([new TLabel("Mês de competência:", '#ff0000', '14px', null, '100%'),$mes_competencia],[new TLabel("Ano de competência:", '#ff0000', '14px', null, '100%'),$ano_competencia]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Data de vencimento:", '#ff0000', '14px', null, '100%'),$data_vencimento],[new TLabel("Permite download após o vencimento?", '#ff0000', '14px', null, '100%'),$download_pos_vencimento]);
        $row4->layout = ['col-sm-6','col-sm-6'];

        $row5 = $this->form->addContent([new TFormSeparator("", '#333', '18', '#eee')]);
        $row6 = $this->form->addFields([new TLabel("Categoria:", '#FF0000', '14px', null, '100%'),$subcategoria_guia_categoria_guia_id],[new TLabel("Subcategoria:", '#ff0000', '14px', null, '100%'),$subcategoria_guia_id]);
        $row6->layout = ['col-sm-6','col-sm-6'];

        $row7 = $this->form->addFields([new TLabel("Arquivo:", '#ff0000', '14px', null, '100%'),$arquivo]);
        $row7->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['GuiaList', 'onShow']), 'fas:arrow-left #000000');
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

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Guia(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $arquivo_dir = 'app/guias_clientes';  

            if(!$data->id)
            {
                $object->created_by_system_user_id = TSession::getValue('userid');
            }

            $object->store(); // save the object 

            $this->fireEvents($object);

            $this->saveFile($object, $data, 'arquivo', $arquivo_dir);
            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            if(!$data->id && $object->cliente->email)
            {
                $templateEmail = TemplateEmailService::parseTemplate(TemplateEmail::NOVA_GUIA, $object);
                FilaEmailService::adicionaNaFila([$object->cliente->email], $templateEmail->titulo, $templateEmail->conteudo, 'Nova Guia');
            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('GuiaList', 'onShow', $loadPageParam); 

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

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Guia($key); // instantiates the Active Record 

                                $object->subcategoria_guia_categoria_guia_id = $object->subcategoria_guia->categoria_guia_id;

                $this->form->setData($object); // fill the form 

                $this->fireEvents($object);

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

    public static function getFormName()
    {
        return self::$formName;
    }

}

