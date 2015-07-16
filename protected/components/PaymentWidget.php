<?php

/**
 * Оплата
 *
 * @category Widget
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class PaymentWidget extends CWidget
{

    public $totalSum;

    /**
     * Запуск виджета
     */
    public function run()
    {
        $model = new Payment;
        
        $systems = PaymentSystem::model()->active()->findAll(array('order'=>'sort'));

        $this->render('payment',
            array(
            'model'   => $model,
            'totalSum' => $this->totalSum,
            'systems' => $systems,
        ));
    }

}

