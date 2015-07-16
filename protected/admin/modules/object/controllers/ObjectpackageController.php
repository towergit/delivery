<?php
/**
 * Объекты пкаетов помощи
 *
 * @category Controller
 * @package  Module.Object
 * @author   Vlad Lotysh <lotysh.vm@gmail.com>
 */
class ObjectpackageController extends BackendController {
    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'ObjectPackage';
    public $objecthelp = null;
    
    /**
     * Правила доступа к экшенам
     * @return array
     */
    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'update', 'sort', 'create','toggle','delete'),
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
            'create' => array(
                'class' => 'admin.controllers.action.CreateAction',
                'modelName' => $this->defaultModel,
                'success' => Yii::t('object', 'Пакет успешно создан'),
                'error' => Yii::t('object', 'Ошибка при создании пакета'),
                'redirectTo' => '/admin/object/objectpackage',
            ),
            'toggle' => array(
                'class' => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('object', 'Искомый пакет не найден'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('material', 'Пакет успешно отредактирован'),
                'error'     => Yii::t('material', 'Ошибка при редактировании пакета'),
                'exception' => Yii::t('material', 'Искомый пакет не найден'),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'info'      => Yii::t('object', 'Данный пакет удалить невозможно'),
                'success'   => Yii::t('object', 'Данный пакет успешно удален'),
                'error'     => Yii::t('object', 'Ошибка при удалении пакет'),
                'exception' => Yii::t('object', 'Искомый пакет помощи не найден'),
            ),
            'sort' => array(
                'class' => 'admin.controllers.action.SortableAction',
                'modelName' => $this->defaultModel,
            )
        );
    }

    public function actionIndex() {
        
        $this->objecthelp = Yii::app()->request->getQuery('object_id');
        $model = ObjectPackage::model();
        
        $model->help_id = $this->objecthelp;
                  
        if (isset($_GET[$this->defaultModel])){
            $model->unsetAttributes();
            
            if($this->objecthelp) {
                $model->help_id = $this->objecthelp;
            }
            
            $model->attributes = $_GET[$this->defaultModel];
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === strtolower($this->defaultModel) . '-form') {
            echo BsActiveForm::validate($model);
            Yii::app()->end();
        }
        $this->render('index', array('model' => $model));
    }
}