<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Редактирование слушателя');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Слушатели')                => array( 'index' ),
    Yii::t('user', 'Редактирование слушателя') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array(
    'model'   => $model,
    'profile' => $profile,
    'roles'   => $roles
));
?>