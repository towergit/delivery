<?php

/**
 * Отзывы
 *
 * @category Widget
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ReviewsWidget extends CWidget
{
    /**
     * Запуск виджета
     */
    public function run()
    {
        $models = Review::model()->active()->findAll();
        
        if (!$models)
            return false;

        $this->render('reviews', array(
            'models' => $models,
        ));
    }

}

