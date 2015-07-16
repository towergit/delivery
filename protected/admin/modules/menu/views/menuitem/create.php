<?php
// название страницы
$this->pageTitle = Yii::t('menu', 'Создание пункта меню');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('menu', 'Управление меню')      => $this->createUrl('/menu/menu/index'),
    Yii::t('menu', 'Создание пункта меню') => array( 'create' ),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>