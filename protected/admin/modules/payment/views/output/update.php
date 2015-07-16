<?php
// название страницы
$this->pageTitle = Yii::t('payment', 'Редактирование заявок на вывод средств');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('payment', 'Платежи'),
    Yii::t('payment', 'Заявки на вывод средств')                => array( 'index' ),
    Yii::t('payment', 'Редактирование заявок на вывод средств') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form',
    array(
    'model'         => $model,
    'user'          => $user,
    'paymentPurse'  => $paymentPurse,
    'paymentSystem' => $paymentSystem,
));
?>