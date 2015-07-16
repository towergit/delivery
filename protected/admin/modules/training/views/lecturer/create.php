<?php
// название страницы
$this->pageTitle = Yii::t('training', 'Создание преподавателя');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('training', 'Обучающая прогамма'),
    Yii::t('training', 'Список преподавателей')  => array( 'index' ),
    Yii::t('training', 'Создание преподавателя') => array( 'create' ),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>