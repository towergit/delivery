<?php

/**
 * Адаптер для платежной системы Payeer
 *
 * @category Component
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class PayeerAdapter extends CComponent implements CPaymentAdapter
{
	/**
	 * @var object объект
	 */
	private $_object;
	
	/**
	 * Конструктор
	 * @param Payeer $object
	 */
	public function __construct(Payeer $object)
	{
		$this->_object = $object;
	}
	
	/**
	 * Установка идентификатора платежа
	 * @param string $value
	 */
	public function setOrder($value)
	{
		$this->_object->m_orderid = $value;
	}
	
	/**
	 * Установка cуммы платежа
	 * @param string $value
	 */
	public function setAmount($value)
	{
		$this->_object->m_amount = $value;
	}
	
	/**
	 * Установка валюты платежа
	 * @param string $value
	 */
	public function setCurrency($value)
	{
		$this->_object->m_curr = $value;
	}
	
	/**
	 * Установка описания платежа
	 * @param string $value
	 */
	public function setDescription($value)
	{
		$this->_object->m_desc = $value;
	}
	
	/**
	 * Отправка платежа
	 */
	public function toSend()
	{
		$this->_object->toSend();
	}
}