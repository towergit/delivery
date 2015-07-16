<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Создание задачи');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Задачи пользователей') => array( 'index' ),
    Yii::t('user', 'Создание задачи')      => array( 'create' ),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>