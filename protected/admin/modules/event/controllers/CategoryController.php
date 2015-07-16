<?php

/**
 * Категории событий
 *
 * @category Controller
 * @package  Module.Event
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CategoryController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'EventCategory';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showEventCategory' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createEventCategory' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateEventCategory' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteEventCategory' ),
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
                'success'   => Yii::t('event', 'Категория событий успешно создана'),
                'error'     => Yii::t('event', 'Ошибка при создании категории событий'),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('event', 'Искомая категория событий не найдена'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('event', 'Категория событий успешно отредактирована'),
                'error'     => Yii::t('event', 'Ошибка при редактировании категории событий'),
                'exception' => Yii::t('event', 'Искомая категория событий не найдена'),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('event', 'Категория событий успешно удалена'),
                'error'     => Yii::t('event', 'Ошибка при удалении категории событий'),
                'exception' => Yii::t('event', 'Искомая категория событий не найдена'),
            ),
        );
    }

}

