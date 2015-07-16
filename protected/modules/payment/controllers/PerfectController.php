<?php

/**
 * Платежная система Perfectmoney
 *
 * @category Controller
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class PerfectController extends FrontendController {

    /**
     * Отправка данных
     * @param string $code код
     */
    public function actionIndex($code) {
        $model = Payment::model()->findByAttributes(array('code' => $code));

        if (!$model || $model->status != Payment::STATUS_CREATE)
            $this->redirect(array('/default/index'));

        echo '
            <form id="perfect" method="post" action="https://perfectmoney.is/api/step1.asp">
                <input type="hidden" name="PAYEE_ACCOUNT" value="U5871616">
                <input type="hidden" name="PAYEE_NAME" value="Blagovest">
                <input type="hidden" name="PAYMENT_ID" value="' . $model->code . '">
                <input type="hidden" name="PAYMENT_AMOUNT" value="' . $model->sum . '">
                <input type="hidden" name="PAYMENT_UNITS" value="USD">
                <input type="hidden" name="STATUS_URL" value="mailto:24privat@gmail.com">
                <input type="hidden" name="PAYMENT_URL" value="' . Yii::app()->createAbsoluteUrl('payment/perfect/success') . '">
                <input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
                <input type="hidden" name="NOPAYMENT_URL" value="' . Yii::app()->createAbsoluteUrl('payment/perfect/error') . '">
                <input type="hidden" name="NOPAYMENT_URL_METHOD" value="POST">
                <input type="hidden" name="SUGGESTED_MEMO" value="Объект помощи с идентификатором
                 ' . $model->ids_list . ' email отправителя ' . $_GET['user']['email'] . '  платеж с кодом ' . $model->code . '">
                <input type="hidden" name="BAGGAGE_FIELDS" value="1">
            </form>
            <script>
                document.getElementById("perfect").submit();
            </script>';
    }

    public function actionSuccess() {
        if (!isset($_POST['PAYMENT_ID']))
            $this->redirect($this->createUrl('/payment', array('step' => '3', 'status' => 'error')));

        $model = Payment::model()->findByAttributes(array('code' => $_POST['PAYMENT_ID']));

        if (!$model && ($model->sum != $_POST['PAYMENT_AMOUNT'] && $model->status != Payment::STATUS_CREATE))
            $this->redirect($this->createUrl('/default/payment', array('step' => 3, 'status' => 'error')));

        $model->status = Payment::STATUS_SUCCESS;
        $model->save();

        // Корзина
        $basket = Basket::model()->findByPk($model->basket_id);
        $objects = $basket->objects;
        $count = count($objects);
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

               // $this->payment($sum, $package->id);
            }
        }

        $basket->delete();

        $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'success')));
    }

    public function actionError() {
        if (!isset($_POST['PAYMENT_ID']))
            $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'error')));

        $model = Payment::model()->findByAttributes(array('code' => $_POST['PAYMENT_ID']));

        if (!$model)
            $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'error')));

        $model->status = Payment::STATUS_FAILURE;
        $model->save();

        $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'error')));
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
