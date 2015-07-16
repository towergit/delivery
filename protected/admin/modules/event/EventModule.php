<?php

/**
 * Управление событиями
 *
 * @category Module
 * @package  Module.Event
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class EventModule extends WebModule
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
            'event.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('event', 'События');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('event', 'Управление событиями');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('event', 'Beta: 1.0');
    }

    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-calendar';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('event', 'События'),
                'icon'    => $this->icon,
                'url'     => 'javascript:void(0)',
                'visible' => Yii::app()->user->checkAccess('showEvent'),
                'items'   => array(
                    array(
                        'label'   => Yii::t('event', 'Календарь событий'),
                        'url'     => array( '/event/calendar/index' ),
                        'visible' => Yii::app()->user->checkAccess('showEvent'),
                    ),
                    array(
                        'label'       => '',
                        'url'         => 'javascript:void(0)',
                        'visible'     => Yii::app()->user->checkAccess('showEvent'),
                        'itemOptions' => array(
                            'class' => 'divider',
                        ),
                    ),
                    array(
                        'label'   => Yii::t('event', 'Список событий'),
                        'url'     => array( '/event/event/index' ),
                        'visible' => Yii::app()->user->checkAccess('showEvent'),
                    ),
                    array(
                        'label'   => Yii::t('event', 'Категории событий'),
                        'url'     => array( '/event/category/index' ),
                        'visible' => Yii::app()->user->checkAccess('showEventCategory'),
                    ),
                ),
            ),
        );
    }

}

