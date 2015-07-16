<?php
// название страницы
$this->pageTitle = Yii::t('share', 'Редактирование типа акции');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('share', 'Акции'),
    Yii::t('share', 'Типы акций')                => array( 'index' ),
    Yii::t('share', 'Редактирование типа акции') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>