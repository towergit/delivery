<?php

/**
 * Платежная система OkPay
 *
 * @category Controller
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class OkpayController extends FrontendController {

    /**
     * Отправка данных
     * @param string $code код
     */
    public function actionIndex($code) {
        $model = Payment::model()->findByAttributes(array('code' => $code));

        if (!$model || $model->status != Payment::STATUS_CREATE)
            $this->redirect(array('/default/index'));

        echo '
            <form id="okpay" method="post" action="https://www.okpay.com/process.html">
                    <input type="hidden" name="ok_receiver" value="OK101409285">
                    <input type="hidden" name="ok_item_1_name" value="Blagovest">
                    <input type="hidden" name="ok_item_1_price" value="' . $model->sum . '">
                    <input type="hidden" name="ok_currency" value="USD">
                    <input type="hidden" name="ok_item_1_custom_1_title" value="Объект помощи с идентификатором
                 ' . $model->ids_list . ' email отправителя ' . $_GET['user']['email'] . '  платеж с кодом ' . $model->code . '">
                    <input type="hidden" name="ok_item_1_custom_1_value" value="Объект помощи с идентификатором
                 ' . $model->ids_list . ' email отправителя ' . $_GET['user']['email'] . '  платеж с кодом ' . $model->code . '">
                    <input type="hidden" name="ok_return_success" value="' . Yii::app()->createAbsoluteUrl('payment/okpay/status') . '"/>
                    <input type="hidden" name="ok_return_fail" value="' . Yii::app()->createAbsoluteUrl('payment/okpay/status') . '"/>
                    <input type="hidden" name="ok_invoice" value="' . $model->code . '"/>
                    <input type="hidden" name="ok_ipn" value="' . Yii::app()->createAbsoluteUrl('payment/okpay/status') . '"/>
            </form>
            <script>
                    document.getElementById("okpay").submit();
            </script>';
    }

    /**
     * Статус ответа
     */
    public function actionStatus() {

        if (!isset($_POST['ok_invoice']) && !isset($_POST['ok_txn_status']))
            $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'error')));

        $model = Payment::model()->findByAttributes(array('code' => $_POST['ok_invoice']));
        
        if (!$model) {
            $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'error')));
        }

        if ($_POST['ok_txn_status'] == "completed" && $_POST['ok_txn_gross'] == $model->sum && $model->status == Payment::STATUS_CREATE) {
        
            $model->status = Payment::STATUS_SUCCESS;
            $model->save();
            
            // Корзина
            $basket  = Basket::model()->findByPk($model->basket_id);
            $objects = $basket->objects;
            $count   = count($objects);
            //$sum     = $model->sum / $count;

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

                    //$this->payment($sum, $package->id);
                }
            }
            
            $basket->delete();
            $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'success')));
        } else {
		
                if($model->status == Payment::STATUS_SUCCESS) {
                        $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'success')));
                    } 


            $model->status = Payment::STATUS_FAILURE;
            $model->save();
            $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'error')));
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
