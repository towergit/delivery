<?php

/**
 * Платежная система Perfectmoney
 *
 * @category Controller
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class PerfectmoneyController extends FrontendController
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
		$data	 = CJSON::decode($data);
		$model	 = new $this->defaultModel;

		foreach($data as $key => $value)
			$model->$key = $value;

		if ($model->save(false))
		{
			echo '
				<form id="perfectmoney" method="post" action="https://perfectmoney.is/api/step1.asp">
					<input type="hidden" name="PAYEE_ACCOUNT" value="">
					<input type="hidden" name="PAYEE_NAME" value="UOM">
					<input type="hidden" name="PAYMENT_ID" value="' . $model->code . '">
					<input type="hidden" name="PAYMENT_AMOUNT" value="' . $model->sum . '">
					<input type="hidden" name="PAYMENT_UNITS" value="USD">
					<input type="hidden" name="STATUS_URL" value="mailto:24privat@gmail.com">
					<input type="hidden" name="PAYMENT_URL" value="' . Yii::app()->createAbsoluteUrl('payment/perfectmoney/success') . '">
					<input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
					<input type="hidden" name="NOPAYMENT_URL" value="' . Yii::app()->createAbsoluteUrl('payment/perfectmoney/error') . '">
					<input type="hidden" name="NOPAYMENT_URL_METHOD" value="POST">
					<input type="hidden" name="SUGGESTED_MEMO" value="Частный перевод">
					<input type="hidden" name="BAGGAGE_FIELDS" value="1">
				</form>
				<script>
					document.getElementById("perfectmoney").submit();
				</script>';
		}
		else
			$this->redirect('http://1uom.com/page/sellconference/9');
	}
	
	/**
	 * Статус не успешный
	 */
	public function actionError()
	{
		if (isset($_POST['PAYMENT_ID']))
		{
			$model = CActiveRecord::model($this->defaultModel)->findByAttributes(array( 
				'code' => $_POST['PAYMENT_ID'] 
			));

			if ($model !== null)
			{
				$model->status = 'failure';
				$model->save(false);
				$this->redirect('http://1uom.com/page/sellconference/9');
			}
			else
				$this->redirect('http://1uom.com/page/sellconference/9');
		}
		else
			$this->redirect('http://1uom.com/page/sellconference/9');
	}

	/**
	 * Статус ответа
	 */
	public function actionSuccess()
	{
		if (isset($_POST['PAYMENT_ID']))
		{
			$model = CActiveRecord::model($this->defaultModel)->findByAttributes(array( 
				'code' => $_POST['PAYMENT_ID'] 
			));

			if ($model !== null)
			{
				if ($model->sum == $_POST['PAYMENT_AMOUNT'])
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

