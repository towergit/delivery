<?php

/**
 * Материалы
 *
 * @category Controller
 * @package  Module.Material
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class MaterialController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'Material';

    /**
     * Правила доступа к экшенам
     * @return array
     
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index','sort','create','update'),
            ),
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showMaterial' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createMaterial' ),
            ),
            array( 'allow',
                'actions' => array( 'sort', 'toggle', 'update' ),
                'roles'   => array( 'updateMaterial' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteMaterial' ),
            ),
            array( 'deny',
                'users' => array( '*' ),
            ),
        );
    }*/

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
                    'category' => new MaterialCategory,
                ),
            ),
            'create' => array(
                'class'     => 'admin.controllers.action.CreateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('material', 'Материал успешно создан'),
                'error'     => Yii::t('material', 'Ошибка при создании материала'),
                'renderData' => array(
                    'category' => new MaterialCategory,
                ),
            ),
            'sort'   => array(
                'class'     => 'admin.controllers.action.SortableAction',
                'modelName' => $this->defaultModel,
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('material', 'Искомый материал не найден'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('material', 'Материал успешно отредактирован'),
                'error'     => Yii::t('material', 'Ошибка при редактировании материала'),
                'exception' => Yii::t('material', 'Искомый материал не найден'),
                'renderData' => array(
                    'category' => new MaterialCategory,
                ),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('material', 'Материал успешно удален'),
                'error'     => Yii::t('material', 'Ошибка при удалении материала'),
                'exception' => Yii::t('material', 'Искомый материал не найден'),
            ),
        );
    }

}

