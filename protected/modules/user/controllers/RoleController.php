<?php

/**
 * Роли пользователей
 *
 * @category Controller
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class RoleController extends BackendController
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
                'roles'   => array( 'showUserRole' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createUserRole' ),
            ),
            array( 'allow',
                'actions' => array( 'update' ),
                'roles'   => array( 'updateUserRole' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteUserRole' ),
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
                'success'       => Yii::t('user', 'Роль пользователя успешно удалена'),
                'error'         => Yii::t('user', 'Ошибка при удалении роли пользователя'),
                'exception'     => Yii::t('user', 'Искомая роль пользователя не найдена'),
            ),
        );
    }

    /**
     * Получение списка всех ролей
     */
    public function actionIndex()
    {
        $model       = new $this->defaultModel('search');
        $model->unsetAttributes();
        $model->type = AuthItem::ROLE;

        if (isset($_GET[$this->defaultModel]))
            $model->attributes = $_GET[$this->defaultModel];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Создание новой роли
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
                $auth->createRole($model->name, $model->description);

                $transaction->commit();
                Yii::app()->user->setFlash('success', Yii::t('user', 'Роль пользователя успешно cоздана'));
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', Yii::t('user', 'Ошибка при создании роли пользователя'));
            }

            // Переадресация
            $this->redirectSubmitForm();
        }

        $operations = $auth->getOperations();

        $this->render('create',
            array(
            'model'      => $model,
            'operations' => $operations,
            'childrens'  => array(),
        ));
    }

    /**
     * Редактирование роли
     * @param string $id название роли
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
                if (!$model->save())
                    throw new Exception;

                if (Yii::app()->request->getParam('operations'))
                {
                    $role = $auth->getAuthItem($model->name);

                    foreach(Yii::app()->request->getParam('operations') as $name => $val)
                    {
                        if ($val && !$role->hasChild($name))
                            $role->addChild($name);
                        elseif (!$val && $role->hasChild($name))
                            $role->removeChild($name);
                    }
                }

                $transaction->commit();
                Yii::app()->user->setFlash('success', Yii::t('user', 'Роль пользователя успешно отредактирована'));
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', Yii::t('user', 'Ошибка при редактировании роли пользователя'));
            }

            // Переадресация
            $this->redirectSubmitForm();
        }

        $operations = $auth->getOperations();
        $childrens  = array();

        foreach($auth->getItemChildren($model->name) as $k => $v)
            $childrens[] = $k;

        $this->render('update',
            array(
            'model'      => $model,
            'operations' => $operations,
            'childrens'  => $childrens,
        ));
    }

    /**
     * Получение роли пользователя
     * @param string $id название роли
     * @return object
     */
    public function loadModel($id)
    {
        $model = CActiveRecord::model($this->defaultModel)->findByAttributes(array( 'name' => $id ));

        if ($model === null)
        {
            Yii::app()->user->setFlash('error', Yii::t('user', 'Искомая роль пользователя не найдена'));
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

