<?php
// название страницы
$this->pageTitle = Yii::t('training', 'Создание программы обучения');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('training', 'Обучающая программа'),
    Yii::t('training', 'Программа обучения')          => array( 'index' ),
    Yii::t('training', 'Создание программы обучения') => array( 'create' ),
);

$this->renderPartial('_form', array(
    'model'    => $model,
    'stage'    => $stage,
    'educator' => $educator,
));
?>