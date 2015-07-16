<?php
// название страницы
$this->pageTitle = Yii::t('payment', 'Редактирование платежной системы');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('payment', 'Платежи'),
    Yii::t('payment', 'Платежные системы')                => array( 'index' ),
    Yii::t('payment', 'Редактирование платежной системы') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>