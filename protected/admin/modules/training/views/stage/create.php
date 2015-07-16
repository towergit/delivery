<?php
// название страницы
$this->pageTitle = Yii::t('training', 'Создание стадии обучения');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('training', 'Обучающая программа'),
    Yii::t('training', 'Стадии обучения')          => array( 'index' ),
    Yii::t('training', 'Создание стадии обучения') => array( 'create' ),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>