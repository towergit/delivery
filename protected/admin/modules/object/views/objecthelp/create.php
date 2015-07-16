<?php

$category = ObjectCategory::model();
        
// название страницы
$this->pageTitle = Yii::t('objecthelp', 'Создание Объекта помощи');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('objecthelp', 'Объекты'),
    Yii::t('objecthelp', 'Список объектов')        => array( 'index' ),
    Yii::t('objecthelp', 'Зодарие объекта') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form',
    array(
    'model'      => $model,
    'category' => $category,
));
?>

