<?php

/**
 * Управление настройками системы
 *
 * @category Module
 * @package  Module.Setting
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class SettingModule extends WebModule
{
	/**
	 * Инициализация модуля
	 * setImport - импортирует при запуске любого контроллера этого модуля
	 */
	public function init()
	{
		parent::init();

		$this->setImport(array(
			'setting.components.*',
			'setting.models.*',
		));
	}
	
	/**
	 * Получение имени модуля
	 * @return string
	 */
	public function getName()
	{
		return Yii::t('setting', 'Настройки');
	}
	
	/**
	 * Описание модуля
	 * @return string
	 */
	public function getDescription()
	{
		return Yii::t('setting', 'Управление настройками системы');
	}
	
	/**
	 * Версия модуля
	 * @return string
	 */
	public function getVersion()
	{
		return Yii::t('setting', 'Beta 1.0');
	}
	
	/**
	 * Получение навигации
	 * @return array
	 */
	public function getNavigation()
	{
		return array(
			array(
				'label'		 => Yii::t('setting', 'Настройки'),
				'icon'		 => 'fa fa-gears',
				'url'		 => array( '/setting/setting/index' ),
				'visible'	 => Yii::app()->user->checkAccess('showSetting'),
			),
		);
	}

}