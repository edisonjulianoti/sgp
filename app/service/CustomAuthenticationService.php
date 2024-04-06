<?php

class CustomAuthenticationService
{
    public static function authenticate($login, $password)
    {
        $user = SystemUsers::authenticate( $login, $password );
        
        
        TTransaction::open('portal');
        
        $clienteUsuario = ClienteUsuario::where('ativo', '=', 'T')->where('system_user_id', '=', $user->id)->first();
        
        TSession::setValue('cliente_id', -1);
        TSession::setValue('cliente_usuario_id', -1);
        if($clienteUsuario)
        {
            TSession::setValue('cliente_id', $clienteUsuario->cliente_id);
            TSession::setValue('cliente_usuario_id', $clienteUsuario->id);
        }
        
        TSession::setValue('setores_atendente', [-1]);
        TSession::setValue('atendente_id', -1);
        
        $atendente = Atendente::where('system_user_id', '=', $user->id)->first();
        
        if($atendente)
        {
            $criteria = new TCriteria();
            $criteria->add(new TFilter('atendente_id', '=', $atendente->id));
            
            $setores_atendente = SetorAtendente::getIndexedArray('setor_id', 'setor_id', $criteria);
            
            if($setores_atendente)
            {
                TSession::setValue('setores_atendente', $setores_atendente);
            }
            
            TSession::setValue('atendente_id', $atendente->id);
        }
        
        TTransaction::close();
    }
}
