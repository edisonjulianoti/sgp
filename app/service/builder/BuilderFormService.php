<?php

use Adianti\Widget\Base\TScript;

class BuilderFormService
{
    public static function showTab()
    {
        TScript::create('$(`.nav-item a:contains(${tab_name})`).closest("li").show();');
    }

    public static function hideTab()
    {
        TScript::create('$(`.nav-item a:contains(${tab_name})`).closest("li").hide();');
    }

    public static function showFieldColumn($formName, $fieldName)
    {
        TScript::create('$(`[name="'.$formName.'"][name="'.$fieldName.'"]`).closest(".fb-field-container").show();');
    }
    
    public static function hideFieldColumn($formName, $fieldName)
    {
        TScript::create('$(`[name="'.$formName.'"][name="'.$fieldName.'"]`).closest(".fb-field-container").hide();');
    }
    
    public static function showFieldRow($formName, $fieldName)
    {
        TScript::create('$(`[name="'.$formName.'"][name="'.$fieldName.'"]`).closest(".tformrow").show();');
    }

    public static function hideFieldRow($formName, $fieldName)
    {
        TScript::create('$(`[name="'.$formName.'"][name="'.$fieldName.'"]`).closest(".tformrow").hide();');
    }
}