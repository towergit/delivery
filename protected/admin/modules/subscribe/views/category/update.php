<?php
// название страницы
$this->pageTitle = Yii::t('material', 'Редактирование категории материалов');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('material', 'Материалы'),
    Yii::t('material', 'Категории материалов')                => array( 'index' ),
    Yii::t('material', 'Редактирование категории материалов') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>