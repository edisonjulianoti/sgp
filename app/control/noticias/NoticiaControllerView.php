<?php

class NoticiaControllerView extends TPage
{
    public function __construct($param)
    {
        try
        {
            parent::__construct();
            
            $html = new THtmlRenderer('app/resources/noticiaControllerViewTemplate.html');
            
            TTransaction::open('portal');
                
            $noticias = Noticia::where('ativo', '=', 'T')->orderBy('data_noticia', 'desc')->load();
            
            TTransaction::close();
            
            $replaces = [];
            
            if($noticias)
            {
                foreach($noticias as $noticia)
                {
                    $noticiaArray = $noticia->toArray();
                    $noticiaArray['data_noticia_br'] = $noticia->data_noticia_br;
                    
                    $replaces[] = $noticiaArray;
                }
            }
            
            
            $html->enableSection('main', []);
            $html->enableSection('noticias', $replaces, true);
            
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
