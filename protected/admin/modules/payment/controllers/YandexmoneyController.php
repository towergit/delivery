<?php

/**
 * Платежная система Яндекс деньги
 *
 * @category Controller
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class YandexmoneyController extends FrontendController
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

		if ($model->save())
		{
			echo '
				<form id="yandex" method="POST" action="https://money.yandex.ru/quickpay/confirm.xml">
					<input type="hidden" name="receiver" value="410011680640891">
					<input type="hidden" name="formcomment" value="Частный перевод" />
					<input type="hidden" name="short-dest" value="Частный перевод" />
					<input type="hidden" name="label" value="' . $model->code . '" />
					<input type="hidden" name="quickpay-form" value="donate" />
					<input type="hidden" name="targets" value="' . $model->email . '" />
					<input type="hidden" name="sum" value="' . $model->sum . '" data-type="number" />
					<input type="hidden" name="comment" value="" />
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
		else
			$this->redirect('http://1uom.com/page/sellconference/9');
	}

	/**
	 * Статус ответа
	 */
	public function actionStatus()
	{
		$sha1Hash = sha1(
			$_POST['notification_type'] . '&' .
			$_POST['operation_id'] . '&' .
			$_POST['amount'] . '&' .
			$_POST['currency'] . '&' .
			$_POST['datetime'] . '&' .
			$_POST['sender'] . '&' .
			$_POST['codepro'] . '&' .
			'8A246C052F2F19D0147C94A4436B099AFF7B4D33E89A80B59D8E68AA0EF854FF' . '&' .
			$_POST['label']
		);
		
		$model = CActiveRecord::model($this->defaultModel)->findByAttributes(array( 
			'code' => $_POST['label']
		));

		if ($model !== null)
		{
			if ($sha1Hash == $_POST['sha1_hash'])
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
	
}

