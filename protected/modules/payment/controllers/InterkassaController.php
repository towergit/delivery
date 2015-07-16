<?php

/**
 * Платежная система OkPay
 *
 * @category Controller
 * @package  Module.Payment
 * @author   Vlad Lotysh <lotysh.vm@gmail.com>
 */
class InterkassaController extends FrontendController {

    protected $_curs = 54.24;

    public function init() {
        parent::init();

        $curs = Exchange::daily();

        if ($curs && isset($curs['USD']))
            $this->_curs = $curs['USD']['value'];
    }

    /**
     * Отправка данных
     * @param string $code код
     */
    public function actionIndex($code) {
        $model = Payment::model()->findByAttributes(array('code' => $code));

        if (!$model || $model->status != Payment::STATUS_CREATE)
            $this->redirect(array('/default/index'));


        $ik_am = number_format($this->_curs * $model->sum, 2, '.', '');

        echo '<form id="interkassa" name="payment" method="post" action="https://sci.interkassa.com/" enctype="utf-8">
	<input type="hidden" name="ik_co_id" value="557042a13b1eaf3b338b4567" />
	<input type="hidden" name="ik_pm_no" value="ID_' . $model->code . '" />
	<input type="hidden" name="ik_am" value="' . $ik_am . '" />
	<input type="hidden" name="ik_cur" value="RUB" />
	<input type="hidden" name="ik_desc" value="Объект помощи с идентификатором
                 ' . $model->ids_list . ' email отправителя ' . $_GET['user']['email'] . '  платеж с кодом ' . $model->code . '" />
        <input type="submit" value="Pay">
        </form>


            <script>
                    document.getElementById("interkassa").submit();
            </script>';
    }

    public function actionStatus() {

        if (!isset($_POST['ik_pm_no']) && !isset($_POST['ik_inv_st']))
            $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'error')));

        $model = Payment::model()->findByAttributes(array('code' => str_replace('ID_', '', $_POST['ik_pm_no'])));

        if (!$model)
            $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'error')));

        if ($_POST['ik_inv_st'] == "success" && $_POST['ik_am'] == $this->_curs * $model->sum && $model->status == Payment::STATUS_CREATE) {
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

                    $this->payment($sum, $package->id);
                }
            }

            $basket->delete();
            return true;
           // $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'success')));
        } else {
            var_dump($_POST['ik_inv_st'] == "success");
            var_dump($_POST['ik_am'] == $this->_curs * $model->sum);
            var_dump($model->status == Payment::STATUS_CREATE);
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
