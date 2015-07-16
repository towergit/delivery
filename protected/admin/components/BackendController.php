<?php

/**
 * Главный контроллер для административной части
 * 
 * @category Controller
 * @package  Controllers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class BackendController extends CController
{

    /**
     * @var string шаблон
     */
    public $layout = '//layouts/nocolumns';

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = '';

    /**
     * @var array хлебные крошки 
     */
    public $breadcrumbs = array();

    /**
     * @var string путь к папке assets
     */
    private $_assetsBase;

    /**
     * Фильтр доступа
     * @return array
     */
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    /**
     * Правила доступа
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'roles' => array( 'manager' ),
            ),
            array( 'deny',
                'users' => array( '*' ),
            ),
        );
    }

    /**
     * Инициализация
     */
    public function init()
    {
        parent::init();
        $this->registerCommonScripts();
    }

    /**
     * Загрузка стилей и скриптов
     */
    public function registerCommonScripts()
    {
        $this->getAssetsBase();
        Yii::app()->clientScript->registerPackage('backend');
        
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($this->getAssetsBase() . '/js/jquery.yiiactiveform1.js', CClientScript::POS_END);

    }

    /**
     * Получение пути к папке Assets
     * @return string
     */
    public function getAssetsBase()
    {
        if ($this->_assetsBase === null)
        {
            $this->_assetsBase = Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('admin.assets'), false, -1, YII_DEBUG
            );
        }

        return $this->_assetsBase;
    }

    /**
     * Редирект при отправке формы
     */
    public function redirectSubmitForm()
    {
        $submit = Yii::app()->request->getPost('submit-type');

        if (isset($submit))
            if ($submit !== 'refresh')
                $this->redirect(array( $submit ));
            else
                $this->refresh();
        else
            $this->redirect(array( 'index' ));
    }

}

