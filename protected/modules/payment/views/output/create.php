<?php
// название страницы
$this->pageTitle = Yii::t('payment', 'Создание заявок на вывод средств');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('payment', 'Платежи'),
    Yii::t('payment', 'Заявки на вывод средств')          => array( 'index' ),
    Yii::t('payment', 'Создание заявок на вывод средств') => array( 'create' ),
);

$this->renderPartial('_form',
    array(
    'model'         => $model,
    'user'          => $user,
    'paymentPurse'  => $paymentPurse,
    'paymentSystem' => $paymentSystem,
));
?>