<?php

/**
 * Категории
 *
 * @category Controller
 * @package  Module.Material
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CategoryController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'MaterialCategory';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showMaterialCategory' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createMaterialCategory' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateMaterialCategory' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteMaterialCategory' ),
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
                'success'   => Yii::t('material', 'Категория материала успешно создан'),
                'error'     => Yii::t('material', 'Ошибка при создании категории материала'),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('material', 'Искомая категория материала не найдена'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('material', 'Категория материала успешно отредактирована'),
                'error'     => Yii::t('material', 'Ошибка при редактировании категории материала'),
                'exception' => Yii::t('material', 'Искомая категория материала не найдена'),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('material', 'Категория материала успешно удалена'),
                'error'     => Yii::t('material', 'Ошибка при удалении категории материала'),
                'exception' => Yii::t('material', 'Искомая категория материала не найдена'),
            ),
        );
    }

}

