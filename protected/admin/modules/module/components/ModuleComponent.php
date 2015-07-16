<?php

/**
 * Управление модулями
 *
 * @category Component
 * @package  Module.Module
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ModuleComponent extends CApplicationComponent
{
	/**
	 * @var array данные 
	 */
	protected $data = array();
	
	/**
	 * Инициализация компонента
	 */
	public function init()
	{
		$db = $this->getDbConnection();
		
		$modules = $db->createCommand()
			->select('*')
			->from('{{module}}')
			->queryAll();
		
		if ($modules !== NULL)
		{
			foreach ($modules as $module)
				$this->data[$module['alias']] = $module;
		}
		
		parent::init();
	}
	
	/**
	 * Получение модулей
	 * @return array
	 */
	public function getModules()
	{
		return $this->data;
	}
	
	/**
	 * Получение модуля
	 * @param string $title название модуля
	 * @return array/boolean
	 */
	public function get($title)
	{
		if (array_key_exists($title, $this->data))
			return $this->data[$title];
		else
			throw new CException('Модуль ' . $title . ' не найден!');
	}
	
	public function getRules($title)
	{
		
	}
	
	public function getMenu($title)
	{
		
	}
	
	/**
	 * Получение описания модуля
	 * @param string $title название модуля
	 * @return string/boolean
	 */
	public function getDescription($title)
	{
		if ($this->get($title))
			return Yii::app()->getModule($title)->description;
		else
			return false;
	}
	
	/**
	 * Получение версии модуля
	 * @param string $title название модуля
	 * @return string/boolean
	 */
	public function getVersion($title)
	{
		if ($this->get($title))
			return Yii::app()->getModule($title)->version;
		else
			return false;
	}
	
	/**
	 * Установка модуля
	 * @param string $title название модуля
	 */
	public function install($title)
	{
		
	}
	
	/**
	 * Удаление модуля
	 * @param string $title название модуля
	 */
	public function uninstall($title)
	{
		
	}
	
	/**
	 * Соединение с базой данных
	 * @return object
	 */
	private function getDbConnection()
	{
		return Yii::app()->db;
	}
}