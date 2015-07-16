<?php

/**
 * Платежная система Яндекс деньги
 *
 * @category Controller
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class YandexController extends FrontendController {

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

        $sum = number_format($this->_curs * $model->sum, 2, '.', '');

        echo '
            <form id="yandex" method="POST" action="https://money.yandex.ru/quickpay/confirm.xml">
                <input type="hidden" name="receiver" value="410012329881920">
                <input type="hidden" name="formcomment" value="Частный перевод, Объект помощи с идентификатором
                 ' . $model->ids_list . ' с email отправителя ' . $_GET['user']['email'] . ' платеж с кодом ' . $model->code . '" />
                <input type="hidden" name="short-dest" value="Blagovest" />
                <input type="hidden" name="label" value="' . $model->code . '" />
                <input type="hidden" name="quickpay-form" value="donate" />
                <input type="hidden" name="targets" value="' . $model->email . '" />
                <input type="hidden" name="sum" value="' . $sum . '" data-type="number" />
                <input type="hidden" name="comment" value="Объект помощи с идентификатором
                 ' . $model->ids_list . '  платеж с кодом ' . $model->code . '" />
                <input type="hidden" name="need-fio" value="false" />
                <input type="hidden" name="need-email" value="false" />
                <input type="hidden" name="need-phone" value="false" />
                <input type="hidden" name="need-address" value="false" />
                <input type="hidden" name="paymentType" value="PC" />
            </form>
            <script type="text/javascript">
                document.getElementById("yandex").submit();
            </script>';
    }

    /**
     * Статус ответа
     */
    public function actionStatus() {
        $sha1Hash = sha1(
                $_POST['notification_type'] . '&' .
                $_POST['operation_id'] . '&' .
                $_POST['amount'] . '&' .
                $_POST['currency'] . '&' .
                $_POST['datetime'] . '&' .
                $_POST['sender'] . '&' .
                $_POST['codepro'] . '&' .
                '' . '&' .
                $_POST['label']
        );

        $model = Payment::model()->findByAttributes(array('code' => $_POST['label']));

        if (!$model || $model->status != Payment::STATUS_CREATE)
            $this->redirect($this->createUrl('/payment', array('step' => '3', 'status' => 'error')));

        if ($sha1Hash == $_POST['sha1_hash']) {
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

            $this->redirect($this->createUrl('/payment', array('step' => 3, 'status' => 'success')));
        } else {
            $model->status = Payment::STATUS_FAILURE;
            $model->save();
            var_dump($_POST);
            exit();
            //$this->redirect($this->createUrl('/payment', array( 'step' => '3', 'status' => 'error' )));
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
