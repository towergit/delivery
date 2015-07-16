<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WalletoneController
 *
 * @author vlad
 */
class WalletoneController extends FrontendController {

    public function actionIndex($code) {
        $model = Payment::model()->findByAttributes(array('code' => $code));

        if (!$model || $model->status != Payment::STATUS_CREATE)
            $this->redirect(array('/default/index'));

        echo '
            <form method="post" id="welletone" action="https://wl.walletone.com/checkout/checkout/Index">
                <input name="WMI_MERCHANT_ID"    value="123456789012"/>
                <input name="WMI_PAYMENT_AMOUNT" value="' . $model->sum . '"/>
                    <input name="WMI_PAYMENT_NO" value="' . $model->code . '"/>
                <input name="WMI_CURRENCY_ID"    value="840"/>
                <input name="WMI_DESCRIPTION"    value="Частный перевод, Объекты помощи с идентификатором
                 ' . $model->ids_list . ' платеж с кодом '.$model->code.'"/>
                <input name="WMI_SUCCESS_URL"    value="' . Yii::app()->createAbsoluteUrl('payment/walletone/status') . '"/>
                <input name="WMI_FAIL_URL"       value="' . Yii::app()->createAbsoluteUrl('payment/walletone/status') . '"/>
            </form>
            <script type="text/javascript">
                document.getElementById("welletone").submit();
            </script>';
    }

    public function actionStatus() {

        if (!isset($_POST['WMI_PAYMENT_NO']) && !isset($_POST['WMI_ORDER_STATE'])) {
            var_dump($_POST);
            var_dump("!isset(_POST['m_operation_id']) && !isset(_POST['m_signі'])");
            exit();
            $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'error')));
        }

        $model = Payment::model()->findByAttributes(array('code' => $_POST['WMI_PAYMENT_NO']));

        if (!$model) {
            var_dump($model);
            var_dump("!model");
            exit();

            $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'error')));
        }

        if (strtoupper($_POST["WMI_ORDER_STATE"]) == "ACCEPTED" && $_POST['WMI_COMMISSION_AMOUNT'] == $model->sum) {

            $model->status = Payment::STATUS_SUCCESS;
            $model->save();

            // Корзина
            $basket = Basket::model()->findByAttributes(array('session_id' => Yii::app()->session->sessionId));
            $objects = CJSON::decode($basket->object);
            $count = count($objects);
            $sum = $model->sum / $count;

            foreach ($objects as $object) {
                $object = ObjectHelp::model()->findByPk($object);
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
        } else {

            $model->status = Payment::STATUS_FAILURE;
            $model->save();
            
            var_dump($_POST);
            var_dump($_GET);
            var_dump("FAILED");
            exit();
            $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'error')));
        }
    }

}
