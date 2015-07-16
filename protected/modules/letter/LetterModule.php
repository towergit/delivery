<?php

/**
 * Управлениe письмами
 *
 * @category Module
 * @package  Module.Letter
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class LetterModule extends WebModule
{

	/**
	 * Инициализация модуля
	 * setImport - импортирует при запуске любого контроллера этого модуля
	 */
	public function init()
	{
		parent::init();

		$this->setImport(array(
			'letter.models.*',
		));
	}

	/**
	 * Интернационализация
	 * @param string $str
	 * @param array $params
	 * @param string $file
	 * @return string
	 */
	public static function t($str = '', $params = array(), $file = '')
	{
		if ($file == '')
			return Yii::t(__CLASS__, $str, $params);
		else
			return Yii::t($file, $str, $params);
	}

	/**
	 * Описание модуля
	 * @return string
	 */
	public function getDescription()
	{
		return self::t('Управление письмами');
	}

	/**
	 * Версия модуля
	 * @return string
	 */
	public function getVersion()
	{
		return 'Beta: 1.0';
	}

}