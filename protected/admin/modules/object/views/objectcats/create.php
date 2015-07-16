<?php
        
// название страницы
$this->pageTitle = Yii::t('objecthelp', 'Создание пакета к объекту помощи');


// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('objecthelp', 'Объекты'),
    Yii::t('objecthelp', 'Список категорий')        => array( 'index' ),
    Yii::t('objecthelp', 'Создание категорий') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form',
    array(
    'model'      => $model
));
?>

