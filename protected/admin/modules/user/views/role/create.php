<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Создание роли');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Роли пользователей') => array( 'index' ),
    Yii::t('user', 'Создание роли')      => array( 'create' ),
);

$this->renderPartial('_form', array(
    'model'      => $model,
    'operations' => $operations,
    'childrens'  => $childrens,
));
?>