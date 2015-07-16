<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmailTemplate
 *
 * @author vlad
 */
class CEmailComponent {

    protected static $_include_path;

    public static function getTemplate($name) {

        self::$_include_path = $_SERVER['PWD'] . '/templates/';
        $templName = self::$_include_path . $name . '.html';

        if (!file_exists($templName))
            throw new Exception('Файл ' . $templName . ' не найден!' . "\r\n", '401');

        $content = file_get_contents($templName);

        return $content;
    }

    public static function getTemplateParams($name) {

        self::$_include_path = $_SERVER['PWD'] . '/templates_params/';
        $templName = self::$_include_path . $name . '.php';
        $result = array();

        if (!file_exists($templName)) {
            include $templName;

            if (isset($params) || !is_array($params))
                $result = $params;
            
        }

        return $result;
    }
   
}
