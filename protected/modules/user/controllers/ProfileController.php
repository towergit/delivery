<?php

/**
 * Профиль пользователя
 *
 * @category Controller
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ProfileController extends BackendController
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
                'roles'   => array( 'updateUserProfile' ),
            ),
            array( 'deny',
                'users' => array( '*' ),
            ),
        );
    }

    /**
     * Редактирование профиля пользователя
     * @param integer $id ID пользователя
     */
    public function actionIndex($id)
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
                    Yii::app()->user->setFlash('success', Yii::t('user', 'Профиль пользователя успешно отредактирован'));
                }
                catch(Exception $e)
                {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', Yii::t('user', 'Ошибка при редактировании профиля пользователя'));
                }
            }
            else
                Yii::app()->user->setFlash('error', Yii::t('user', 'Ошибка при редактировании профиля пользователя'));

            // Переадресация
            $this->redirectSubmitForm();
        }

        foreach($auth->getRoles($model->id) as $obj)
            $roles[$obj->name] = array( 'selected' => 'selected' );

        foreach($auth->getOperations($model->id) as $obj)
            $operations[$obj->name] = array( 'selected' => 'selected' );

        $this->render('index', array(
            'model'      => $model,
            'profile'    => $profile,
            'roles'      => $roles,
            'operations' => $operations,
        ));
    }

    /**
     * Получение студента
     * @param string $id ID студента
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

