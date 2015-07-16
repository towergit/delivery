<?php

/**
 * Категории FAQ
 *
 * @category Controller
 * @package  Module.Faq
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CategoryController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'FaqCategory';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showFAQCategory' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createFAQCategory' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateFAQCategory' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteFAQCategory' ),
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
                'success'   => Yii::t('faq', 'Категория FAQ успешно создана'),
                'error'     => Yii::t('faq', 'Ошибка при создании категории FAQ'),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('faq', 'Искомая категория FAQ не найдена'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('faq', 'Категория FAQ успешно отредактирована'),
                'error'     => Yii::t('faq', 'Ошибка при редактировании категории FAQ'),
                'exception' => Yii::t('faq', 'Искомая категория FAQ не найдена'),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('faq', 'Категория FAQ успешно удалена'),
                'error'     => Yii::t('faq', 'Ошибка при удалении категории FAQ'),
                'exception' => Yii::t('faq', 'Искомая категория FAQ не найдена'),
            ),
        );
    }

}

