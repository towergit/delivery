<?php

/**
 * Преподователи учебный программы
 *
 * @category Controller
 * @package  Module.Training
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class LecturerController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'TrainingLecturer';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showTrainingLecturer' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createTrainingLecturer' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateTrainingLecturer' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteTrainingLecturer' ),
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
                'success'   => Yii::t('training', 'Преподаватель успешно создан'),
                'error'     => Yii::t('training', 'Ошибка при создании преподавателя'),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('training', 'Искомый переподаватель не найден'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('training', 'Преподаватель успешно отредактирован'),
                'error'     => Yii::t('training', 'Ошибка при редактировании преподавателя'),
                'exception' => Yii::t('training', 'Искомый преподаватель не найден'),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('training', 'Преподаватель успешно удален'),
                'error'     => Yii::t('training', 'Ошибка при удалении преподавателя'),
                'exception' => Yii::t('training', 'Искомый преподаватель не найден'),
            ),
        );
    }

}

