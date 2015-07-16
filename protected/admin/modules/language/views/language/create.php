<?php
// название страницы
$this->pageTitle = Yii::t('language', 'Создание языка');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('language', 'Языки')          => array( 'index' ),
    Yii::t('language', 'Создание языка') => array( 'create' ),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>