<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
/**
 * Description of Privat24Controller
 *
 * @author vlad
 */
class Privat24Controller extends FrontendController {

    protected $_curs = 23;
    protected $_merchant = 99096;
    protected $_pass = 'FX5r64YC1116A0m65sCCds80b957sed1';

    public function actionIndex($code) {
        $model = Payment::model()->findByAttributes(array('code' => $code));

        if (!$model || $model->status != Payment::STATUS_CREATE)
            $this->redirect(array('/default/index'));

        $model->sum = $this->_curs * $model->sum;

        $dataArray = array(
            'amt' => number_format($model->sum, 2, '.', ''),
            'ccs' => 'UAH',
            'details' => 'Благотворительный взнос',
            'ext_details' => "Объект помощи с идентификатором " . $model->ids_list . " email отправителя " . $_GET['user']['email'] . "  платеж с кодом " . $model->code,
            'pay_way' => 'privat24',
            'order' => $model->code,
            'merchant' => $this->_merchant,
        );

        $payment = http_build_query($dataArray);
        $signature = sha1(md5($payment . $this->_pass));

        echo ''
        . '<form method="POST" id="privat24" action="https://api.privatbank.ua/p24api/ishop">
            <input type="hidden" name="amt" value="' . $dataArray['amt'] . '" />
            <input type="hidden" name="ccy" value="' . $dataArray['ccs'] . '" />
            <input type="hidden" name="merchant" value="' . $dataArray['merchant'] . '" />
            <input type="hidden" name="order" value="' . $model->code . '" />
            <input type="hidden" name="details" value="' . $dataArray['details'] . '" />
            <input type="hidden" name="ext_details" value="' . $dataArray['ext_details'] . '" />
            <input type="hidden" name="pay_way" value="privat24" />
            <input type="hidden" name="return_url" value="' . Yii::app()->createAbsoluteUrl('payment/privat24/status') . '" />
            <input type="hidden" name="server_url" value="' . Yii::app()->createAbsoluteUrl('payment/privat24/status') . '" />
          '.
                //  <input type="hidden" name="signature" value="' . $signature . '" />
                '
            <button type="submit"><img src="img/buttons/api_logo_1.jpg" border="0" /></button>
            </form>
                        <script>
                document.getElementById("privat24").submit();
            </script>
            ';
    }

    public function actionStatus() {

        if (!isset($_POST['payment']) || !isset($_POST['signature'])) {
                        echo '!isset($_POST[\'payment\']) || !isset($_POST[\'signature\'])';
            echo '<pre>';
            var_dump($_POST);
            var_dump(!isset($_POST['payment']) || !isset($_POST['signature']));
            
            echo '</pre>';
            exit();
            
            $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'error')));
        }

        $resultArray = array();
        $resultString = $_POST['payment'];
        parse_str($resultString, $resultArray);

        $model = Payment::model()->findByAttributes(array('code' => $resultArray['order']));

        $convert_sum = $this->_curs * $model->sum;
        $signature = sha1(md5($_POST['payment'] . $this->_pass));

        if ($signature != $_POST['signature'] || $resultArray['state'] != 'ok' || $convert_sum != $resultArray['amt']) {
            
            echo '$signature != $_POST[\'signature\'] || $resultArray[\'state\'] != \'ok\' || $convert_sum != $resultArray[\'amt\']';
            echo '<pre>';
            var_dump($_POST);
            var_dump($signature != $_POST['signature'] || $resultArray['state'] != 'ok' || $convert_sum != $resultArray['amt']);
            
            echo '</pre>';
            exit();
            //$this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'error')));
        }
        
        
        $basket = Basket::model()->findByPk($model->basket_id);
        
        if( $model->status == Payment::STATUS_SUCCESS && !$basket)
            $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'success')));
          
        $model->status = Payment::STATUS_SUCCESS;
        $model->save();

        // Корзина
        
        
      
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
