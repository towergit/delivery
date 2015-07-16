<?php

/**
 * Типы акций
 *
 * @category Controller
 * @package  Module.Share
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class TypeController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'ShareType';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showShareType' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createShareType' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateShareType' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteShareType' ),
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
                'success'   => Yii::t('share', 'Тип акции успешно создан'),
                'error'     => Yii::t('share', 'Ошибка при создании типа акции'),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('share', 'Искомый тип акции не найден'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('share', 'Тип акции успешно отредактирован'),
                'error'     => Yii::t('share', 'Ошибка при редактировании типа акции'),
                'exception' => Yii::t('share', 'Искомый тип акции не найден'),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('share', 'Тип акции успешно удален'),
                'error'     => Yii::t('share', 'Ошибка при удалении типа акции'),
                'exception' => Yii::t('share', 'Искомый тип акции не найден'),
            ),
        );
    }

}

