<?php
// название страницы
$this->pageTitle = Yii::t('faq', 'Редактирование FAQ');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('faq', 'FAQ'),
    Yii::t('faq', 'Список FAQ')         => array( 'index' ),
    Yii::t('faq', 'Редактирование FAQ') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array(
    'model'    => $model,
    'category' => $category,
));
?>