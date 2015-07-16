<?php

/**
 * Управление модулями
 *
 * @category Module
 * @package  Module.Module
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ModuleModule extends WebModule
{
    /**
     * Инициализация модуля
     * setImport - импортирует при запуске любого контроллера этого модуля
     * setComponents - импортирует компоненты
     */
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'module.components.*',
            'module.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('module', 'Модули');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('module', 'Управление модулями');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('module', 'Beta 1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-th';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('module', 'Модули'),
                'icon'    => $this->icon,
                'url'     => array( '/module/module/index' ),
                //'visible' => Yii::app()->user->checkAccess('showModule'),
            ),
        );
    }

}

