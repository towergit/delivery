<?php

/**
 * Управление электронной почтой
 *
 * @category Module
 * @package  Module.Email
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class EmailModule extends WebModule
{
    /**
     * Инициализация модуля
     * setImport - импортирует при запуске любого контроллера этого модуля
     */
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'email.components.*',
            'email.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('email', 'Почта');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('email', 'Управление электронной почтой');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('email', 'Beta 1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-envelope-o';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('email', 'Почта'),
                'icon'    => $this->icon,
                'url'     => array( '/email/email/index' ),
                'visible' => Yii::app()->user->checkAccess('showEmail'),
            ),
        );
    }

}

