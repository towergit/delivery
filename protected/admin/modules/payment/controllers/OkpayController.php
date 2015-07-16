<?php

/**
 * Платежная система OkPay
 *
 * @category Controller
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class OkpayController extends FrontendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'PaymentLecture';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'users' => array( '*' ),
            ),
        );
    }

    /**
     * Отправка данных
     * @param string $data
     */
    public function actionIndex($data)
    {
        $data  = CJSON::decode($data);
        $model = new $this->defaultModel;

        foreach($data as $key => $value)
            $model->$key = $value;

        if ($model->save())
        {
            echo '
                <form id="okpay" method="post" action="https://www.okpay.com/process.html">
                        <input type="hidden" name="ok_receiver" value="OK510489704">
                        <input type="hidden" name="ok_item_1_name" value="UOM">
                        <input type="hidden" name="ok_item_1_price" value="' . $model->sum . '">
                        <input type="hidden" name="ok_currency" value="USD">
                        <input type="hidden" name="ok_item_1_custom_1_title" value="Частный перевод">
                        <input type="hidden" name="ok_item_1_custom_1_value" value="Частный перевод">
                        <input type="hidden" name="ok_return_success" value="http://1uom.com/page/sellconference/9"/>
                        <input type="hidden" name="ok_return_fail" value="' . Yii::app()->createAbsoluteUrl('payment/okpay/status') . '"/>
                        <input type="hidden" name="ok_invoice" value="' . $model->code . '"/>
                        <input type="hidden" name="ok_ipn" value="' . Yii::app()->createAbsoluteUrl('payment/okpay/status') . '"/>
                </form>
                <script>
                        document.getElementById("okpay").submit();
                </script>';
        }
        else
            $this->redirect('http://1uom.com/page/sellconference/9');
    }

    /**
     * Статус ответа
     */
    public function actionStatus()
    {
        if (isset($_POST['ok_invoice']) && isset($_POST['ok_txn_status']))
        {
            $model = CActiveRecord::model($this->defaultModel)->findByAttributes(array(
                'code' => $_POST['ok_invoice']
            ));

            if ($model !== null)
            {
                $model->execution = date('Y-m-d H:i:s');

                if ($_POST['ok_txn_status'] == "completed" && $_POST['ok_txn_gross'] == $model->sum)
                {
                    $model->status = 'success';
                    $model->save(false);
                    $this->redirect('http://1uom.com/page/sellconference/8');
                }
                else
                {
                    $model->status = 'failure';
                    $model->save(false);
                    $this->redirect('http://1uom.com/page/sellconference/8');
                }
            }
            else
                $this->redirect('http://1uom.com/page/sellconference/9');
        }
        else
            $this->redirect('http://1uom.com/page/sellconference/9');
    }

}

