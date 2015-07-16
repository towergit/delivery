<?php
// название страницы
$this->pageTitle = Yii::t('ticket', 'Редактирование категории тикетов');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('ticekt', 'Тикеты'),
    Yii::t('ticket', 'Категории тикетов')                => array( 'index' ),
    Yii::t('ticket', 'Редактирование категории тикетов') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>