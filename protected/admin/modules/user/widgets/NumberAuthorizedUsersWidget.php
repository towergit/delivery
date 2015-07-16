<?php

/**
 * Количество авторизованных пользователей
 *
 * @category Widget
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class NumberAuthorizedUsersWidget extends CWidget
{
    /**
     * Запуск виджета
     */
    public function run()
    {
        $db   = Yii::app()->db;
        $data = $db->createCommand()
            ->select('COUNT(*) as count')
            ->from('{{user_session}}')
            ->where('user_id > 0')
            ->queryAll();
        
        $this->render('lastactiveusers', array(
            'data' => $data,
        ));
    }

}

