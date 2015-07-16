<?php

/**
 * Управление журналом событий
 *
 * @category Module
 * @package  Module.Log
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class LogModule extends WebModule
{

	/**
	 * Инициализация модуля
	 * setImport - импортирует при запуске любого контроллера этого модуля
	 */
	public function init()
	{
		parent::init();

		$this->setImport(array(
			'log.models.*',
		));
	}
	
	/**
	 * Получение имени модуля
	 * @return string
	 */
	public function getName()
	{
		return Yii::t('log', 'Журнал событий');
	}

	/**
	 * Описание модуля
	 * @return string
	 */
	public function getDescription()
	{
		return Yii::t('log', 'Управление журналом событий');
	}
	
	/**
	 * Версия модуля
	 * @return string
	 */
	public function getVersion()
	{
		return Yii::t('log', 'Beta 1.0');
	}
	
	/**
	 * Получение навигации
	 * @return array
	 */
	public function getNavigation()
	{
		return array(
			array(
				'label'		 => Yii::t('log', 'Журнал событий'),
				'icon'		 => 'fa fa-list-alt',
				'url'		 => array( '/log/log/index' ),
				'visible'	 => Yii::app()->user->checkAccess('showLog'),
			),
		);
	}

}