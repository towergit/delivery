<?php

/**
 * Востановление данных пользователя
 *
 * @category Widget
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class RecoveryUserWidget extends CWidget
{

    /**
     * Запуск виджета
     */
    public function run()
    {
        $model = new RecoveryForm;
        
        $this->render('recoveryuser', array(
            'model' => $model,
        ));
    }

}

