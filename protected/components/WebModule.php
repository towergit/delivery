<?php

/**
 * Модуль
 *
 * @category Module
 * @package  Modules
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class WebModule extends CWebModule
{
    /**
     * Инициализация модуля
     */
    public function init()
    {
        parent::init();
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return '';
    }

    /**
     * Получение автора модуля
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('yii', 'Команда Crystal-IT');
    }

    /**
     * Получение URL сайта
     * @return string
     */
    public function getUrl()
    {
        return Yii::t('yii', 'http://crystal-it.biz');
    }

    /**
     * Получение зависимости
     * Массив с именами модулей, от которых зависит работа данного модуля
     * @return array
     */
    public function getDependencies()
    {
        return array();
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array();
    }

    /**
     * Срабатывает перед загрузкой экшена контроллера
     * @param string $controller
     * @param string $action
     * @return boolean
     */
    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action))
            return true;
        else
            return false;
    }

}

