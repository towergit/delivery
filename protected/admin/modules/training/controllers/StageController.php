<?php

/**
 * Cтадии обучения
 *
 * @category Controller
 * @package  Module.Training
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class StageController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'TrainingStage';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showTrainingStage' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createTrainingStage' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateTrainingStage' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteTrainingStage' ),
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
            'create' => array(
                'class'     => 'admin.controllers.action.CreateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('training', 'Стадия обучения успешно создана'),
                'error'     => Yii::t('training', 'Ошибка при создании стадии обучения'),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('training', 'Искомая стадия обучения не найдена'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('training', 'Стадия обучения успешно отредактирована'),
                'error'     => Yii::t('training', 'Ошибка при редактировании стадии обучения'),
                'exception' => Yii::t('training', 'Искомая стадия обучения не найдена'),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('training', 'Стадия обучения успешно удалена'),
                'error'     => Yii::t('training', 'Ошибка при удалении стадии обучения'),
                'exception' => Yii::t('training', 'Искомая стадия обучения не найдена'),
            ),
        );
    }
}

