<?php

/**
 * Адаптер для платежной системы PerfectMoney
 *
 * @category Component
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class PerfectMoneyAdapter extends CPaymentAdapter
{
	/**
	 * @var object объект
	 */
	private $_object;
	
	/**
	 * Конструктор
	 * @param PerfectMoney $object объект
	 */
	public function __construct(PerfectMoney $object)
	{
		$this->_object = $object;
	}
	
	/**
	 * Отправка платежа
	 */
	public function toSend()
	{
		$this->_object->toSend();
	}
}