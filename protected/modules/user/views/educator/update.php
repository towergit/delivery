<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Редактирование преподавателя');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Преподаватели')                => array( 'index' ),
    Yii::t('user', 'Редактирование преподавателя') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array(
    'model'   => $model,
    'profile' => $profile,
    'roles'   => $roles
));
?>