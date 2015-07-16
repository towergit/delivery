<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Создание управляющего');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Управляющие')           => array( 'index' ),
    Yii::t('user', 'Создание управляющего') => array( 'create' ),
);

$this->renderPartial('_form', array(
    'model'      => $model,
    'profile'    => $profile,
    'roles'      => $roles,
    'operations' => $operations,
));
?>