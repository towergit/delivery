<?php

/**
 * Управление галерея
 *
 * @category Module
 * @package  Module.Gallery
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class GalleryModule extends WebModule
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
            'gallery.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('gallery', 'Галерея');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('gallery', 'Управление галереями');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('gallery', 'Beta 1.0');
    }

    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-camera';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('gallery', 'Галерея'),
                'icon'    => $this->icon,
                'url'     => 'javascript:void(0)',
                'visible' => Yii::app()->user->checkAccess('showGallery'),
                'items'   => array(
                    array(
                        'label'   => Yii::t('gallery', 'Список изображений'),
                        'url'     => array( '/gallery/gallery/index' ),
                        'visible' => Yii::app()->user->checkAccess('showGallery'),
                    ),
                    array(
                        'label'   => Yii::t('gallery', 'Категории галереи'),
                        'url'     => array( '/gallery/category/index' ),
                        'visible' => Yii::app()->user->checkAccess('showGalleryCategory'),
                    ),
                ),
            ),
        );
    }

}

