<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Создание слушателя');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Слушатели')          => array( 'index' ),
    Yii::t('user', 'Создание слушателя') => array( 'create' ),
);

$this->renderPartial('_form', array(
    'model'   => $model,
    'profile' => $profile,
    'roles'   => $roles
));
?>