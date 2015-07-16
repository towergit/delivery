<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Создание абитуриента');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Абитуриенты')          => array( 'index' ),
    Yii::t('user', 'Создание абитуриента') => array( 'create' ),
);

$this->renderPartial('_form', array(
    'model'   => $model,
    'profile' => $profile,
    'roles'   => $roles
));
?>