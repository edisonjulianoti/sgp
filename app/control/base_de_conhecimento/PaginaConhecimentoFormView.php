<?php

class PaginaConhecimentoFormView extends TPage
{
    protected $form; // form
    private static $database = 'portal';
    private static $activeRecord = 'PaginaConhecimento';
    private static $primaryKey = 'id';
    private static $formName = 'formView_PaginaConhecimento';

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

        TTransaction::open(self::$database);
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        $this->form->setTagName('div');

        $pagina_conhecimento = new PaginaConhecimento($param['key']);
        // define the form title
        $this->form->setFormTitle("{$pagina_conhecimento->titulo}");

        $conteudo = new BElement('div');

        $conteudo->width = '100%';
        $conteudo->height = '80px';

        $this->conteudo = $conteudo;

        $conteudo->add($pagina_conhecimento->conteudo);

        $row1 = $this->form->addFields([$conteudo]);
        $row1->layout = [' col-sm-12'];

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        TTransaction::close();
        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=PaginaConhecimentoFormView]');
        $style->width = '70% !important';   
        $style->show(true);

    }

    public function onShow($param = null)
    {     

    }

}

