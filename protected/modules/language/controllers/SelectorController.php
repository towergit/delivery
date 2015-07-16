<?php

/**
 * Смена языка
 *
 * @category Controller
 * @package  Module.Language
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class SelectorController extends FrontendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'Language';

    /**
     * Смена языка
     */
    public function actionIndex($name, $url)
    {
        $langParam = Yii::app()->urlManager->langParam;
        $model     = CActiveRecord::model($this->defaultModel)->findByAttributes(array( 'url' => $name ));

        if ($model === null)
            $this->redirect(Yii::app()->request->urlReferrer);

        $url                                     = Yii::app()->urlManager->getCleanUrl($url);
        $url                                     = Yii::app()->urlManager->replaceLangUrl($url, $model->url);
        Yii::app()->request->cookies[$langParam] = new CHttpCookie($langParam, $model->url);

        $this->redirect('/' . $url);
    }

}

