<?php

/**
 * Тикеты
 *
 * @category Controller
 * @package  Module.Ticket
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class TicketController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'Ticket';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showTicket' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createTicket' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateTicket' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteTicket' ),
            ),
            array( 'allow',
                'actions' => array( 'view' ),
                'roles'   => array( 'showTicketMessage' ),
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
                'class'      => 'admin.controllers.action.IndexAction',
                'modelName'  => $this->defaultModel,
                'scenario'   => 'search',
                'renderData' => array(
                    'category' => new TicketCategory,
                ),
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

    /**
     * Просмотр сообщений тикета
     * @param integer $id идентификатор тикета
     */
    public function actionView($id)
    {
        $model  = new TicketMessage;
        $models = TicketMessage::model()->findAll(array( 'condition' => "ticket_id = $id", 'order' => 'create_date' ));
        
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ticketmessage-form')
        {
            echo BsActiveForm::validate($model);
            Yii::app()->end();
        }
        
        if (isset($_POST['TicketMessage']))
        {
            $model->attributes = $_POST['TicketMessage'];
            
            if ($model->validate() && $model->save())
                Yii::app()->user->setFlash('success', Yii::t('ticket', 'Ответ на тикет успешно создан'));
            else
                Yii::app()->user->setFlash('error', Yii::t('ticket', 'Ошибк при создании ответа на тикет'));
            
            $this->refresh();
        }

        $this->render('view', array(
            'model'  => $model,
            'models' => $models,
        ));
    }

}

