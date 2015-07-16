<?php

/**
 * Главный контроллер для пользовательской части
 *
 * @category Controller
 * @package  Controllers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class FrontendController extends CController
{

    /**
     * @var string шаблон
     */
    public $layout = '//layouts/main';

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = '';

    /**
     * @var string слоган для страницы
     */
    public $slogan = '';

    /**
     * @var string мета ключевые слова
     */
    public $metaKeywords = '';

    /**
     * @var string мета описание 
     */
    public $metaDescription = '';

    /**
     * @var array хлебные крошки 
     */
    public $breadcrumbs = array();

    /**
     * @var string путь к assets
     */
    private $_assetsBase;

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
        
        $cs = Yii::app()->getClientScript();
        
        // Jquery
        $cs->registerScriptFile($this->getAssetsBase() . '/js/jquery/' . (YII_DEBUG ? 'jquery-2.0.3.js' : 'jquery-2.0.3.min.js'), CClientScript::POS_END);
        
        // UI
        $cs->registerScriptFile($this->getAssetsBase() . '/js/ui/' . (YII_DEBUG ? 'jquery-ui-1.10.3.custom.js' : 'jquery-ui-1.10.3.custom.min.js'), CClientScript::POS_END);
        
        // Bootstrap
        $cs->registerScriptFile($this->getAssetsBase() . '/js/bootstrap/' . (YII_DEBUG ? 'bootstrap.js' : 'bootstrap.min.js'), CClientScript::POS_END);
        $cs->registerCssFile($this->getAssetsBase() . '/css/bootstrap/' . (YII_DEBUG ? 'bootstrap.css' : 'bootstrap.min.css'));
        
        // Font-awesome
        $cs->registerCssFile($this->getAssetsBase() . '/css/font-awesome/' . (YII_DEBUG ? 'font-awesome.css' : 'font-awesome.min.css'));
        
        // Cookie
        $cs->registerScriptFile($this->getAssetsBase() . '/js/cookie/jquery.cookie.js', CClientScript::POS_END);
        
        // Custom
        $cs->registerCssFile($this->getAssetsBase() . '/css/animate.css');
        
        // Yii
        $cs->registerScriptFile($this->getAssetsBase() . '/js/jquery.yiiactiveform1.js', CClientScript::POS_END);
    }

    /**
     * Получение пути assets
     * @return string
     */
    public function getAssetsBase()
    {
        if ($this->_assetsBase === null)
        {
            $this->_assetsBase = Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('application.assets'), false, -1, YII_DEBUG
            );
        }
        return $this->_assetsBase;
    }

    /**
     * Получение мета ключевых слов
     * @return string
     */
    public function getMetaKeywords()
    {
        if ($this->metaKeywords)
            return Yii::app()->clientScript->registerMetaTag($this->metaKeywords, 'keywords');
    }

    /**
     * Получение мета описания
     * @return string
     */
    public function getMetaDescription()
    {
        if ($this->metaDescription)
            return Yii::app()->clientScript->registerMetaTag($this->metaDescription, 'description');
    }

}

