<?php 
// название страницы
$this->pageTitle = Yii::t('faq', 'Создание категории FAQ');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('faq', 'FAQ'),
    Yii::t('faq', 'Категории FAQ') => array( 'index' ),
    Yii::t('faq', 'Создание категории FAQ')   => array( 'create' ),
);
        
$this->renderPartial('_form', array( 'model' => $model ));
?>