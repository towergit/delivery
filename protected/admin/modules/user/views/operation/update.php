<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Редактирование операции');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Операции пользователей') => array( 'index' ),
    Yii::t('user', 'Редактирование операции')      => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array(
    'model'  => $model,
    'module' => $module,
));
?>