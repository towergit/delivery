<?php

/**
 * Операции пользователей
 *
 * @category Controller
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class OperationController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'AuthItem';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showUserOperation' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createUserOperation' ),
            ),
            array( 'allow',
                'actions' => array( 'update' ),
                'roles'   => array( 'updateUserOperation' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteUserOperation' ),
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
            'create' => array(
                'class'      => 'admin.controllers.action.CreateAction',
                'modelName'  => $this->defaultModel,
                'success'    => Yii::t('user', 'Операция пользователя успешно cоздана'),
                'error'      => Yii::t('user', 'Ошибка при создании операции пользователя'),
                'renderData' => array(
                    'module' => new Module,
                ),
            ),
            'update' => array(
                'class'         => 'admin.controllers.action.UpdateAction',
                'modelName'     => $this->defaultModel,
                'attributeName' => 'name',
                'success'       => Yii::t('user', 'Операция пользователя успешно обновлена'),
                'error'         => Yii::t('user', 'Ошибка при редактировании операции пользователя'),
                'exception'     => Yii::t('user', 'Искомая операция пользователя не найдена'),
                'renderData'    => array(
                    'module' => new Module,
                ),
            ),
            'delete' => array(
                'class'         => 'admin.controllers.action.DeleteAction',
                'modelName'     => $this->defaultModel,
                'attributeName' => 'name',
                'success'       => Yii::t('user', 'Операция пользователя успешно удалена'),
                'error'         => Yii::t('user', 'Ошибка при удалении операции пользователя'),
                'exception'     => Yii::t('user', 'Искомая операция пользователя не найдена'),
            ),
        );
    }

    /**
     * Получение списка всех операций
     */
    public function actionIndex()
    {
        $model       = new $this->defaultModel('search');
        $model->unsetAttributes();
        $model->type = AuthItem::OPERATION;

        if (isset($_GET[$this->defaultModel]))
            $model->attributes = $_GET[$this->defaultModel];

        $this->render('index', array(
            'model' => $model,
        ));
    }

}

