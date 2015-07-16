<?php

// название страницы
$this->pageTitle = Yii::t('objecthelp', 'Редктирование пакета к объекту помощи');


if($model->isNewRecord){
    $model->help_id = Yii::app()->request->getQuery('object_id') ? Yii::app()->request->getQuery('object_id') : null;

}

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('objecthelp', 'Объекты'),
    Yii::t('objecthelp', 'Список пакетов')        => array( 'index' ),
    Yii::t('objecthelp', 'Создание пакетов') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form',
    array(
    'model'      => $model
));
?>

