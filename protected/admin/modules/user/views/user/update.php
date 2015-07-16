<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Редактирование пользователя');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Список пользователей')        => array( 'index' ),
    Yii::t('user', 'Редактирование пользователя') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form',
    array(
    'model'      => $model,
    'profile'    => $profile,
    'roles'      => $roles,
    'operations' => $operations,
));
?>