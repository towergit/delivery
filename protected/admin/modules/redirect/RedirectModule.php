<?php

/**
 * Управление переадресациями
 *
 * @category Module
 * @package  Module.Redirect
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class RedirectModule extends WebModule
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
            'redirect.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('redirect', 'Переадресации');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('redirect', 'Управление переадресациями');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('redirect', 'Beta: 1.0');
    }

    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-reply';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('redirect', 'Переадресации'),
                'icon'    => $this->icon,
                'url'     => array( '/redirect/redirect/index' ),
                'visible' => Yii::app()->user->checkAccess('showRedirect'),
            ),
        );
    }

}

