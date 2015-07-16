<?php

/**
 * Категории тикетов
 *
 * @category Controller
 * @package  Module.Ticket
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CategoryController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'TicketCategory';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showTicketCategory' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createTicketCategory' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateTicketCategory' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteTicketCategory' ),
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
                'success'   => Yii::t('ticket', 'Категория тикетов успешно создан'),
                'error'     => Yii::t('ticket', 'Ошибка при создании категории тикетов'),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('ticket', 'Искомая категория тикетов не найдена'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('ticket', 'Категория тикетов успешно отредактирована'),
                'error'     => Yii::t('ticket', 'Ошибка при редактировании категории тикетов'),
                'exception' => Yii::t('ticket', 'Искомая категория тикетов не найдена'),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('ticket', 'Категория материала успешно удалена'),
                'error'     => Yii::t('ticket', 'Ошибка при удалении категории тикетов'),
                'exception' => Yii::t('ticket', 'Искомая категория тикетов не найдена'),
            ),
        );
    }

}

