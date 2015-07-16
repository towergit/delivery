<?php

/**
 * Планировщик задач
 *
 * @category Controller
 * @package  Module.Cron
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CronController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'Cron';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showCron' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createCron' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateCron' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteCron' ),
            ),
            array( 'deny',
                'users' => array( '*' ),
            ),
        );
    }

    /**
     * Список задач планировщика задач
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
     * Создание задачи
     */
    public function actionCreate()
    {
        $model = new $this->defaultModel;

        // Ajax валидация
        $this->performAjaxValidation($model);

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Переключатель
     * @param integer $pk
     * @param string $attribute
     */
    public function actionToggle($pk, $attribute)
    {
        $model             = $this->loadModel($pk);
        $model->$attribute = $model->$attribute ? 0 : 1;
        $model->save();

        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array( 'index' ));
    }

    /**
     * Редактирование задачи
     * @param integer $id ID задачи
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Ajax валидация
        $this->performAjaxValidation($model);

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Удаление задачи
     * @param integer $id ID задачи
     */
    public function actionDelete($id)
    {
        if ($this->loadModel($id)->delete())
            Yii::app()->user->setFlash('success', 'Задача планировщика задач успешно удалена');
        else
            Yii::app()->user->setFlash('error', 'Ошибка при удалении задачи планировщика задач');

        $this->redirect(array( 'index' ));
    }

    /**
     * Получение задачи
     * @param integer $id ID задачи
     * @return object
     */
    public function loadModel($id)
    {
        $model = CActiveRecord::model($this->defaultModel)->findByPk($id);

        if ($model === null)
        {
            Yii::app()->user->setFlash('error', 'Искомая задача не найдена');
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

