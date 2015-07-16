<?php

/**
 * Управление комментариями
 *
 * @category Module
 * @package  Module.Comment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CommentModule extends WebModule
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
            'comment.models.*',
        ));
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
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('comment', 'Комментарии');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('comment', 'Управление комментариями');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('comment', 'Alpha 1.0');
    }

    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-comment';
    }
    
    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('comment', 'Комментарии'),
                'icon'    => $this->icon,
                'url'     => array( '/comment/comment/index' ),
                'visible' => Yii::app()->user->checkAccess('showComment'),
            ),
        );
    }

}

