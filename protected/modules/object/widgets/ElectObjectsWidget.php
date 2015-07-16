<?php

/**
 * Избранные объекты
 *
 * @category Widget
 * @package  Module.Object
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ElectObjectsWidget extends CWidget
{

    /**
     * @var integer лимит 
     */
    public $limit = 6;

    /**
     * Запуск виджета
     */
    public function run()
    {
        $models = ObjectHelp::model()->elect()->findAll(array(
            'limit' => $this->limit,
            'order' => 'sort',
        ));

        if ($models === null)
            return false;

        $this->render('electobject', array(
            'models' => $models,
        ));
    }

}

