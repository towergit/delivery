<?php

/**
 * Блок контента
 *
 * @category Module
 * @package  Module.Contentblock
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ContentblockModule extends WebModule
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
            'contentblock.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('contentblock', 'Блоки контента');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('contentblock', 'Управление блоками контента');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('contentblock', 'Beta 1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-th-large';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('contentblock', 'Блоки контента'),
                'icon'    => $this->icon,
                'url'     => array( '/contentblock/contentblock/index' ),
                'visible' => Yii::app()->user->checkAccess('showContentblock'),
            ),
        );
    }
}

