<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Создание преподавателя');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Преподаватели')          => array( 'index' ),
    Yii::t('user', 'Создание преподавателя') => array( 'create' ),
);

$this->renderPartial('_form', array(
    'model'   => $model,
    'profile' => $profile,
    'roles'   => $roles
));
?>