<?php
// название страницы
$this->pageTitle = Yii::t('menu', 'Редактирование меню');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('menu', 'Управление меню'),
    Yii::t('menu', 'Список меню')         => array( 'index' ),
    Yii::t('menu', 'Редактирование меню') => array( 'update', 'id' => Yii::app()->request->getQuery('id') ),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>