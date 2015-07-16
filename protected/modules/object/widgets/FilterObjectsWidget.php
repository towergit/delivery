<?php

/**
 * Фильтр
 *
 * @category Widget
 * @package  Module.Object
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class FilterObjectsWidget extends CWidget
{

    public $alias;

    /**
     * Запуск виджета
     */
    public function run()
    {
        $models = ObjectCategory::model()->active()->findAll(array('order'=>'sort'));

        if (!$models)
            return false;

        $params = CHtml::listData($models, 'alias', 'title');
        $params = array( 'all' => Yii::t('main', 'Все') ) + $params;

        $this->render('filterobjects', array(
            'params' => $params,
            'alias'  => $this->alias,
        ));
    }

}

