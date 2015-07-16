<?php
// название страницы
$this->pageTitle = Yii::t('training', 'Редактирование стадии обучения');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('training', 'Обучающая программа'),
    Yii::t('training', 'Стадии обучения')                => array( 'index' ),
    Yii::t('training', 'Редактирование стадии обучения') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>