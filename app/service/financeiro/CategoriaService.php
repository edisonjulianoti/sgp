<?php

class CategoriaService
{
    public static function salvarCategoriasPadrao($userid){
      
     
      
      
      if(empty($userid)){
          
          return false;
      }
      
     
      $qtd_categorias = Categoria::where('system_users_id', '=', $userid)->count();
      
      if($qtd_categorias > 0){
          
          return false;
      }
      
      
      
      $categorias = Categoria::getCategoriasPadrao();
      
     
      
     
      foreach($categorias as $key => $array_categoria) {
         
            $objcategoria = new Categoria();
            
            $objcategoria->descricao                        = $array_categoria[0];
            $objcategoria->tipo_categoria_id                = $array_categoria[1];
            $objcategoria->totaliza_receita_despesa_id      = $array_categoria[2];
            $objcategoria->system_users_id                  = $userid;
            
            $objcategoria->store();
            
           
           
     }
     
     return true;
      
  }
}
