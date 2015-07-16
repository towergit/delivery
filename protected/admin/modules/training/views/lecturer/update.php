<?php
// название страницы
$this->pageTitle = Yii::t('training', 'Редактирование преподавателя');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('training', 'Обучающая прогамма'),
    Yii::t('training', 'Список преподавателей')        => array( 'index' ),
    Yii::t('training', 'Редактирование преподавателя') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>