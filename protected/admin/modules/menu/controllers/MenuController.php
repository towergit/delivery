<?php

/**
 * Меню
 *
 * @category Controller
 * @package  Module.Menu
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class MenuController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'Menu';

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
            'index'  => array(
                'class'     => 'admin.controllers.action.IndexAction',
                'modelName' => $this->defaultModel,
                'scenario'  => 'search',
            ),
            'create' => array(
                'class'     => 'admin.controllers.action.CreateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('menu', 'Меню успешно создано'),
                'error'     => Yii::t('menu', 'Ошибка при создании меню'),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('menu', 'Искомое меню не найдено'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('menu', 'Меню успешно отредактировано'),
                'error'     => Yii::t('menu', 'Ошибка при редактировании меню'),
                'exception' => Yii::t('menu', 'Искомое меню не найдено'),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('menu', 'Меню успешно удалено'),
                'error'     => Yii::t('menu', 'Ошибка при удалении меню'),
                'exception' => Yii::t('menu', 'Искомое меню не найдено'),
            ),
        );
    }

}

