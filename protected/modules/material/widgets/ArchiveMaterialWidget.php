<?php

/**
 * Архив материалов
 *
 * @category Widget
 * @package  Module.Material
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ArchiveMaterialWidget extends CWidget
{

    /**
     * Запуск виджета
     */
    public function run()
    {
        $models = Material::model()->findAllBySql('SELECT FROM_UNIXTIME(publish_date, "%Y") AS publish_date FROM {{material}} GROUP BY FROM_UNIXTIME(publish_date, "%Y")');
        
        if (!$models)
            return false;
            
        $this->render('archivematerial', array(
            'models' => $models,
        ));
    }

}

