<?php

/**
 * Блок контента
 *
 * @category Controller
 * @package  Module.Contentblock
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ContentblockController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'ContentBlock';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showContentblock' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createContentblock' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateContentblock' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteContentblock' ),
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
                'success'   => Yii::t('contentblock', 'Блок контента успешно создан'),
                'error'     => Yii::t('contentblock', 'Ошибка при создании блока контента'),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('contentblock', 'Искомый блок контента не найден'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('contentblock', 'Блок контента успешно отредактирован'),
                'error'     => Yii::t('contentblock', 'Ошибка при редактировании блока контента'),
                'exception' => Yii::t('contentblock', 'Искомый блок контента не найден'),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('contentblock', 'Блок контента успешно удален'),
                'error'     => Yii::t('contentblock', 'Ошибка при удалении блока контента'),
                'exception' => Yii::t('contentblock', 'Искомый блок контента не найден'),
            ),
        );
    }

}

