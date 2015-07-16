<?php

/**
 * Управление поиском
 *
 * @category Module
 * @package  Module.Search
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class SearchModule extends WebModule
{
    /**
     * Инициализация модуля
     * setImport - импортирует при запуске любого контроллера этого модуля
     */
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'search.models.*',
        ));
    }
    
    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('search', 'Поиск');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('search', 'Управление поиском');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('search', 'Alpha 1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-search';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('search', 'Поиск'),
                'icon'    => $this->icon,
                'url'     => array( '/search/search/index' ),
                'visible' => Yii::app()->user->checkAccess('showSearch'),
            ),
        );
    }

}

