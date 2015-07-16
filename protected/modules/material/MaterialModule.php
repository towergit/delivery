<?php

/**
 * Управление пользователями и ихними ролями
 *
 * @category Module
 * @package  Module.Material
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class MaterialModule extends WebModule
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
            'material.components.*',
            'material.models.*',
        ));
    }

    /**
     * Получение зависимости
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
        return Yii::t('material', 'Материалы');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('material', 'Управление материалами');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('material', 'Beta 1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-file-text';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('material', 'Материалы'),
                'icon'    => $this->icon,
                'url'     => 'javascript:void(0)',
              //  'visible' => Yii::app()->user->checkAccess('showMaterial'),
                'items'   => array(
                    array(
                        'label'   => Yii::t('material', 'Избранные материалы'),
                        'url'     => array( '/material/elect/index' ),
                     //   'visible' => Yii::app()->user->checkAccess('showMaterial'),
                    ),
                    array(
                        'label'       => '',
                        'url'         => 'javascript:void(0)',
                      //  'visible'     => Yii::app()->user->checkAccess('showMaterial'),
                        'itemOptions' => array(
                            'class' => 'divider',
                        ),
                    ),
                    array(
                        'label'   => Yii::t('material', 'Список материалов'),
                        'url'     => array( '/material/material/index' ),
                    //    'visible' => Yii::app()->user->checkAccess('showMaterial'),
                    ),
                    array(
                        'label'   => Yii::t('material', 'Категории материалов'),
                        'url'     => array( '/material/category/index' ),
                     //   'visible' => Yii::app()->user->checkAccess('showMaterialCategory'),
                    ),
                ),
            ),
        );
    }

}

