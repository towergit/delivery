<?php
// название страницы
$this->pageTitle = Yii::t('language', 'Редактирование языка');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('language', 'Языки')                => array( 'index' ),
    Yii::t('language', 'Редактирование языка') => $this->createUrl('update', array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>