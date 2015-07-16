<?php

/**
 * Адаптер для платежных систем
 * Основная логика работы платежных систем
 * Отправка и получение данных
 *
 * @category Component
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
interface CPaymentAdapter
{
	/**
	 * Установка идентификатора платежа
	 * @param string $value
	 */
	public function setOrder($value);
	
	/**
	 * Установка cуммы платежа
	 * @param string $value
	 */
	public function setAmount($value);
	
	/**
	 * Установка валюты платежа
	 * @param string $value
	 */
	public function setCurrency($value);
	
	/**
	 * Установка описания платежа
	 * @param string $value
	 */
	public function setDescription($value);
	
	/**
	 * Отправка платежа
	 */
	public function toSend();
}