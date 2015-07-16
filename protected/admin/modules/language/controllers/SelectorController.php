<?php

/**
 * Смена языка
 *
 * @category Controller
 * @package  Module.Language
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class SelectorController extends BackendController
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
                'users'   => array( '*' ),
            ),
        );
    }

    /**
     * Смена языка
     */
    public function actionIndex($id, $url)
    {
        $langParam = Yii::app()->urlManager->langParam;
        $model     = CActiveRecord::model($this->defaultModel)->findByPk($id);

        if ($model === null)
            $this->redirect(Yii::app()->request->urlReferrer);

        $url                                     = Yii::app()->urlManager->getCleanUrl($url);
        $url                                     = Yii::app()->urlManager->replaceLangUrl($url, $model->url);
        Yii::app()->request->cookies[$langParam] = new CHttpCookie($langParam, $model->url);

        $this->redirect('/' . $url);
    }

}

