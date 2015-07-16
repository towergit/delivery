<?php
// название страницы
$this->pageTitle = Yii::t('contentblock', 'Создание блока контента');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('contentblock', 'Блоки контента')          => array( 'index' ),
    Yii::t('contentblock', 'Создание блока контента') => array( 'create' ),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>