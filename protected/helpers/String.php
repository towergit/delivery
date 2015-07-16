<?php

/**
 * Хелпер, содержащий самые необходимые функции для работы с текстом
 *
 * @category Helper
 * @package  Helpers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class String
{
    /**
     * Транслитерация
     * @param string $str строка
     * @return string
     */
    public static function translit($str)
    {
        $str = str_replace(' ', '-', $str);
        $str = str_replace('_', '-', $str);
        $tr  = array(
            "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
            "Д" => "D", "Е" => "E", "Ж" => "J", "З" => "Z", "И" => "I",
            "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
            "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
            "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH",
            "Ш" => "SH", "Щ" => "SCH", "Ъ" => "", "Ы" => "YI", "Ь" => "",
            "Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "j",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "y",
            "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya",
        );
        $str = strtolower(strtr($str, $tr));
        $str = preg_replace('/[^0-9a-z\-]/', '', $str);
        return $str;
    }
    
    /**
     * Обрезать текст до определенного колиства слов, добавив в конце "..."
     * @param string $str строка для обрезания
     * @param integer $limit до скольких символов обрезать строку
     * @param string $end_char окончание текста
     * @return type
     */
    public static function wordLimiter($str, $limit = 100, $end_char = '&#8230;')
    {
        if (trim($str) == '')
            return $str;
        
        $str = strip_tags($str);
        
        preg_match('/^\s*+(?:\S++\s*+){1,' . (int) $limit . '}/', $str, $matches);
        
        if (mb_strlen($str) == mb_strlen($matches[0]))
            $end_char = '';
        
        return rtrim($matches[0]) . $end_char;
    }

    /**
     * Строка в массив
     * @param mixed $string строка
     * @param string $delimiter разделитель
     * @return array
     */
    public static function stringToArray($string, $delimiter = ', ')
    {
        if (!$string)
            return array();
            
        if (!is_array($string))
            $string = explode($delimiter, $string);
        else
            return $string;

        return $string;
    }
    
    public static function arrayToString($array)
    {
        if (!is_array($array))
            return $array;
        
        $str = '';
        
        foreach($array as $item)
            $str .= $item . ', ';
        
        $str = substr($str, 0, -2);
        
        return $str;
    }

    /**
     * Создание ссылки на сайт
     * @param string $string ссылка
     * @param string $target
     * @return string
     */
    public static function createUrlLink($string, $target = '_blank')
    {
        $siteUrl = preg_replace('#https?://(w{3}\.)?#i', '', $string);
        $params  = array();

        if ($target)
            $params['target'] = $target;

        return CHtml::link($siteUrl, $string, $params);
    }

}

