<?php

/**
 * Основное меню
 *
 * @category Widget
 * @package  Component
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class MainMenuWidget extends CWidget
{
    /**
     * Запуск виджета
     */
    public function run()
    {
        $modules = Module::model()->findAll(array( 'order' => 'sort DESC' ));
        $items   = array();

        if (!$modules)
            return false;

        foreach($modules as $module)
        {
            if (Yii::app()->hasModule($module->name))
            {
                $m          = Yii::app()->getModule($module->name);
                $navigation = $m->navigation;
                
                if (count($navigation))
                    $items = CMap::mergeArray($navigation, $items);
            }
        }

        $this->render('mainmenu', array(
            'items' => $items,
        ));
    }

}

