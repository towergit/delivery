<?php
// название страницы
$this->pageTitle = Yii::t('payment', 'Создание кошелька платежной системы');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('payment', 'Платежи'),
    Yii::t('payment', 'Кошельки платежных систем')          => array( 'index' ),
    Yii::t('payment', 'Создание кошелька платежной системы') => array( 'create' ),
);

$this->renderPartial('_form', array(
    'model'         => $model,
    'paymentSystem' => $paymentSystem,
));
?>