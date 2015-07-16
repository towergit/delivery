<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Создание студента');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Студенты')           => array( 'index' ),
    Yii::t('user', 'Создание студента') => array( 'create' ),
);

$this->renderPartial('_form', array(
    'model'   => $model,
    'profile' => $profile,
    'roles'   => $roles
));
?>