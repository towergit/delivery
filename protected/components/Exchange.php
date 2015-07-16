<?php

require_once dirname(__FILE__) . '/../extensions/SimpleHtmlDom.php';

/**
 * Курс валют
 *
 * @category Widget
 * @package  Component
 * @author   Vlad Lotysh <lotysh.vm@gmail.com>
 */
class Exchange {

    /**
     * Запуск виджета
     */
    public static function daily($code = 'UAH') {


        $methodName = "get" . $code . "Exachange";
        $exchangeObject = new self;
        $result = null;

        if (method_exists($exchangeObject, $methodName))
            $result = $exchangeObject->{$methodName}($code);

        return $result;
    }

    public static function currencyList() {
        $model = new Currency;
        $list = $model->findAll();
        return CHtml::listData($list, 'id', 'name');
    }

    protected function getUAHExachange($code) {

        $html = file_get_html('https://privatbank.ua/ru/');

        $cacheval = Yii::app()->cache->get($code . date('Ymd'));

        if ($cacheval) {
            $uahexhange = $cacheval;
        } else {
            $tr = $html->find('#selectByPB tr');
            $i = 1;
            foreach ($tr as $t) {
                foreach ($t as $nodet) {
                    if (is_array($nodet)) {
                        if (isset($nodet[0]))
                            if (isset($nodet[0]->innertext)) {
                                if ($nodet[0]->innertext == 'USD/UAH') {
                                    $uahexhange = floatval(str_replace(',', '.', $nodet[2]->innertext));
                                    Yii::app()->cache->set($code . date('Ymd'), $uahexhange, 56000);
                                }
                            }
                    }
                }
            }
        }

        return $uahexhange;
    }

    protected function getRUBExachange($code) {

        $cacheval = Yii::app()->cache->get($code . date('Ymd'));
        if ($cacheval) {
            $uahexhange = $cacheval;
        } else {

            $html = file_get_html('http://www.banki.ru/products/currency/rub/');
            $tr = $html->find('.currency-value__slot__value__num');

            if (isset($tr[0]) || isset($tr[0]->innertext)) {

                $uahexhange = floatval(str_replace(',', '.', $tr[0]->innertext));
                Yii::app()->cache->set($code . date('Ymd'), $uahexhange, 56000);
            }
        }

        return $uahexhange;
    }

}
