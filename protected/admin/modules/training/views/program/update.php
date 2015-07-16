<?php
// название страницы
$this->pageTitle = Yii::t('training', 'Редактирование программы обучения');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('training', 'Обучающая программа'),
    Yii::t('training', 'Программа обучения')                => array( 'index' ),
    Yii::t('training', 'Редактирование программы обучения') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array(
    'model'    => $model,
    'stage'    => $stage,
    'educator' => $educator,
));
?>