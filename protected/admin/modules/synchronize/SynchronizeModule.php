<?php


class SynchronizeModule extends WebModule
{
	/**
	 * Инициализация модуля
	 * setImport - импортирует при запуске любого контроллера этого модуля
	 */
	public function init()
	{
		parent::init();

		$this->setImport(array(
			'synchronize.models.*',
		));
	}

	public function getNavigation()
	{
		return array(
			array(
				'label'		 => Yii::t('synchronize', 'synchronize'),
				'icon'		 => 'fa fa-gears',
				'url'		 => array( 'synchronize/synchronize/index' ),
				'visible'	 => Yii::app()->user->checkAccess('showSynchronize'),
			),
		);
	}

}