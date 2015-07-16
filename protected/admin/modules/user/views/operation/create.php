<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Создание операции');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Операции пользователей') => array( 'index' ),
    Yii::t('user', 'Создание операции')      => array( 'create' ),
);

$this->renderPartial('_form', array(
    'model'  => $model,
    'module' => $module,
));
?>