<?php

/**
 * Глобальный поиск
 *
 * @category Widget
 * @package  Module.Search
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class GlobalSearchWidget extends CWidget
{
    /**
     * Запуск виджета
     */
    public function run()
    {
        $form = new SearchForm;

        $this->render('globalsearch', array(
            'form' => $form,
        ));
    }

}

