<?php
// название страницы
$this->pageTitle = Yii::t('gallery', 'Создание категории галереи');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('gallery', 'Галерея'),
    Yii::t('gallery', 'Категории галереи')          => array( 'index' ),
    Yii::t('gallery', 'Создание категории галереи') => array( 'create' ),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>