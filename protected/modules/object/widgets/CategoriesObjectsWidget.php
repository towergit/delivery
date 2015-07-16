<?php

/**
 * Категории объектов
 *
 * @category Widget
 * @package  Module.Object
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CategoriesObjectsWidget extends CWidget
{

    /**
     * Запуск виджета
     */
    public function run()
    {
        $models = ObjectCategory::model()->active()->findAll(array('order'=>'sort'));

        if (!$models)
            return false;
        
        $params = CHtml::listData($models, 'alias', 'title');
       // active category:
       $link='';
       if (isset($_GET['alias'])):
       $criteria = new CDbCriteria();
       	$criteria->with=array('objects');
       	$criteria->compare('objects.alias', $_GET['alias']);
       	$link = ObjectCategory::model()->find($criteria);
       	endif;
       // end;
        $this->render('categoriesobjects', array(
            'params' => $params,
        	'link'=>$link,
        ));
    }

}

