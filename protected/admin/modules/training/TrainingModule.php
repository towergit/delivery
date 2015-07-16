<?php

/**
 * Управление обучающей программой
 *
 * @category Module
 * @package  Module.Training
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class TrainingModule extends WebModule
{
    /**
     * Инициализация модуля
     * setImport - импортирует при запуске любого контроллера этого модуля
     * setComponents - импортирует компоненты
     */
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'training.models.*',
        ));
    }

    /**
     * Получение имени модуля
     * @return string
     */
    public function getName()
    {
        return Yii::t('training', 'Обучающая программа');
    }

    /**
     * Описание модуля
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('training', 'Управление обучающей программой');
    }

    /**
     * Версия модуля
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('training', 'Alpha 1.0');
    }
    
    /**
     * Получение иконки модуля
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-graduation-cap';
    }

    /**
     * Получение навигации
     * @return array
     */
    public function getNavigation()
    {
        return array(
            array(
                'label'   => Yii::t('training', 'Обучающая программа'),
                'icon'    => $this->icon,
                'url'     => 'javascript:void(0)',
                'visible' => Yii::app()->user->checkAccess('showTraining'),
                'items'   => array(
                    array(
                        'label'   => Yii::t('training', 'Преподователи'),
                        'url'     => array( '/training/lecturer/index' ),
                        'visible' => Yii::app()->user->checkAccess('showTrainingLecturer'),
                    ),
                    array(
                        'label'   => Yii::t('training', 'Стадии обучения'),
                        'url'     => array( '/training/stage/index' ),
                        'visible' => Yii::app()->user->checkAccess('showTrainingStage'),
                    ),
                    array(
                        'label'   => Yii::t('training', 'Программа обучения'),
                        'url'     => array( '/training/program/index' ),
                        'visible' => Yii::app()->user->checkAccess('showTrainingProgram'),
                    ),
                    array(
                        'label'   => Yii::t('training', 'Материалы обучения'),
                        'url'     => array( '/training/material/index' ),
                        'visible' => Yii::app()->user->checkAccess('showTrainingMaterial'),
                    ),
                    array(
                        'label'   => Yii::t('training', 'Балловая система'),
                        'url'     => array( '/training/pointSystem/index' ),
                        'visible' => Yii::app()->user->checkAccess('showTrainingPointSystem'),
                    ),
                    array(
                        'label'   => Yii::t('training', 'Рейтинг учеников'),
                        'url'     => array( '/training/ratingStudent/index' ),
                        'visible' => Yii::app()->user->checkAccess('showTrainingRatingStudent'),
                    ),
                ),
            ),
        );
    }

}

