<?php

/**
 * Управление тикетами
 *
 * @category Module
 * @package  Module.Ticket
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class TicketModule extends WebModule
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
            'ticket.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('ticket', 'Тикеты');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('ticket', 'Управление тикетами');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('ticket', 'Alpha 1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-ticket';
    }
    
    /**
     * Получение зависимости
     * Массив с именами модулей, от которых зависит работа данного модуля
     * @return array
     */
    public function getDependencies()
    {
        return array(
            'user'
        );
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('ticket', 'Тикеты'),
                'icon'    => $this->icon,
                'url'     => 'javascript:void(0)',
                'visible' => Yii::app()->user->checkAccess('showTicket'),
                'items'   => array(
                    array(
                        'label'   => Yii::t('ticket', 'Список тикетов'),
                        'url'     => array( '/ticket/ticket/index' ),
                        'visible' => Yii::app()->user->checkAccess('showTicket'),
                    ),
                    array(
                        'label'   => Yii::t('ticket', 'Категории тикетов'),
                        'url'     => array( '/ticket/category/index' ),
                        'visible' => Yii::app()->user->checkAccess('showTicketCategory'),
                    ),
                ),
            ),
        );
    }

}

