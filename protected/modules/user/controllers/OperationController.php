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

    /**
     * Создание новой операции пользователя
     */
    public function actionCreate()
    {
        $model = new $this->defaultModel;
        $auth  = Yii::app()->authManager;

        // Ajax валидация
        $this->performAjaxValidation($model);

        if (isset($_POST[$this->defaultModel]))
        {
            $model->attributes = $_POST[$this->defaultModel];
            $transaction       = Yii::app()->db->beginTransaction();

            try
            {
                $auth->createOperation($model->name, $model->description);

                $transaction->commit();
                Yii::app()->user->setFlash('success', Yii::t('user', 'Операция пользователя успешно cоздана'));
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', Yii::t('user', 'Ошибка при создании операции пользователя'));
            }

            // Переадресация
            $this->redirectSubmitForm();
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Редактирование операции пользователя
     * @param string $id название операции
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $auth  = Yii::app()->authManager;

        // Ajax валидация
        $this->performAjaxValidation($model);

        if (isset($_POST[$this->defaultModel]))
        {
            $model->attributes = $_POST[$this->defaultModel];
            $transaction       = Yii::app()->db->beginTransaction();

            try
            {
                $model->save();

                $transaction->commit();
                Yii::app()->user->setFlash('success', Yii::t('user', 'Операция пользователя успешно обновлена'));
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', Yii::t('user', 'Ошибка при редактировании операции пользователя'));
            }

            // Переадресация
            $this->redirectSubmitForm();
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Получение операции пользователя
     * @param string $id название операции
     * @return object
     */
    public function loadModel($id)
    {
        $model = CActiveRecord::model($this->defaultModel)->findByAttributes(array( 'name' => $id ));

        if ($model === null)
        {
            Yii::app()->user->setFlash('error', Yii::t('user', 'Искомая операция пользователя не найдена'));
            $this->redirect(array( 'index' ));
        }

        return $model;
    }

    /**
     * Валидация Ajax
     * @param object $model
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === strtolower($this->defaultModel) . '-form')
        {
            echo BsActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}

