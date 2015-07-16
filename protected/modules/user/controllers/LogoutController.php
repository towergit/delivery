<?php

/**
 * Выход
 *
 * @category Controller
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class LogoutController extends BackendController
{

	/**
	 * @var string экшен по умолчанию
	 */
	public $defaultAction = 'logout';

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(array( '/user/login' ));
	}

}

