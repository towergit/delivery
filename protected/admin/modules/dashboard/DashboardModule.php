<?php

/**
 * Управление рабочим столом
 *
 * @category Module
 * @package  Module.Dashboard
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class DashboardModule extends WebModule
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
            'dashboard.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('dashboard', 'Рабочий стол');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('dashboard', 'Управление рабочим столом');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('dashboard', 'Alpha 1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-desktop';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('dashboard', 'Рабочий стол'),
                'detail'  => Yii::t('dashboard', '12 новых обновлений'),
                'icon'    => $this->icon,
                'url'     => array( '/dashboard/dashboard/index' ),
                'visible' => Yii::app()->user->checkAccess('showDashboardMenu'),
            ),
        );
    }

}

