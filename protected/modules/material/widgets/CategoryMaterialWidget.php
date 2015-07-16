<?php

/**
 * Категории материалов
 *
 * @category Widget
 * @package  Module.Material
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CategoryMaterialWidget extends CWidget
{

    /**
     * Запуск виджета
     */
    public function run()
    {
        $category = MaterialCategory::model()->findByAttributes(array( 'alias' => 'blog' ));

        $criteria            = new CDbCriteria;
        $criteria->condition = 'parent_id = :parent_id';
        $criteria->params    = array( ':parent_id' => (int) $category->id );
        $criteria->order     = 'sort';

        $models = MaterialCategory::model()->findAll($criteria);
        
        if (!$models)
            return false;
            
        $this->render('categorymaterial', array(
            'models' => $models,
        ));
    }

}

