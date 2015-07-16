<?php
// название страницы
$this->pageTitle = Yii::t('ticket', 'Создание категории тикетов');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('ticket', 'Тикеты'),
    Yii::t('ticket', 'Категории тикетов')          => array( 'index' ),
    Yii::t('ticket', 'Создание категории тикетов') => array( 'create' ),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>