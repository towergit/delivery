<?php 
// название страницы
$this->pageTitle = Yii::t('menu', 'Создание меню');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('menu', 'Управление меню'),
    Yii::t('menu', 'Список меню') => array( 'index' ),
    Yii::t('menu', 'Создание меню')   => array( 'create' ),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>