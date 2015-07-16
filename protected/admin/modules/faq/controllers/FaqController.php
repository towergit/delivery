<?php

/**
 * FAQ
 *
 * @category Controller
 * @package  Module.Faq
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class FaqController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'Faq';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showFAQ' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createFAQ' ),
            ),
            array( 'allow',
                'actions' => array( 'sort', 'toggle', 'update' ),
                'roles'   => array( 'updateFAQ' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteFAQ' ),
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
                    'category' => new FaqCategory,
                ),
            ),
            'create' => array(
                'class'     => 'admin.controllers.action.CreateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('faq', 'FAQ успешно создан'),
                'error'     => Yii::t('faq', 'Ошибка при создании FAQ'),
                'renderData' => array(
                    'category' => new FaqCategory,
                ),
            ),
            'sort'   => array(
                'class'     => 'admin.controllers.action.SortableAction',
                'modelName' => $this->defaultModel,
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('faq', 'Искомый FAQ не найден'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('faq', 'FAQ успешно отредактирован'),
                'error'     => Yii::t('faq', 'Ошибка при редактировании FAQ'),
                'exception' => Yii::t('faq', 'Искомый FAQ не найден'),
                'renderData' => array(
                    'category' => new FaqCategory,
                ),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('faq', 'FAQ успешно удален'),
                'error'     => Yii::t('faq', 'Ошибка при удалении FAQ'),
                'exception' => Yii::t('faq', 'Искомый FAQ не найден'),
            ),
        );
    }

}

