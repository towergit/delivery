<?php
// название страницы
$this->pageTitle = Yii::t('material', 'Создание платежа');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('material', 'Платежи'),
    Yii::t('material', 'Список платежей')  => array( 'index' ),
    Yii::t('material', 'Создание платежа') => array( 'create' ),
);

$this->renderPartial('_form', array(
    'model'    => $model,
));
?>