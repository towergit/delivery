<?php
// название страницы
$this->pageTitle = Yii::t('gallery', 'Создание изображения галереи');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('gallery', 'Галерея'),
    Yii::t('gallery', 'Список изображений')           => array( 'index' ),
    Yii::t('gallery', 'Создание изображения галереи') => array( 'create' ),
);

$this->renderPartial('_form', array(
    'model'    => $model,
    'category' => $category,
));
?>