<?php

class LinkUtilControllerView extends TPage
{
    public function __construct($param)
    {
        parent::__construct();
        
        $html = new THtmlRenderer('app/resources/linkUtilControllerViewTemplate.html');
        
        TTransaction::open('portal');
        
        $links = LinkUtil::where('ativo', '=', 'T')->orderBy('criado_em', 'desc')->load();
        
        TTransaction::close();
        
        $replaces = [];
        
        if($links)
        {
            foreach($links as $link)
            {
                $replaces[] = $link->toArray();
            }
        }
        
        
        $html->enableSection('main', []);
        $html->enableSection('links', $replaces, true);
        
        parent::add($html);
        
    }
    
    // função executa ao clicar no item de menu
    public function onShow($param = null)
    {
        
    }
}
