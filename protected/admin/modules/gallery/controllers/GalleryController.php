<?php

/**
 * Список изображений галереи
 *
 * @category Controller
 * @package  Module.Gallery
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class GalleryController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'Gallery';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showGallery' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createGallery' ),
            ),
            array( 'allow',
                'actions' => array( 'sort', 'toggle', 'update' ),
                'roles'   => array( 'updateGallery' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteGallery' ),
            ),
            array( 'deny',
                'users' => array( '*' ),
            ),
        );
    }

    /**
     * Экшены
     * @return array
     */
    public function actions()
    {
        return array(
            'index'  => array(
                'class'     => 'admin.controllers.action.IndexAction',
                'modelName' => $this->defaultModel,
                'scenario'  => 'search',
                'renderData' => array(
                    'category' => new GalleryCategory,
                ),
            ),
            'create' => array(
                'class'     => 'admin.controllers.action.CreateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('gallery', 'Изображение успешно создано'),
                'error'     => Yii::t('Gallery', 'Ошибка при создании изображения'),
                'renderData' => array(
                    'category' => new GalleryCategory,
                ),
            ),
            'sort'   => array(
                'class'     => 'admin.controllers.action.SortableAction',
                'modelName' => $this->defaultModel,
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('gallery', 'Искомое изображение не найдено'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('gallery', 'Изображение успешно отредактировано'),
                'error'     => Yii::t('gallery', 'Ошибка при редактировании изображения'),
                'exception' => Yii::t('faq', 'Искомое изображение не найдено'),
                'renderData' => array(
                    'category' => new GalleryCategory,
                ),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('gallery', 'Изображение успешно удалено'),
                'error'     => Yii::t('gallery', 'Ошибка при удалении изображения'),
                'exception' => Yii::t('gallery', 'Искомое изображение не найдено'),
            ),
        );
    }

}

