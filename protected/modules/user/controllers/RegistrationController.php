<?php

/**
 * Регистрация
 *
 * @category Controller
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class RegistrationController extends FrontendController
{

	/**
	 * @var string модель по умолчанию
	 */
	public $defaultModel = 'RegistrationForm';

	/**
	 * Фильтр доступа
	 * @return array
	 */
	public function filters()
	{
		return array();
	}
        
	public function actionIndex($referral_link = false)
	{
		$model	 = new $this->defaultModel;
                $app = Yii::app();
		$auth	 = $app->authManager;
                $request = $app->request;
		if ($app->user->isGuest)
		{
			if ($request->isAjaxRequest){
                            if($request->getPost('ajax') === 'registration-form')
                                echo BsActiveForm::validate($model);
                            
                            $SMS = new GenerateSMS;

                            $SMS->app =$app;
                            $SMS->request =$request;
                            $SMS->processing();

                            $app->end();
                        }
                        
			if (isset($_POST[$this->defaultModel]))
			{
                                //Регистрация по телефону True - да, False - нет (по Email)
                                $type = $request->getPost('type');
                                $bePhone=  ($type == 'phone')? true : false ;
				$model->attributes	 = $_POST[$this->defaultModel];
				$transaction		 = $app->db->beginTransaction();

				try
				{
					$model->activation_key	 = md5(microtime() . $model->password);
					$model->password		 = md5($model->password);
					$model->active			 = ($bePhone)? User::ACTIVE : User::NOTACTIVE;
					$model->role			 = $app->controller->module->defaultRole;
					$model->save(false);
					// Создание профиля
					$profile			 = new Profile;
					$profile->user_id	 = $model->id;
					$profile->phone		 = $model->phone;
					// Реферальная программа
					if (!empty($referral_link))
					{
						if (preg_match('/\_[A-z]{4}\_/', $referral_link, $postfix))
						{
							Yii::import('admin.modules.user.models.ReferalPostfix');
							$platform = ReferalPostfix::model()->findByAttributes(array( 'postfix' => $postfix[0] ));
							$platform->invited += 1;
							$platform->save(false);
						}
						else
						{
							$referrer = Profile::model()->findByAttributes(array( 'referral_link' => $referral_link ));
							if ($referrer !== null)
								$profile->referrer_id = $referrer->user_id;
						}
					}

					$profile->save(false);

					// Подписка на новости
					if (!empty($model->subscribe))
					{
						Yii::import('application.modules.subscribe.models.Subscribe');

						$sub			 = new Subscribe;
						$sub->user_id	 = $model->id;
						$sub->content	 = 'news';
						$sub->save();
					}

					if (!$auth->isAssigned($model->role, $model->id))
					{
						foreach($auth->getRoles($model->id) as $obj)
							$auth->revoke($obj->getName(), $model->id);

						$auth->assign($model->role, $model->id);
					}

					// Отправка письма
                                        if(!$bePhone){
                                                Yii::import('application.modules.letter.models.EmailTemplate');

                                                $params['name']	 = $model->username;
                                                $params['link']	 = $this->createAbsoluteUrl('/user/activation',
                                                            array(
                                                            'activation_key' => $model->activation_key,
                                                            'email'			 => $model->email
                                                    ));
                                                // Заменяем .net на .ru так как mail.ru не принимает письма с .net
                                                $params['link']	 = str_replace('.net', '.ru', $params['link']);
                                                $temp = EmailTemplate::getTemplate('mailNotiRegister');
                                                if ($temp !== null)
                                                {
                                                        $mail = new Mailer;
                                                        $mail->to($model->email);
                                                        $mail->from(Yii::app()->setting->get('EMAIL_INFO'), Yii::app()->setting->get('EMAIL_INFO_TITLE'));
                                                        $mail->subject($temp->subject);
                                                        $mail->templateMessage($temp->text, $params);
                                                       
                                                        $mail->send();
                                                }
                                                $text='Регистрация прошла успешно. Для завершения проверьте почту и следуйте инструкциям в письме.';
                                            }else{
                                                Yii::app()->sms->sendSmsTo($profile->phone, 'Поздравляем! Вы успешно зарегистрированы в TOWER INVESTMENT FUND');
                                                $text='Регистрация прошла успешно.';
                                            }
                                                
					$app->user->setFlash('success',$text);

					$transaction->commit();
				} catch(Exception $e)
				{
					$app->user->setFlash('error', 'Ошибка при регистрации пользователя');
					$transaction->rollback();
				}
			}

			$this->redirect(array( '/default/index' ));
		}
		else
			$this->redirect($app->controller->module->profileUrl);
	}
	public function actionPhonecheck()
	{
		$phone = $_POST['phone'];

		Yii::app()->SendSms->phone	 = $phone;
		$random						 = rand(100000, 999999);
		$rand						 = $random;
		Yii::app()->SendSms->text	 = "Для подтверждения регистрации введите число: $rand";
		Yii::app()->SendSms->sendSms();

		echo $rand;
	}

}

