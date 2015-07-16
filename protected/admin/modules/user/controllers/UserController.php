<?php

/**
 * Пользователи
 *
 * @category Controller
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class UserController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'User';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showUser' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createUser' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateUser' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteUser' ),
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
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('user', 'Искомый объект не найден'),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'info'      => Yii::t('user', 'Данного пользователя удалить невозможно'),
                'success'   => Yii::t('user', 'Пользоватейль успешно удален'),
                'error'     => Yii::t('user', 'Ошибка при удалении пользователя'),
                'exception' => Yii::t('user', 'Искомый пользователь не найден'),
            ),
        );
    }

    /**
     * Создание пользователя
     */
    public function actionCreate()
    {
        $model      = new $this->defaultModel('create');
        $profile    = new UserProfile;
        $auth       = Yii::app()->authManager;
        $roles      = array( 'manager' );
        $operations = array();

        // Ajax валидация
        $this->performAjaxValidation($model, $profile);

        if (isset($_POST[$this->defaultModel], $_POST['UserProfile']))
        {
            $model->attributes   = $_POST[$this->defaultModel];
            $profile->attributes = $_POST['UserProfile'];
            
            if ($model->role)
                $roles = String::stringToArray($model->role);
            else
                $model->role = $roles[0];

            $operations = String::stringToArray($model->operation);

            if ($model->validate() && $profile->validate())
            {
                $transaction = Yii::app()->db->beginTransaction();

                try
                {
                    if ($model->save(false))
                    {
                        $profile->user_id = $model->id;
                        $profile->save(false);

                        foreach($auth->getRoles($model->id) as $obj)
                            $auth->revoke($obj->name, $model->id);

                        foreach($roles as $role)
                        {
                            if (!$auth->isAssigned($role, $model->id))
                                $auth->assign($role, $model->id);
                        }

                        foreach($auth->getOperations($model->id) as $obj)
                            $auth->revoke($obj->name, $model->id);

                        foreach($operations as $operation)
                        {
                            if (!$auth->isAssigned($operation, $model->id))
                                $auth->assign($operation, $model->id);
                        }
                    }

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', Yii::t('user', 'Пользователь успешно создан'));
                }
                catch(Exception $e)
                {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', Yii::t('user', 'Ошибка при создании пользователя'));
                }
            }
            else
                Yii::app()->user->setFlash('error', Yii::t('user', 'Ошибка при создании пользователя'));

            // Переадресация
            $this->redirectSubmitForm();
        }

        $roles['user'] = array( 'selected' => 'selected' );

        $this->render('create', array(
            'model'      => $model,
            'profile'    => $profile,
            'roles'      => $roles,
            'operations' => $operations,
        ));
    }
    
    /**
     * Редактирование пользователя
     * @param integer $id идентификатор пользователя
     */
    public function actionUpdate($id)
    {
        $model      = $this->loadModel($id);
        $profile    = UserProfile::model()->findByAttributes(array( 'user_id' => $model->id ));
        $auth       = Yii::app()->authManager;
        $roles      = array();
        $operations = array();

        if ($profile === null)
        {
            Yii::app()->user->setFlash('error', Yii::t('user', 'Искомый профиль пользователя не найден'));
            $this->redirect(array( 'index' ));
        }

        // Ajax валидация
        $this->performAjaxValidation($model, $profile);

        if (isset($_POST[$this->defaultModel], $_POST['UserProfile']))
        {
            $model->attributes   = $_POST[$this->defaultModel];
            $profile->attributes = $_POST['UserProfile'];

            $roles      = String::stringToArray($model->role);
            $operations = String::stringToArray($model->operation);

            if ($model->validate() && $profile->validate())
            {
                $transaction = Yii::app()->db->beginTransaction();

                try
                {
                    if ($model->save(false))
                    {
                        $profile->user_id = $model->id;
                        $profile->save(false);

                        foreach($auth->getRoles($model->id) as $obj)
                            $auth->revoke($obj->name, $model->id);

                        foreach($roles as $role)
                        {
                            if (!$auth->isAssigned($role, $model->id))
                                $auth->assign($role, $model->id);
                        }

                        foreach($auth->getOperations($model->id) as $obj)
                            $auth->revoke($obj->name, $model->id);

                        foreach($operations as $operation)
                        {
                            if (!$auth->isAssigned($operation, $model->id))
                                $auth->assign($operation, $model->id);
                        }
                    }

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', Yii::t('user', 'Пользователь успешно отредактирован'));
                }
                catch(Exception $e)
                {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', Yii::t('user', 'Ошибка при редактировании пользователя'));
                }
            }
            else
                Yii::app()->user->setFlash('error', Yii::t('user', 'Ошибка при редактировании пользователя'));

            // Переадресация
            $this->redirectSubmitForm();
        }

        foreach($auth->getRoles($model->id) as $obj)
            $roles[$obj->name] = array( 'selected' => 'selected' );

        foreach($auth->getOperations($model->id) as $obj)
            $operations[$obj->name] = array( 'selected' => 'selected' );

        $this->render('update', array(
            'model'      => $model,
            'profile'    => $profile,
            'roles'      => $roles,
            'operations' => $operations,
        ));
    }
    
    /**
     * Получение пользователя
     * @param string $id идентификатор пользователя
     * @return object
     */
    public function loadModel($id)
    {
        $model = CActiveRecord::model($this->defaultModel)->findByPk($id);

        if ($model === null)
        {
            Yii::app()->user->setFlash('error', Yii::t('user', 'Искомый пользователь не найден'));
            $this->redirect(array( 'index' ));
        }

        return $model;
    }
    
    /**
     * Валидация Ajax
     * @param object $model
     * @param object $profile
     */
    protected function performAjaxValidation($model, $profile)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === strtolower($this->defaultModel) . '-form')
        {
            echo BsActiveForm::validate(array( $model, $profile ));
            Yii::app()->end();
        }
    }

}

