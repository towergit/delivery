<?php
// название страницы
$this->pageTitle = Yii::t('material', 'Создание материала');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('material', 'Материалы'),
    Yii::t('material', 'Список материалов')  => array( 'index' ),
    Yii::t('material', 'Создание материала') => array( 'create' ),
);

$this->renderPartial('_form', array(
    'model'    => $model,
    'category' => $category,
));
?>