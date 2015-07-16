<?php
// название страницы
$this->pageTitle = Yii::t('material', 'Редактирование платежа');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('material', 'Платежи'),
    Yii::t('material', 'Список платедей')        => array( 'index' ),
    Yii::t('material', 'Редактирование платежа') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array(
    'model'    => $model,
));
?>