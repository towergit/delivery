<?php
// название страницы
$this->pageTitle = Yii::t('menu', 'Редактирование пункта меню');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('menu', 'Управление меню')            => $this->createUrl('/menu/menu/index'),
    Yii::t('menu', 'Редактирование пункта меню') => $this->createUrl('update', array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>