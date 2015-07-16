<?php 
// название страницы
$this->pageTitle = Yii::t('event', 'Создание категории событий');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('event', 'События'),
    Yii::t('event', 'Категории событий') => array( 'index' ),
    Yii::t('event', 'Создание категории событий')   => array( 'create' ),
);
        
$this->renderPartial('_form', array( 'model' => $model ));
?>