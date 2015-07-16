<?php
// название страницы
$this->pageTitle = Yii::t('event', 'Создание события');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('event', 'События'),
    Yii::t('event', 'Список событий')   => array( 'index' ),
    Yii::t('event', 'Создание события') => array( 'create' ),
);

$this->renderPartial('_form', array(
    'model'    => $model,
    'category' => $category,
));
?>