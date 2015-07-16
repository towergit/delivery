<?php

/**
 * Регистрация пользователя
 *
 * @category Widget
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class RegistrationUserWidget extends CWidget
{
    /**
     * Запуск виджета
     */
    public function run()
    {
        $model    = new RegistrationForm;

        $this->render('registrationuser',
            array(
            'model'    => $model,
        ));
    }

}

