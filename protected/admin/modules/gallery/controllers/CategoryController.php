<?php

/**
 * Категории галереи
 *
 * @category Controller
 * @package  Module.Gallery
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CategoryController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'GalleryCategory';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showGalleryCategory' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createGalleryCategory' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateGalleryCategory' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteGalleryCategory' ),
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
            ),
            'create' => array(
                'class'     => 'admin.controllers.action.CreateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('gallery', 'Категория галереи успешно создана'),
                'error'     => Yii::t('gallery', 'Ошибка при создании категории галереи'),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('gallery', 'Искомая категория галереи не найдена'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('gallery', 'Категория галереи успешно отредактирована'),
                'error'     => Yii::t('gallery', 'Ошибка при редактировании категории галереи'),
                'exception' => Yii::t('gallery', 'Искомая категория галереи не найдена'),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('gallery', 'Категория галереи успешно удалена'),
                'error'     => Yii::t('gallery', 'Ошибка при удалении категории галереи'),
                'exception' => Yii::t('gallery', 'Искомая категория галереи не найдена'),
            ),
        );
    }

}

