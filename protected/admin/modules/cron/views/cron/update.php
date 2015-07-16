<?php
// название страницы
$this->pageTitle = Yii::t('cron', 'Редактирование задачи');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('cron', 'Планировщик задач')     => array( 'index' ),
    Yii::t('cron', 'Редактирование задачи') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>