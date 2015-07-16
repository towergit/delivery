<?php

/**
 * Языки
 *
 * @category Controller
 * @package  Module.Language
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class LanguageController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'Language';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showLanguage' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createLanguage' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updateLanguage' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteLanguage' ),
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
                'success'   => Yii::t('language', 'Язык успешно создан'),
                'error'     => Yii::t('language', 'Ошибка при создании языка'),
            ),
            'toggle' => array(
                'class'     => 'admin.controllers.action.ToggleAction',
                'modelName' => $this->defaultModel,
                'exception' => Yii::t('language', 'Искомый язык не найден'),
            ),
            'update' => array(
                'class'     => 'admin.controllers.action.UpdateAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('language', 'Язык успешно отредактирован'),
                'error'     => Yii::t('language', 'Ошибка при редактировании языка'),
                'exception' => Yii::t('language', 'Искомый язык не найден'),
            ),
            'delete' => array(
                'class'     => 'admin.controllers.action.DeleteAction',
                'modelName' => $this->defaultModel,
                'success'   => Yii::t('language', 'Язык успешно удален'),
                'error'     => Yii::t('language', 'Ошибка при удалении языка'),
                'exception' => Yii::t('language', 'Искомый язык не найден'),
            ),
        );
    }

}

