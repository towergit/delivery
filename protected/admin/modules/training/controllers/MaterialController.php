<?php

/**
 * Материалы учебный программы
 *
 * @category Controller
 * @package  Module.Training
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class MaterialController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'TrainingMaterial';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showTrainingMaterial' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createTrainingMaterial' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateTrainingMaterial' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteTrainingMaterial' ),
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
                'renderData' => array(
                    'stage'    => new TrainingStage,
                    'educator' => new TrainingLecturer,
                    'program' => new TrainingProgram,
                ),
            ),
            'create' => array(
                'class'     => 'admin.controllers.action.CreateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('training', 'Материал успешно создан'),
                'error'     => Yii::t('training', 'Ошибка при создании материала'),
                'renderData' => array(
                    'stage'    => new TrainingStage,
                    'educator' => new TrainingLecturer,
                    'program' => new TrainingProgram,
                ),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('training', 'Искомый материал не найден'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('training', 'Материал успешно отредактирован'),
                'error'     => Yii::t('training', 'Ошибка при редактировании материала'),
                'exception' => Yii::t('training', 'Искомый материал не найден'),
                'renderData' => array(
                    'stage'    => new TrainingStage,
                    'educator' => new TrainingLecturer,
                    'program' => new TrainingProgram,
                ),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('training', 'Материал успешно удален'),
                'error'     => Yii::t('training', 'Ошибка при удалении материала'),
                'exception' => Yii::t('training', 'Искомый материал не найден'),
            ),
        );
    }

}

