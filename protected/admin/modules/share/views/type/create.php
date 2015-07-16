<?php
// название страницы
$this->pageTitle = Yii::t('share', 'Создание типа акции');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('share', 'Акции'),
    Yii::t('share', 'Типы акций')          => array( 'index' ),
    Yii::t('share', 'Создание типа акции') => array( 'create' ),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>