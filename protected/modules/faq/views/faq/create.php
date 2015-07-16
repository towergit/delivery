<?php
// название страницы
$this->pageTitle = Yii::t('faq', 'Создание FAQ');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('faq', 'FAQ'),
    Yii::t('faq', 'Список FAQ')   => array( 'index' ),
    Yii::t('faq', 'Создание FAQ') => array( 'create' ),
);

$this->renderPartial('_form', array(
    'model'    => $model,
    'category' => $category,
));
?>