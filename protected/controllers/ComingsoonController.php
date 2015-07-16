<?php

/**
 * Контроллер по умолчанию
 *
 * @category Controller
 * @package  Controllers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ComingsoonController extends FrontendController
{

    /**
     * @var string шаблон
     */
    public $layout = '//layouts/coming_soon';

    /**
     * Загрузка стилей и скриптов
     */
    public function registerCommonScripts()
    {
        parent::registerCommonScripts();
        
        $cs = Yii::app()->getClientScript();
        
        // Custom
        $cs->registerScriptFile($this->getAssetsBase() . '/js/timer.js', CClientScript::POS_END);
        $cs->registerCssFile($this->getAssetsBase() . '/css/style.css');
        $cs->registerCssFile($this->getAssetsBase() . '/css/count-down.css');
    }

    /**
     * Главная страница
     */
    public function actionIndex()
    {
        $model = new Subscribe;
        
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'subscribe')
        {
            echo BsActiveForm::validate($model);
            Yii::app()->end();
        }
        
        if (isset($_POST['Subscribe']))
        {
            $model->attributes = $_POST['Subscribe'];
            
            if ($model->save())
                Yii::app()->user->setFlash('success', Yii::t('user', Yii::t('main', 'Спасибо за оставленный email адрес. Мы сообщим Вам о запуске проекта')));
            else
                Yii::app()->user->setFlash('error', Yii::t('user', Yii::t('main', 'Возникла ошибка, повторите попытку')));
            
            $this->refresh();
        }
        
        $this->render('index', array(
            'model' => $model,
        ));
    }
}

