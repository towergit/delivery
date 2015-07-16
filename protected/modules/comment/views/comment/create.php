<?php
// название страницы
$this->pageTitle = Yii::t('comment', 'Создание комментария');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('comment', 'Комментарии')          => array( 'index' ),
    Yii::t('comment', 'Создание комментария') => array( 'create' ),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>