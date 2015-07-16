<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Редактирование роли');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Роли пользователей')  => array( 'index' ),
    Yii::t('user', 'Редактирование роли') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form',
    array(
    'model'      => $model,
    'operations' => $operations,
    'childrens'  => $childrens,
));
?>