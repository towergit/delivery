<?php

/**
 * Последние активные пользователи
 *
 * @category Widget
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class LastActiveUsersWidget extends CWidget
{

    /**
     * @var integer лимит 
     */
    public $limit = 10;

    /**
     * Запуск виджета
     */
    public function run()
    {
        $models = User::model()->active()->findAll(array(
            'limit' => $this->limit,
            'order' => 'last_visit DESC'
        ));
        
        $this->render('lastactiveusers', array(
            'models' => $models,
        ));
    }

}

