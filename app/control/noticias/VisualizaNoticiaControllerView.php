<?php

class VisualizaNoticiaControllerView extends TPage
{
    public function __construct($param)
    {
        try 
        {
            parent::__construct();
            
            TTransaction::open('portal');
        
            $noticia = Noticia::find($param['noticia_id']);
            
            if(!$noticia)
            {
                throw new Exception('Notícia não encontrada');
            }
            
            $noticiaArray = $noticia->toArray();
            $noticiaArray['data_noticia_br'] = $noticia->data_noticia_br;
            
            $html = new THtmlRenderer('app/resources/visualizaNoticiaControllerViewTemplate.html');
            $html->disableHtmlConversion();
            $html->enableSection('main', $noticiaArray);
            
            TTransaction::close();
            
            parent::add($html);
        } 
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    
    // função executa ao clicar no item de menu
    public function onShow($param = null)
    {
        
    }
}
