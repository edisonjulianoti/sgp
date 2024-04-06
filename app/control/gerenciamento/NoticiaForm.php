<?php

class NoticiaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'portal';
    private static $activeRecord = 'Noticia';
    private static $primaryKey = 'id';
    private static $formName = 'form_NoticiaForm';

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
        $this->form->setFormTitle("Cadastro de notícia");


        $id = new TEntry('id');
        $ativo = new TCombo('ativo');
        $titulo = new TEntry('titulo');
        $descricao_resumida = new TEntry('descricao_resumida');
        $foto_capa = new TFile('foto_capa');
        $data_noticia = new TDateTime('data_noticia');
        $conteudo = new THtmlEditor('conteudo');

        $ativo->addValidation("Ativo", new TRequiredValidator()); 
        $titulo->addValidation("Título", new TRequiredValidator()); 
        $foto_capa->addValidation("Foto capa", new TRequiredValidator()); 
        $data_noticia->addValidation("Data da notícia", new TRequiredValidator()); 
        $conteudo->addValidation("Conteudo", new TRequiredValidator()); 

        $id->setEditable(false);
        $ativo->addItems(["T"=>"Sim","F"=>"Não"]);
        $ativo->setValue('T');
        $ativo->setDefaultOption(false);
        $ativo->enableSearch();
        $foto_capa->enableFileHandling();
        $foto_capa->setAllowedExtensions(["png","jpg","jpeg","gif"]);
        $foto_capa->enableImageGallery('160', NULL);
        $data_noticia->setMask('dd/mm/yyyy hh:ii');
        $data_noticia->setDatabaseMask('yyyy-mm-dd hh:ii');
        $id->setSize(100);
        $ativo->setSize('100%');
        $titulo->setSize('100%');
        $foto_capa->setSize('100%');
        $data_noticia->setSize(150);
        $conteudo->setSize('100%', 250);
        $descricao_resumida->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Ativo:", '#ff0000', '14px', null, '100%'),$ativo]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Título:", '#ff0000', '14px', null, '100%'),$titulo],[new TLabel("Descrição resumida:", '#FF0000', '14px', null, '100%'),$descricao_resumida]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Foto capa:", '#ff0000', '14px', null, '100%'),$foto_capa],[new TLabel("Data da notícia:", '#ff0000', '14px', null, '100%'),$data_noticia]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Conteúdo:", '#ff0000', '14px', null, '100%'),$conteudo]);
        $row4->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['NoticiaHeaderList', 'onShow']), 'fas:arrow-left #000000');
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

            $object = new Noticia(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $foto_capa_dir = 'app/noticias/imagens';  

            if(!$data->id)
            {
                $object->created_by_system_user_id = TSession::getValue('userid');
            }

            $object->store(); // save the object 

            $this->saveFile($object, $data, 'foto_capa', $foto_capa_dir);
            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('NoticiaHeaderList', 'onShow', $loadPageParam); 

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

                $object = new Noticia($key); // instantiates the Active Record 

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

    public static function getFormName()
    {
        return self::$formName;
    }

}

