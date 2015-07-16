<?php

/**
 * Ошибки
 *
 * @category Controller
 * @package  Controllers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ErrorController extends BackendController
{

    /**
     * @var string шаблон
     */
    public $layout = '//layouts/error';

    /**
     * Вывод ошибки
     */
    public function actionIndex()
    {
        if ($error = Yii::app()->errorHandler->error)
        {
            var_dump($error);
            exit();
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('index', $error);
        }
    }

}

