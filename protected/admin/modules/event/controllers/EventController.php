<?php

/**
 * События
 *
 * @category Controller
 * @package  Module.Event
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class EventController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'Event';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showEvent' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createEvent' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateEvent' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteEvent' ),
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
                    'category' => new EventCategory,
                ),
            ),
            'create' => array(
                'class'     => 'admin.controllers.action.CreateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('event', 'Событие успешно создано'),
                'error'     => Yii::t('event', 'Ошибка при создании события'),
                'renderData' => array(
                    'category' => new EventCategory,
                ),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('event', 'Искомое событие не найдено'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('event', 'Событие успешно отредактировано'),
                'error'     => Yii::t('event', 'Ошибка при редактировании события'),
                'exception' => Yii::t('event', 'Искомое событие не найдено'),
                'renderData' => array(
                    'category' => new EventCategory,
                ),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('event', 'Событие успешно удалено'),
                'error'     => Yii::t('event', 'Ошибка при удалении события'),
                'exception' => Yii::t('event', 'Искомое событие не найдено'),
            ),
        );
    }

}

