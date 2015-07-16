<?php
// название страницы
$this->pageTitle = Yii::t('payment', 'Редактирование кошелька платежной системы');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('payment', 'Платежи'),
    Yii::t('payment', 'Кошельки платежных систем')                 => array( 'index' ),
    Yii::t('payment', 'Редактирование кошелька платежной системы') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array(
    'model'         => $model,
    'paymentSystem' => $paymentSystem,
));
?>