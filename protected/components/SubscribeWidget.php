<?php

/**
 * Подписка
 *
 * @category Widget
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class SubscribeWidget extends CWidget
{
    /**
     * Запуск виджета
     */
    public function run()
    {
        $model = new Subscribe;

        $this->render('subscribe', array(
            'model' => $model,
        ));
    }

}

