<?php

/**
 * Управление пользователями и ихними ролями
 *
 * @category Module
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class UserModule extends WebModule
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
            'user.components.*',
            'user.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('user', 'Пользователи');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('user', 'Управление пользователями и ихними ролями');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('user', '1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-users';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('user', 'Пользователи'),
                'icon'    => $this->icon,
                'url'     => 'javascript:void(0)',
                'visible' => Yii::app()->user->checkAccess('showUserMenu'),
                'items'   => array(
                    array(
                        'label'   => Yii::t('user', 'Список пользователей'),
                        'url'     => array( '/user/user/index' ),
                      //  'visible' => Yii::app()->user->checkAccess('showUser'),
                    ),
                                        array(
                        'label'   => Yii::t('user', 'Список подписчиков'),
                        'url'     => array( '/user/subscribe/index' ),
                      //  'visible' => Yii::app()->user->checkAccess('showUser'),
                    ),
                    array(
                        'label'       => '',
                        'url'         => 'javascript:void(0)',
                        'visible'     => Yii::app()->user->checkAccess('showUserBlacklist'),
                        'itemOptions' => array(
                            'class' => 'divider',
                        ),
                    ),
                    array(
                        'label'   => Yii::t('user', 'Черный список'),
                        'url'     => array( '/user/blacklist/index' ),
                        'visible' => Yii::app()->user->checkAccess('showUserBlacklist'),
                    ),
                    array(
                        'label'       => '',
                        'url'         => 'javascript:void(0)',
                        'visible'     => Yii::app()->user->checkAccess('showUserRole'),
                        'itemOptions' => array(
                            'class' => 'divider',
                        ),
                    ),
                    array(
                        'label'   => Yii::t('user', 'Роли пользователей'),
                        'url'     => array( '/user/role/index' ),
                        'visible' => Yii::app()->user->checkAccess('showUserRole'),
                    ),
                    array(
                        'label'   => Yii::t('user', 'Операции пользователей'),
                        'url'     => array( '/user/operation/index' ),
                        'visible' => Yii::app()->user->checkAccess('showUserOperation'),
                    ),
                    array(
                        'label'   => Yii::t('user', 'Задачи пользователей'),
                        'url'     => array( '/user/task/index' ),
                        'visible' => Yii::app()->user->checkAccess('showUserTask'),
                    ),
                ),
            ),
        );
    }

}

