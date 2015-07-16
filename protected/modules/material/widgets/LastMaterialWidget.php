<?php

/**
 * Последние материалы
 *
 * @category Widget
 * @package  Module.Material
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class LastMaterialWidget extends CWidget
{

    /**
     * @var string категория
     */
    public $category = null;

    /**
     * @var integer лимит 
     */
    public $limit = 10;

    /**
     * Запуск виджета
     */
    public function run()
    {
        $materials = array();
        
        if ($this->category !== null)
        {
            
            $category = MaterialCategory::model()->active()->findByAttributes(array( 'alias' => $this->category ));
                            
            if ($category != null) {
                            $criteria            = new CDbCriteria;
                $criteria->condition = 'parent_id = :parent_id OR id = :id';
                $criteria->params    = array( ':parent_id' => (int) $category->id, ':id' => (int) $category->id );
                $criteria->order     = 'sort';

                $categories = MaterialCategory::model()->findAll($criteria);

                $criteria2 = new CDbCriteria;
                $criteria2->addInCondition('category_id', CHtml::listData($categories, 'id', 'id'));
                $criteria2->limit = $this->limit;
                $criteria2->order = 'publish_date DESC';

                $materials = Material::model()->active()->findAll($criteria2);
                
            }

        }
        else
        {         
            $materials = Material::model()->active()->findAll(array(
                'limit' => $this->limit,
                'order' => 'publish_date DESC',
            ));
        }
        
        $this->render('lastmaterial', array(
            'materials' => $materials,
        ));
    }

}

