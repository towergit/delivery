<?php

/**
 * Управление объектами помощи
 *
 * @category Module
 * @package  Module.Object
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ObjectModule extends WebModule
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
            'object.components.*',
            'object.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('object', 'Объекты помощи');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('object', 'Управление объектами помощи');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('object', 'Beta 1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-circle';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        
        return array(
            array(
                'label'   => Yii::t('user', 'Объекты помощи'),
                'icon'    => $this->icon,
                'url'     => 'javascript:void(0)',
                'items'   => array(
                    array(
                        'label'   => Yii::t('user', 'Объекты помощи'),
                        'url'     => array( 'admin/object/objecthelp' ),
                    ),
                    array(
                        'label'   => Yii::t('user', 'Пакеты к объектам помощи'),
                        'url'     => array(  'admin/object/objectpackage' ),
                    ),
                    )));
        /*
        return array(
            array(
                'label'   => Yii::t('object', 'Объекты помощи'),
                'icon'    => $this->icon,
                'url'     => array( 'admin/object/objecthelp' ),
//                'visible' => Yii::app()->user->checkAccess('showObject'),
            ),
        );*/
    }

}

