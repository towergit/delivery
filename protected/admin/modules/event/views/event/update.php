<?php
// название страницы
$this->pageTitle = Yii::t('event', 'Редактирование события');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('event', 'События'),
    Yii::t('event', 'Список событий')         => array( 'index' ),
    Yii::t('event', 'Редактирование события') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array(
    'model'    => $model,
    'category' => $category,
));
?>