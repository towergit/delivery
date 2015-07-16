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
     * @var integer лимит 
     */
    public $limit = 10;

    /**
     * Запуск виджета
     */
    public function run()
    {
        $materials = Material::model()->active()->findAll(array(
            'limit' => $this->limit,
            'order' => 'id DESC',
        ));

        $this->render('lastmaterial', array(
            'materials' => $materials,
        ));
    }

}

