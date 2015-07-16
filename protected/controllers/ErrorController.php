<?php

/**
 * Ошибки
 *
 * @category Controller
 * @package  Controllers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ErrorController extends FrontendController
{
    
     public $showHeadering = true;

    /**
     * @var string шаблон
     */
    public $layout = '//layouts/main';
    
    /**
     * Загрузка стилей и скриптов
     */
    public function registerCommonScripts()
    {
        parent::registerCommonScripts();
        
        $cs = Yii::app()->getClientScript();
        
        // Custom
        $cs->registerScriptFile($this->getAssetsBase() . '/js/scripts.js', CClientScript::POS_END);
        $cs->registerCssFile($this->getAssetsBase() . '/css/style.css');
    }

    /**
     * Вывод ошибки
     */
    public function actionIndex()
    {
        if ($error = Yii::app()->errorHandler->error)
        {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('index', $error);
        }
    }

}

