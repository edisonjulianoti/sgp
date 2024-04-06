<?php

class AtendimentoFormView extends TPage
{
    protected $form; // form
    private static $database = 'portal';
    private static $activeRecord = 'Atendimento';
    private static $primaryKey = 'id';
    private static $formName = 'formView_Atendimento';

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

        $atendimento = new Atendimento($param['key']);
        // define the form title
        $this->form->setFormTitle("Consulta de atendimento");

        $transformed_atendimento_arquivos = call_user_func(function($value, $object, $row) 
        {
            $value = explode(',', $value);
            if(count($value) == 0)
            {
                $value = $value[0];
            }

            if(is_array($value))
            {
                $files = $value;
                $divFiles = new TElement('div');
                foreach($files as $file)
                {
                    $fileName = $file;
                    if (strpos($file, '%7B') !== false) 
                    {
                        if (!empty($file)) 
                        {
                            $fileObject = json_decode(urldecode($file));

                            $fileName = $fileObject->fileName;
                        }
                    }

                    $a = new TElement('a');
                    $a->href = "download.php?file={$fileName}";
                    $a->class = 'btn btn-link';
                    $a->add($fileName);
                    $a->target = '_blank';

                    $divFiles->add($a);

                }

                return $divFiles;
            }
            else
            {
                if (strpos($value, '%7B') !== false) 
                {
                    if (!empty($value)) 
                    {
                        $value_object = json_decode(urldecode($value));
                        $value = $value_object->fileName;
                    }
                }

                if($value)
                {
                    $a = new TElement('a');
                    $a->href = "download.php?file={$value}";
                    $a->class = 'btn btn-default';
                    $a->add($value);
                    $a->target = '_blank';

                    return $a;
                }

                return $value;
            }
        }, $atendimento->arquivos, $atendimento, null);    

        $transformed_atendimento_mensagem = call_user_func(function($value, $object, $row)
        {

            return nl2br($value);

        }, $atendimento->mensagem, $atendimento, null);

        $label2 = new TLabel("Código do atendimento:", '', '14px', 'B', '100%');
        $text1 = new TTextDisplay($atendimento->id, '', '16px', '');
        $label4 = new TLabel("Data de abertura:", '', '14px', 'B', '100%');
        $text8 = new TTextDisplay(TDateTime::convertToMask($atendimento->data_abertura, 'yyyy-mm-dd hh:ii', 'dd/mm/yyyy hh:ii'), '', '16px', '');
        $label6 = new TLabel("Data de fechamento:", '', '14px', 'B', '100%');
        $text9 = new TTextDisplay(TDateTime::convertToMask($atendimento->data_fechamento, 'yyyy-mm-dd hh:ii', 'dd/mm/yyyy hh:ii'), '', '16px', '');
        $label8 = new TLabel("Setor:", '', '14px', 'B', '100%');
        $text3 = new TTextDisplay($atendimento->setor->nome, '', '16px', '');
        $label10 = new TLabel("Tipo atendimento:", '', '14px', 'B', '100%');
        $text2 = new TTextDisplay($atendimento->tipo_atendimento->nome, '', '16px', '');
        $label12 = new TLabel("Atendente:", '', '14px', 'B', '100%');
        $text6 = new TTextDisplay($atendimento->atendente->system_user->name, '', '16px', '');
        $label14 = new TLabel("Solicitante:", '', '14px', 'B', '100%');
        $text5 = new TTextDisplay($atendimento->cliente_usuario->system_user->name, '', '16px', '');
        $label_cliente = new TLabel("Cliente:", '', '14px', 'B', '100%');
        $cliente = new TTextDisplay($atendimento->cliente->nome, '', '16px', '');
        $label16 = new TLabel("Arquivos:", '', '14px', 'B', '100%');
        $text7 = new TTextDisplay($transformed_atendimento_arquivos, '', '16px', '');
        $label18 = new TLabel("Mensagem:", '', '14px', 'B', '100%');
        $text10 = new TTextDisplay($transformed_atendimento_mensagem, '', '16px', '');
        $btnNovaInteracao = new TActionLink("Nova Interação", new TAction(['AtendimentoInteracaoForm', 'onShow'], ['atendimento_id'=> $atendimento->id]), '', '13px', '', 'fas:comment-medical #FF9800');
        $interacoes = new BPageContainer();

        $interacoes->setSize('100%');
        $interacoes->setAction(new TAction(['AtendimentoInteracaoTimeLine', 'onShow'], ['atendimento_id' => $atendimento->id]));
        $interacoes->setId('interacoes');

        $btnNovaInteracao->class = 'btn btn-default';

        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $interacoes->add($loadingContainer);


        if($atendimento->data_fechamento)
        {
           $btnNovaInteracao->hide(); 
        }

        $row1 = $this->form->addFields([$label2,$text1],[$label4,$text8],[$label6,$text9]);
        $row1->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row2 = $this->form->addFields([$label8,$text3],[$label10,$text2],[$label12,$text6]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $this->form->addFields([$label14,$text5],[$label_cliente,$cliente]);
        $row3->layout = [' col-sm-4',' col-sm-8'];

        $row4 = $this->form->addFields([$label16,$text7]);
        $row4->layout = [' col-sm-12'];

        $row5 = $this->form->addFields([$label18,$text10]);
        $row5->layout = [' col-sm-12'];

        $row6 = $this->form->addContent([new TFormSeparator("Interações do Atendimento", '#333', '18', '#eee')]);
        $row7 = $this->form->addFields([$btnNovaInteracao]);
        $row7->layout = [' col-sm-12'];

        $row8 = $this->form->addFields([$interacoes]);
        $row8->layout = [' col-sm-12'];

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

        $style = new TStyle('right-panel > .container-part[page-name=AtendimentoFormView]');
        $style->width = '80% !important';   
        $style->show(true);

    }

    public function onShow($param = null)
    {     

    }

}

