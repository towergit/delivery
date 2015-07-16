<?php
// название страницы
$this->pageTitle = Yii::t('training', 'Редактирование материала');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('training', 'Обучающая прогамма'),
    Yii::t('training', 'Список материалов')        => array( 'index' ),
    Yii::t('training', 'Редактирование материала') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form',
    array(
    'model'    => $model,
    'stage'    => $stage,
    'educator' => $educator,
    'program'  => $program,
));
?>