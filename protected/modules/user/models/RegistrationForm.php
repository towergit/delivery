<?php

/**
 * Регистрация на сайте
 * 
 * @category Model
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 * 
 * Доступные поля формы:
 * @property string $confirm_password
 */
class RegistrationForm extends User
{

	/**
	 * @var string повторение нового пароля
	 */
	public $confirm_password;

	/**
	 * @var string телефон
	 */
	public $phone;

	/**
	 * @var boolean подписка на новости
	 */
	public $subscribe;
	
	/**
	 * @var boolean подтвержден ли телефон
	 */
	public $confirmedPhone = false;
	
	/**
	 * Правила проверки для атрибутов модели
	 * @return array
	 */
	public function rules()
	{
		return array(
			array( 'username, email, phone, password, confirm_password', 'required' ),
			array( 'username, email', 'unique', 'caseSensitive' => false ),
                        array( 'username', 'match', 'pattern' => '/^[A-Za-z0-9@-_\.\+]+$/u', 'message' => Yii::t('UserModule', 'Логин должен состоять из латинских символов и/или цифр!')),
			array( 'username, password', 'length', 'min' => 6, 'max' => 20, 'allowEmpty' => true ),
			array( 'email', 'email' ),
			array( 'phone', 'checkPhone' ),
			array( 'subscribe', 'boolean' ),
			array( 'confirmedPhone', 'safe' ),
			array( 'confirm_password', 'compare', 'compareAttribute' => 'password' ),
		);
	}

	/**
	 * Индивидуальные метки атрибутов
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'username'			 => Yii::t('UserModule', 'Логин'),
			'password'			 => Yii::t('UserModule', 'Пароль'),
			'new_password'		 => Yii::t('UserModule', 'Новый пароль'),
			'confirm_password'	 => Yii::t('UserModule', 'Повторить пароль'),
			'email'				 => Yii::t('UserModule', 'Эл. почта'),
			'phone'				 => Yii::t('UserModule', 'Телефон'),
			'subscribe'			 => Yii::t('UserModule', 'Получать новостную рассылку с сайта'),
		);
	}
	
	public function checkPhone()
	{
		$phone = Profile::model()->findByAttributes(array( 'phone' => $this->phone ));
		
		if ($phone !== null)
			$this->addError('phone', 'Телефон "' . $this->phone . '" уже занят.');
		
//		if (!$this->hasErrors())
//		{
//			if (!$this->confirmedPhone)
//			{
//				$random = rand(100000, 999999);
//				$rand = $random; 
//				$text = "Для подтверждения регистрации введите число: $rand";
//				Yii::app()->sms->sendSmsTo($this->phone, $text);
//
//				$this->addError('phone', "
//					<script>
//						$.fancybox.open('#sms', fancyboxOptions);
//						$('#sms #SmsForm_hidden').val($rand);
//						$('#sms #SmsForm_phone').val($this->phone);
//					</script>
//				");
//			}
//		}
	}

}

