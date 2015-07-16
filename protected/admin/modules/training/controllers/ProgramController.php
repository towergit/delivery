<?php

/**
 * Программа обучения
 *
 * @category Controller
 * @package  Module.Training
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ProgramController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'TrainingProgram';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index', 'month' ),
                'roles'   => array( 'showTrainingProgram' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createTrainingProgram' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateTrainingProgram' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteTrainingProgram' ),
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
                'class'      => 'admin.controllers.action.IndexAction',
                'modelName'  => $this->defaultModel,
                'scenario'   => 'search',
                'renderData' => array(
                    'stage'    => new TrainingStage,
                    'educator' => new TrainingLecturer,
                ),
            ),
            'create' => array(
                'class'      => 'admin.controllers.action.CreateAction',
                'modelName'  => $this->defaultModel,
                'success'    => Yii::t('training', 'Программа обучения успешно создана'),
                'error'      => Yii::t('training', 'Ошибка при создании программы обучения'),
                'renderData' => array(
                    'stage'    => new TrainingStage,
                    'educator' => new TrainingLecturer,
                ),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('training', 'Искомая программа обучения не найдена'),
            ),
            'update' => array(
                'class'      => 'admin.controllers.action.UpdateAction',
                'modelName'  => $this->defaultModel,
                'success'    => Yii::t('training', 'Программа обучения успешно отредактирована'),
                'error'      => Yii::t('training', 'Ошибка при редактировании программы обучения'),
                'exception'  => Yii::t('training', 'Искомая программа обучения не найдена'),
                'renderData' => array(
                    'stage'    => new TrainingStage,
                    'educator' => new TrainingLecturer,
                ),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('training', 'Программа обучения успешно удалена'),
                'error'     => Yii::t('training', 'Ошибка при удалении программы обучения'),
                'exception' => Yii::t('training', 'Искомая программа обучения не найдена'),
            ),
        );
    }

    public function actionMonth()
    {
        $id = (int) $_POST[$this->defaultModel]['year'];

        $models = TrainingStage::model()->findAllByAttributes(array( 'parent_id' => $id ));
        $array   = CHtml::listData($models, 'id', 'name');
        
        $data = CHtml::tag('option', array('value' => ''), CHtml::encode(Yii::t('training', '-- Выберите месяц --')), true);
      
        foreach($array as $value => $name)  
        {  
            $data .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);  
        }  

        echo CJSON::encode($data);
    }

}

