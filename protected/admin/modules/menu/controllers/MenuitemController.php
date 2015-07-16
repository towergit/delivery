<?php

/**
 * Пункты меню
 *
 * @category Controller
 * @package  Module.Menu
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class MenuitemController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'MenuItem';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showMenu' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createMenu' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateMenu' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteMenu' ),
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
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('menu', 'Искомый пункт меню не найден'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('menu', 'Пункт меню успешно отредактирован'),
                'error'     => Yii::t('menu', 'Ошибка при создании пункта меню'),
                'exception' => Yii::t('menu', 'Искомый пункт меню не найден'),
            ),
            'delete' => array(
                'class'      => 'admin.controllers.action.DeleteAction',
                'modelName'  => $this->defaultModel,
                'success'    => Yii::t('menu', 'Пункт меню успешно удален'),
                'error'      => Yii::t('menu', 'Ошибка при удалении пункта меню'),
                'exception'  => Yii::t('menu', 'Искомый пункт меню не найден'),
                'redirectTo' => array( 'index', 'menu_id' => Yii::app()->request->getQuery('menu_id') ),
            ),
        );
    }

    /**
     * Получение списка пунктов меню
     */
    public function actionIndex()
    {
        $model = new $this->defaultModel('search');
        $model->unsetAttributes();

        if (isset($_GET[$this->defaultModel]))
            $model->attributes = $_GET[$this->defaultModel];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Создание пункта мею
     */
    public function actionCreate()
    {
        $model = new $this->defaultModel;

        if ($menu_id        = (int) Yii::app()->request->getQuery('menu_id'))
            $model->menu_id = $menu_id;

        // Ajax валидация
        $this->performAjaxValidation($model);

        if (isset($_POST[$this->defaultModel]))
        {
            $model->attributes = $_POST[$this->defaultModel];

            if ($model->save(false))
                Yii::app()->user->setFlash('success', Yii::t('menu', 'Пункт меню успешно создан'));
            else
                Yii::app()->user->setFlash('error', Yii::t('menu', 'Ошибка при создании пункта меню'));

            // Перенаправление
            $this->redirectSubmitForm();
        }

        $this->render('create', array(
            'model' => $model,
        ));
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

