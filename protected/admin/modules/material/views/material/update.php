<?php
// название страницы
$this->pageTitle = Yii::t('material', 'Редактирование материала');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('material', 'Материалы'),
    Yii::t('material', 'Список материалов')        => array( 'index' ),
    Yii::t('material', 'Редактирование материала') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array(
    'model'    => $model,
    'category' => $category,
));
?>