<?php

/**
 * Авторизации на сайте
 *
 * @category Controller
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class LoginController extends BackendController
{

    /**
     * @var string шаблон
     */
    public $layout = '//layouts/login';

    /**
     * @var string экшен по умолчанию
     */
    public $defaultAction = 'login';

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'AdminLoginForm';

    /**
     * Фильтр доступа
     * @return array
     */
    public function filters()
    {
        return array();
    }

    /**
     * Авторизация
     */
    public function actionLogin()
    {
        if (Yii::app()->user->isGuest)
        {
            $model = new $this->defaultModel;

            if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
            {
                echo BsActiveForm::validate($model);
                Yii::app()->end();
            }

            if (isset($_POST[$this->defaultModel]))
            {
                $model->attributes = $_POST[$this->defaultModel];

                if ($model->validate())
                    $this->redirect(array( '/default/index' ));
            }

            $this->render('index', array(
                'model' => $model
            ));
        }
        else
            $this->redirect(array( '/default/index' ));
    }

}

