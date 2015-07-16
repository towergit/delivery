<?php
// название страницы
$this->pageTitle = Yii::t('event', 'Редактирование категории событий');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('event', 'События'),
    Yii::t('event', 'Категории событий')                => array( 'index' ),
    Yii::t('event', 'Редактирование категории событий') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>