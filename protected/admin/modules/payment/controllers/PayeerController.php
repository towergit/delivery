<?php

/**
 * Платежная система Payeer
 *
 * @category Controller
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class PayeerController extends FrontendController
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
            $m_shop    = '43489896';
            $m_orderid = $model->code;
            $m_amount  = $model->sum;
            $m_curr    = 'USD';
            $m_desc    = base64_encode('UOM');
            $m_key     = 'Rz8wMwKXdcSu5SLx';

            $arHash = array( $m_shop, $m_orderid, $m_amount, $m_curr, $m_desc, $m_key );
            $sign   = strtoupper(hash('sha256', implode(":", $arHash)));

            echo '
				<form id="payeer" method="GET" action="//payeer.com/api/merchant/m.php">
					<input type="hidden" name="m_shop" value="' . $m_shop . '">
					<input type="hidden" name="m_orderid" value="' . $m_orderid . '">
					<input type="hidden" name="m_amount" value="' . $m_amount . '">
					<input type="hidden" name="m_curr" value="' . $m_curr . '">
					<input type="hidden" name="m_desc" value="' . $m_desc . '">
					<input type="hidden" name="m_sign" value="' . $sign . '">
				</form>
				<script>
					document.getElementById("payeer").submit();
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
        if (isset($_GET["m_operation_id"]) && isset($_GET["m_sign"]))
        {
            $m_key     = '';
            $arHash    = array(
                $_GET['m_operation_id'],
                $_GET['m_operation_ps'],
                $_GET['m_operation_date'],
                $_GET['m_operation_pay_date'],
                $_GET['m_shop'],
                $_GET['m_orderid'],
                $_GET['m_amount'],
                $_GET['m_curr'],
                $_GET['m_desc'],
                $_GET['m_status'],
                $m_key
            );
            $sign_hash = strtoupper(hash('sha256', implode(":", $arHash)));

            $model = CActiveRecord::model($this->defaultModel)->findByAttributes(array(
                'code' => $_GET['m_orderid']
            ));

            if ($_GET["m_sign"] == $sign_hash && $model !== null)
            {
                if ($_GET['m_status'] == "success" && $_GET['m_amount'] == $model->sum)
                {
                    $model->status = 'success';
                    $model->save(false);
                    $this->redirect('http://1uom.com/page/sellconference/8');
                }
                else
                {
                    $model->status = 'failure';
                    $model->save(false);
                    $this->redirect('http://1uom.com/page/sellconference/9');
                }
            }
            else
                $this->redirect('http://1uom.com/page/sellconference/9');
        }
        else
            $this->redirect('http://1uom.com/page/sellconference/9');
    }

}

