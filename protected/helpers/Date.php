<?php

/**
 * Хелпер, содержащий самые необходимые функции для работы с датами
 *
 * @category Helper
 * @package  Helpers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class Date
{
    /**
     * Формат даты
     * @param integer $date дата
     * @param string $format формат
     * @return string
     */
    public static function format($date, $format = 'dd.MM.y, HH:mm')
    {
        return $date != 0 ? Yii::app()->dateFormatter->format($format, $date) : '';
    }

}

