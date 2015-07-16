<?php

/**
 * API Payeer
 *
 * @category Component
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class Payeer extends CComponent
{
	const ACTION	 = '//payeer.com/merchant/';
	const M_SHOP	 = '23322920';
	const M_KEY		 = '1234567890';

	/**
	 * @var string идентификатор платежа
	 */
	private $_m_orderid;

	/**
	 * @var float сумма платежа
	 */
	private $_m_amount;

	/**
	 * @var string валюта платежа
	 */
	private $_m_curr = 'USD';

	/**
	 * @var string описание платежа
	 */
	private $_m_desc = '';

	/**
	 * @var string электронная подпись 
	 */
	private $_m_sign;
	
	/**
	 * Получение идентификатора платежа
	 * @return string
	 */
	public function getM_orderid()
	{
		return $this->_m_orderid;
	}

	/**
	 * Установка идентификатора платежа
	 * @param string $value значение
	 * @throws CException
	 */
	public function setM_orderid($value)
	{
		if (!preg_match('#^[A-z_0-9]+$#', $value))
			throw new CException('Поле "m_orderid" должно состоять из "A-z", "_", "0-9"');

		if (strlen($value) > 32)
			throw new CException('Длина поля "m_orderid" не должна привышать 32 символа');

		$this->_m_orderid = $value;
	}

	/**
	 * Получение суммы платежа
	 * @return float
	 */
	public function getM_amount()
	{
		return $this->_m_amount;
	}

	/**
	 * Установка cуммы платежа
	 * @param string $value значение
	 * @throws CException
	 */
	public function setM_amount($value)
	{
		if ($value <= 0)
			throw new CException('Поле "m_amount" должно быть больше 0');
		
		if (strpos($value, ','))
			$value = str_replace(',', '.', $value);

		$this->_m_amount = number_format($value, 2, '.', '');
	}

	/**
	 * Получение валюты платежа
	 * @return string
	 */
	public function getM_curr()
	{
		return $this->_m_curr;
	}

	/**
	 * Установка валюты платежа
	 * @param string $value значение
	 * @throws CException
	 */
	public function setM_curr($value)
	{
		if (!in_array($value, $this->currencyList))
			throw new CException('Поле "m_curr" должно состоять из возможных валют "USD, RUB, EUR"');

		$this->_m_curr = $value;
	}

	/**
	 * Получение описания платежа
	 * @return string
	 */
	public function getM_desc()
	{
		return $this->_m_desc;
	}

	/**
	 * Установка описания платежа
	 * @param string $value значение
	 */
	public function setM_desc($value)
	{
		$this->_m_desc = base64_encode($value);
	}

	/**
	 * Получение электронной подписи 
	 * @return string
	 */
	public function getM_sign()
	{
		return $this->_m_sign;
	}
	
	/**
	 * Установка электронной подписи
	 * @param array $arHash массив значений
	 */
	public function setM_sign($arHash)
	{
		$this->_m_sign = strtoupper(hash('sha256', implode(":", $arHash)));
	}

	/**
	 * Отправка платежа
	 */
	public function toSend()
	{
		if ($this->isCheckValid())
		{
			$this->m_sign = array(
				self::M_SHOP,
				$this->_m_orderid,
				$this->_m_amount,
				$this->_m_curr,
				$this->m_desc,
				self::M_KEY
			);
			
			echo '<form id="payeer" method="GET" action="' . self::ACTION . '">
					<input type="hidden" name="m_shop" value="' . self::M_SHOP . '">
					<input type="hidden" name="m_orderid" value="' . $this->m_orderid . '">
					<input type="hidden" name="m_amount" value="' . $this->m_amount . '">
					<input type="hidden" name="m_curr" value="' . $this->m_curr . '">
					<input type="hidden" name="m_desc" value="' . $this->m_desc . '">
					<input type="hidden" name="m_sign" value="' . $this->m_sign . '">
				</form>
				<script>
					document.getElementById("payeer").submit();
				</script>';
		}
	}

	/**
	 * Получение списка валют
	 * @return array
	 */
	protected function getCurrencyList()
	{
		return array(
			'USD',
			'RUB',
			'EUR',
		);
	}
	
	/**
	 * Проверка на валидность
	 * @return boolean
	 * @throws CException
	 */
	private function isCheckValid()
	{
		if (!self::M_SHOP)
			throw new CException('Не указан идентификатор магазина');

		if (!self::M_KEY)
			throw new CException('Не указан секретный ключ');

		if (!self::ACTION)
			throw new CException('Не указан URL мерчанта');

		if (!$this->_m_orderid)
			throw new CException('Не указан идентификатор платежа');

		if (!$this->_m_amount)
			throw new CException('Не указана сумма платежа');

		if (!$this->_m_curr)
			throw new CException('Не указана валюта платежа');

		return true;
	}

}

