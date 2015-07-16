<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Редактирование задачи');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Задачи пользователей') => array( 'index' ),
    Yii::t('user', 'Редактирование задачи')      => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>