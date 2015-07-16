<?php

/**
 * Общие
 *
 * @category Helper
 * @package  Helpers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class General
{
    /**
     * Денежный формат
     * @param float $sum сумма
     * @return string
     */
    public static function numberFormat($sum, $decimals = 0)
    {
        return number_format($sum, $decimals, '.', ',');
    }

}

