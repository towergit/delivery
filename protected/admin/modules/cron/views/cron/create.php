<?php
// название страницы
$this->pageTitle = Yii::t('cron', 'Создание задачи');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('cron', 'Планировщик задач') => array( 'index' ),
    Yii::t('cron', 'Создание задачи')   => array( 'create' ),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>