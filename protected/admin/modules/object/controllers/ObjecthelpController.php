<?php

/**
 * Объекты помощи
 *
 * @category Controller
 * @package  Module.Object
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ObjecthelpController extends BackendController {

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'ObjectHelp';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'update', 'create', 'toggle', 'deleteimage','delete'),
//                'roles'   => array( 'showObject' ),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    /**
     * Экшены
     * @return array
     */
    public function actions() {
        return array(
            'index' => array(
                'class' => 'admin.controllers.action.IndexAction',
                'modelName' => $this->defaultModel,
                'scenario' => 'search',
            ),
            'create' => array(
                'class' => 'admin.controllers.action.CreateAction',
                'modelName' => $this->defaultModel,
                'success' => Yii::t('object', 'Объект успешно создан'),
                'error' => Yii::t('object', 'Ошибка при создании объекта'),
                'aditional_url' => '/admin/object/objectpackage/create?object_id=',
            ),
            'toggle' => array(
                'class' => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('object', 'Искомый пользователь не найден'),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'info'      => Yii::t('object', 'Данный объект помощи удалить невозможно'),
                'success'   => Yii::t('object', 'Данный объект помощи успешно удален'),
                'error'     => Yii::t('object', 'Ошибка при удалении объекта помощи'),
                'exception' => Yii::t('object', 'Искомый объекта помощи не найден'),
            ),
            
            'sort' => array(
                'class' => 'admin.controllers.action.SortableAction',
                'modelName' => $this->defaultModel,
            ),
        );
    }

    public function actionUpdate($id) {

        $model = ObjectHelp::model()->findByAttributes(array('id' => $id));
        $category = ObjectCategory::model();

        if (isset($_POST['ajax']) && $_POST['ajax'] === $this->defaultModel . '-form') {

            echo BsActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST[$this->defaultModel])) {

            $model->attributes = $_POST[$this->defaultModel];

            $model->attributes = $_POST[$this->defaultModel];

            if ($model->save(false)) {

                Yii::app()->user->setFlash('success', Yii::t('oject', 'Объект обновлени!'));
            } else {
                Yii::app()->user->setFlash('error', Yii::t('oject', 'Произошла обшибка, объект не обновлен!'));
            }
            
            $this->refresh();
        }

        $this->render('update', array('model' => $model, 'category' => $category));
    }

    public function actionDeleteimage($id) {
        $model = ObjectHelp::model();
        $result = $model->imagesUpload->deleteFile($id);

        if ($result) {
            Yii::app()->user->setFlash('success', Yii::t('oject', 'Фото удалено успешно!'));
        } else {
            Yii::app()->user->setFlash('error', Yii::t('oject', 'Фото не удалено!'));
        }

        $this->redirect(Yii::app()->request->getQuery('redirect_url'));
    }

}
