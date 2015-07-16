<?php

/**
 * Объекты помощи
 *
 * @category Controller
 * @package  Module.Object
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ObjectcatsController extends BackendController {
    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'ObjectCategory';
    
    /**
     * Правила доступа к экшенам
     * @return array
     */
    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'update', 'sort', 'create','toggle','delete'),
//                'roles'   => array( 'showObject' ),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }
    /**
     * Экшены
     * @return array
     */
    public function actions() {
        return array(
            'index' => array(
                'class' => 'admin.controllers.action.IndexAction',
                'modelName' => $this->defaultModel,
                'scenario' => 'search',
            ),
            'create' => array(
                'class' => 'admin.controllers.action.CreateAction',
                'modelName' => $this->defaultModel,
                'success' => Yii::t('object', 'Категория успешно создана'),
                'error' => Yii::t('object', 'Ошибка при создании категории'),
                'redirectTo' => '/admin/object/objectcats',
            ),
            'toggle' => array(
                'class' => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('object', 'Искомая категория не найдена'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('material', 'Категория успешно отредактирована'),
                'error'     => Yii::t('material', 'Ошибка при редактировании категории'),
                'exception' => Yii::t('material', 'Искомая категория не найдена'),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'info'      => Yii::t('object', 'Данную категорию удалить невозможно'),
                'success'   => Yii::t('object', 'Данная категория успешно удалена'),
                'error'     => Yii::t('object', 'Ошибка при удалении пакет'),
                'exception' => Yii::t('object', 'Искомый пакет помощи не найден'),
            ),
            'sort' => array(
                'class' => 'admin.controllers.action.SortableAction',
                'modelName' => $this->defaultModel,
            )
        );
    }

}