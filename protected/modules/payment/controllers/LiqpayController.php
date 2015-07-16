<?php

Yii::import('ext.LiqPay');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LiqpayController
 *
 * @author vlad
 */
class LiqpayController extends FrontendController {

    /**
     * Отправка данных
     * @param string $code код
     */
    public function actionIndex($code) {

        $model = Payment::model()->findByAttributes(array('code' => $code));

        if (!$model || $model->status != Payment::STATUS_CREATE)
            $this->redirect(array('/default/index'));

        Yii::app()->user->setFlash('liqpay_code', $model->code);
        $liqpay = new LiqPay('i5333230672', '3oeg0QDyXGrXwibIDihYx2vIwqtgiZD903o0H6FSnm5BsN');
        $html = $liqpay->cnb_form(array(
            'version' => '3',
            'amount' => $model->sum,
            'currency' => 'USD',
            'description' => "Объект помощи с идентификатором " . $model->ids_list . " email отправителя " . $_GET['user']['email'] . "  платеж с кодом " . $model->code,
            'order_id' => $model->code,
        ));

        echo $html;
        echo "<style>"
        . "form {display:none;}"
        . "</style>";
        echo "<script>"
        . "document.querySelectorAll('[name=btn_text]')[0].click();"
        . "console.log();"
        . "</script>";
//Создание cигнатуры (подписи)
    }

    public function actionStatus() {

        $code = Yii::app()->user->getFlash('liqpay_code');

        if ($code) {
            
            $model = Payment::model()->findByAttributes(array('code' => $code));
            
            //Получение статуса платежа
            $liqpay = new LiqPay('i5333230672', '3oeg0QDyXGrXwibIDihYx2vIwqtgiZD903o0H6FSnm5BsN');
            $liqpayResponse = $liqpay->api("payment/status", array(
                'order_id' => $code,
                'version' => '3',
            ));

            if ($liqpayResponse) {

                if ($liqpayResponse->status != 'success' || $liqpayResponse->result != 'ok' || $liqpayResponse->amount != $model->sum) {
                    $this->redirect($this->createUrl('/default/payment', array('step' => 3, 'status' => 'error')));
                }

                $model->status = Payment::STATUS_SUCCESS;
                $model->save();

                // Корзина
                $basket = Basket::model()->findByPk($model->basket_id);
                $objects = $basket->objects;
                $count = count($objects);

                foreach ($objects as $key => $value) {
                    $object_id = key($value);
                    //payment sum
                    $sum = $value[$object_id];

                    $object = ObjectHelp::model()->findByPk($object_id);
                    $package = ObjectPackage::model()->find(array(
                        'condition' => 'help_id = :help_id',
                        'params' => array(':help_id' => $object->id),
                        'order' => 'sort',
                    ));
                    $difference = $package->sum - $package->sum_collected;

                    if ($difference >= $sum) {
                        $package->sum_collected = $package->sum_collected + $sum;
                        $package->save();
                    } else {
                        $package->sum_collected = $package->sum_collected + $difference;
                        $package->save();

                        $sum = $sum - $difference;

                        $this->payment($sum, $package->id);
                    }
                }

                $basket->delete();

                $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'success')));
            }
        }
    }

    /**
     * Оплата
     * @param float $sum сумма
     * @param intger $id идентификатор пакета
     */
    protected function payment($sum, $id) {
        if ($sum != 0) {
            $package = ObjectPackage::model()->find(array(
                'condition' => 'help_id = :help_id AND id <> :id',
                'params' => array(':help_id' => $id, ':id' => $id),
            ));

            $difference = $package->sum - $package->sum_collected;

            if ($difference >= $sum) {
                $package->sum_collected = $package->sum_collected + $sum;
                $package->save();
            } else {
                $package->sum_collected = $package->sum_collected + $difference;
                $package->save();

                $sum = $sum - $difference;

                $this->payment($sum, $payment->id);
            }
        }
    }

}
