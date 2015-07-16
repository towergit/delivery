<?php
// название страницы
$this->pageTitle = Yii::t('gallery', 'Редактирование категории галереи');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('gallery', 'Галерея'),
    Yii::t('gallery', 'Категории галереи')                => array( 'index' ),
    Yii::t('gallery', 'Редактирование категории галереи') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>