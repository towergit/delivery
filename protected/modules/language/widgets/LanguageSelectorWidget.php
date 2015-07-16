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
     * Запуск виджета
     */
    public function run()
    {
        $langs = Language::model()->active()->findAll();

        if ($langs === null || count($langs) == 1)
            return false;
        
        $this->render('languageselector', array(
            'langs'           => $langs,
            'currentLanguage' => Yii::app()->language,
            'cleanUrl'        => Yii::app()->urlManager->getCleanUrl(Yii::app()->request->url),
        ));
    }

}

