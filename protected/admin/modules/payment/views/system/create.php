<?php
// название страницы
$this->pageTitle = Yii::t('payment', 'Создание платежной системы');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('payment', 'Платежи'),
    Yii::t('payment', 'Платежные системы')          => array( 'index' ),
    Yii::t('payment', 'Создание платежной системы') => array( 'create' ),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>