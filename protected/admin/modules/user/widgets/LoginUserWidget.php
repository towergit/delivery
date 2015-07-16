<?php

/**
 * Авторизация пользователя
 *
 * @category Widget
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class LoginUserWidget extends CWidget
{

    /**
     * Запуск виджета
     */
    public function run()
    {
        $model = new LoginForm;
        
        $this->render('loginuser', array(
            'model' => $model,
        ));
    }

}

