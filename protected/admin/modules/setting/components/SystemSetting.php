<?php

/**
 * Настройки
 *
 * @category Component
 * @package  Module.Setting
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class SystemSetting extends CApplicationComponent
{

	public $cache		 = 0;
	public $dependency	 = null;
	protected $data		 = array();

	/**
	 * Инициализация приложения
	 */
	public function init()
	{
		$db = $this->getDbConnection();

		$items = $db->createCommand('SELECT * FROM {{setting_main}}')->queryAll();

		foreach ($items as $item)
		{
			if ($item['param'])
				$this->data[$item['param']] = $item['value'] === '' ? $item['default'] : $item['value'];
		}

		parent::init();
	}

	/**
	 * GET
	 * @param string $key ключ
	 * @return string
	 * @throws CException
	 */
	public function get($key)
	{
		if (array_key_exists($key, $this->data))
			return $this->data[$key];
		else
			throw new CException('Неизвестный параметр ' . $key);
	}

	/**
	 * SET
	 * @param string $key ключ
	 * @param string $value значение
	 * @throws CException
	 */
	public function set($key, $value)
	{
		$model = Setting::model()->findByAttributes(array( 'param' => $key ));
		
		if (!$model)
			throw new CException('Неизвестный параметр ' . $key);

		$model->value = $value;

		if ($model->save())
			$this->data[$key] = $value;
	}
	
	/**
	 * Проверка существования параметра
	 * @param string $key название параметра
	 * @return boolean
	 */
	public function checkParam($key)
	{
		$model = Setting::model()->findByAttributes(array( 'param' => $key ));
		
		if ($model === null)
			return false;
		
		return true;
	}

	/**
	 * Добавление параметров
	 * @param mixed $params параметры
	 */
	public function add($params)
	{
		if (isset($params[0]) && is_array($params[0]))
		{
			foreach($params as $item)
				$this->createParameter($item);
		}
		elseif ($params)
			$this->createParameter($params);
	}

	/**
	 * Удаление параметров
	 * @param mixed $key ключи
	 */
	public function delete($key)
	{
		if (is_array($key))
		{
			foreach($key as $item)
				$this->removeParameter($item);
		}
		elseif ($key)
			$this->removeParameter($key);
	}

	/**
	 * Соединение с базой данных
	 * @return object
	 */
	protected function getDbConnection()
	{
		if ($this->cache)
			$db	 = Yii::app()->db->cache($this->cache, $this->dependency);
		else
			$db	 = Yii::app()->db;

		return $db;
	}

	/**
	 * Создание параметра
	 * @param array $param параметр
	 */
	protected function createParameter($param)
	{
		if (!empty($param['param']))
		{
			$model = Setting::model()->findByAttributes(array( 'param' => $param['param'] ));

			if ($model === null)
				$model = new Setting();

			$model->param	 = $param['param'];
			$model->label	 = isset($param['label']) ? $param['label'] : $param['param'];
			$model->value	 = isset($param['value']) ? $param['value'] : '';
			$model->default	 = isset($param['default']) ? $param['default'] : '';
			$model->type	 = isset($param['type']) ? $param['type'] : '';

			$model->save();
		}
	}

	/**
	 * Удаление параметра
	 * @param string $key название ключа
	 */
	protected function removeParameter($key)
	{
		if (!empty($key))
		{
			$model = Setting::model()->findByAttributes(array( 'param' => $key ));

			if ($model !== null)
				$model->delete();
		}
	}

}

