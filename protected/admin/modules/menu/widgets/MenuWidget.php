<?php

/**
 * Меню
 * Виджет вывода меню на сайте
 *
 * @category Widget
 * @package  Module.Menu
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class MenuWidget extends CWidget
{

    /**
     * @var string уникальное код 
     */
    public $code;

    /**
     * @var integer c какого уровня выводить меню
     * По умолчанию 0 - корень меню
     */
    public $parent_id = 0;

    /**
     * @var array параметры виджета CMenu 
     */
    public $params = array();

    /**
     * @var array параметры передаваемые в меню 
     */
    public $layoutParams = array();

    /**
     * Запуск виджета
     */
    public function run()
    {
        $this->params['items'] = Menu::model()->getItems($this->code, $this->parent_id);

        $this->render('menu', array(
            'params'       => $this->params,
            'layoutParams' => $this->layoutParams,
        ));
    }

}

