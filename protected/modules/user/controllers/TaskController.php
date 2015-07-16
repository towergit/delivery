<?php

/**
 * Задачи пользователя
 *
 * @category Controller
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class TaskController extends BackendController
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
                'roles'   => array( 'showUserTask' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createUserTask' ),
            ),
            array( 'allow',
                'actions' => array( 'update' ),
                'roles'   => array( 'updateUserTask' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteUserTask' ),
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
                'success'       => Yii::t('user', 'Задача пользователя успешно удалена'),
                'error'         => Yii::t('user', 'Ошибка при удалении задачи пользователя'),
                'exception'     => Yii::t('user', 'Искомая задача пользователя не найдена'),
            ),
        );
    }

    /**
     * Получение списка всех задач
     */
    public function actionIndex()
    {
        $model       = new $this->defaultModel('search');
        $model->unsetAttributes();
        $model->type = AuthItem::TASK;

        if (isset($_GET[$this->defaultModel]))
            $model->attributes = $_GET[$this->defaultModel];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Создание новой задачи
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
                $auth->createTask($model->name, $model->description);

                $transaction->commit();
                Yii::app()->user->setFlash('success', Yii::t('user', 'Задача пользователя успешно cоздана'));
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', Yii::t('user', 'Ошибка при создании задачи пользователя'));
            }

            // Переадресация
            $this->redirectSubmitForm();
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Редактирование задачи
     * @param string $id название задачи
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
                Yii::app()->user->setFlash('success', Yii::t('user', 'Задача пользователя успешно обновлена'));
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', Yii::t('user', 'Ошибка при редактировании задачи пользователя'));
            }

            // Переадресация
            $this->redirectSubmitForm();
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Получение задачи пользователя
     * @param string $id название задачи
     * @return object
     */
    public function loadModel($id)
    {
        $model = CActiveRecord::model($this->defaultModel)->findByAttributes(array( 'name' => $id ));

        if ($model === null)
        {
            Yii::app()->user->setFlash('error', Yii::t('user', 'Искомая задача пользователя не найдена'));
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

