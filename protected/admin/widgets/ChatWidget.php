<?php

/**
 * Чат
 *
 * @category Widget
 * @package  Component
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ChatWidget extends CWidget
{
    /**
     * Запуск виджета
     */
    public function run()
    {
        $this->render('chat');
    }

}

