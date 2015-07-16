<?php

/**
 * Переключение языков
 *
 * @category Widget
 * @package  Module.Language
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class LanguageSelectorWidget extends CWidget
{
    /**
     * @var string вид
     */
    public $view = 'languageselector';
    
    /**
     * Запуск виджета
     */
    public function run()
    {
        $langs = Language::model()->active()->findAll();

        if ($langs === null || count($langs) == 1 || $this->view == '')
            return false;
        
        $this->render($this->view, array(
            'langs'           => $langs,
            'currentLanguage' => Yii::app()->language,
            'cleanUrl'        => Yii::app()->urlManager->getCleanUrl(Yii::app()->request->url),
        ));
    }

}

