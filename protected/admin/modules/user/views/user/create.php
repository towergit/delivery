<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Создание пользователя');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Список пользователей')  => array( 'index' ),
    Yii::t('user', 'Создание пользователя') => array( 'create' ),
);

$this->renderPartial('_form',
    array(
    'model'      => $model,
    'profile'    => $profile,
    'roles'      => $roles,
    'operations' => $operations,
));
?>