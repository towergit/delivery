<?php

/**
 * Работа платежной системы
 *
 * @category Component
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CPaymentSystem extends CComponent
{

	/**
	 * @var object платежная система
	 */
	private $_class;

	/**
	 * Конструктор
	 */
	public function __construct($class)
	{
		$class	 = $this->getPaymentClass($class);
		$adapter = $this->getPaymentAdapterClass($class);

		$this->_class = new $adapter(new $class);
	}

	/**
	 * Установка идентификатора платежа
	 * @param string $value значение
	 */
	public function setOrder($value)
	{
		$this->_class->order = $value;
	}

	/**
	 * Установка суммы платежа
	 * @param string $value значение
	 */
	public function setAmount($value)
	{
		$this->_class->amount = $value;
	}

	/**
	 * Установка валюты платежа
	 * @param string $value значение
	 */
	public function setCurrency($value)
	{
		$this->_class->currency = $value;
	}

	/**
	 * Установка описания платежа
	 * @param string $value значение
	 */
	public function setDescription($value)
	{
		$this->_class->description = $value;
	}

	/**
	 * Отправка платежа
	 */
	public function toSend()
	{
		$this->_class->toSend();
	}

	/**
	 * Получение платежного класса
	 * @param string $class класс
	 * @return string
	 * @throws CException
	 */
	private function getPaymentClass($class)
	{
		$className = ucfirst($class);

		if (!class_exists($className))
			throw new CException('Платежная система "' . $class . '" не найдена!');

		return $className;
	}

	/**
	 * Получение адаптера платежной системы
	 * @param string $class класс
	 * @return string
	 * @throws CException
	 */
	private function getPaymentAdapterClass($class)
	{
		$className = $class . 'Adapter';

		if (!class_exists($className))
			throw new CException('Адаптер платежной системы ' . $class . ' не найден!');

		return $className;
	}

}

