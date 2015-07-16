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
     * @var string вид
     */
    public $view;
    
    /**
     * Запуск виджета
     */
    public function run()
    {
        if (!$this->view)
            return false;
        
        $model = new LoginForm;
        
        $this->render($this->view, array(
            'model' => $model,
        ));
    }

}

