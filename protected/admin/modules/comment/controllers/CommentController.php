<?php

/**
 * Комментарии
 *
 * @category Controller
 * @package  Module.Comment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CommentController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'Comment';

    /**
     * Правила доступа к экшенам
     * @return array
   
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showComment' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createComment' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateComment' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteComment' ),
            ),
            array( 'deny',
                'users' => array( '*' ),
            ),
        );
    }  */

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
                'success'   => Yii::t('comment', 'Комментарий успешно создан'),
                'error'     => Yii::t('comment', 'Ошибка при создании комментария'),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('comment', 'Искомый комментарий не найден'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('comment', 'Комментарий успешно отредактирован'),
                'error'     => Yii::t('comment', 'Ошибка при редактировании комментария'),
                'exception' => Yii::t('comment', 'Искомый комментарий не найден'),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('comment', 'Комментарий успешно удален'),
                'error'     => Yii::t('comment', 'Ошибка при удалении комментария'),
                'exception' => Yii::t('comment', 'Искомый комментарий не найден'),
            ),
        );
    }

}

