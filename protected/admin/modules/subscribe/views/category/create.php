<?php 
// название страницы
$this->pageTitle = Yii::t('material', 'Создание категории материалов');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('material', 'Материалы'),
    Yii::t('material', 'Категории материалов') => array( 'index' ),
    Yii::t('material', 'Создание категории материалов')   => array( 'create' ),
);
        
$this->renderPartial('_form', array( 'model' => $model ));
?>