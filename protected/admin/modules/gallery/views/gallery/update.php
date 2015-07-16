<?php
// название страницы
$this->pageTitle = Yii::t('gallery', 'Редактирование изображения галереи');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('gallery', 'Галерея'),
    Yii::t('gallery', 'Список изображений')                 => array( 'index' ),
    Yii::t('gallery', 'Редактирование изображения галереи') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array(
    'model'    => $model,
    'category' => $category,
));
?>