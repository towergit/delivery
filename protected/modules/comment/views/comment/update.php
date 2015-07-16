<?php
// название страницы
$this->pageTitle = Yii::t('comment', 'Редактирование комментария');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('comment', 'Комментарии')                => array( 'index' ),
    Yii::t('comment', 'Редактирование комментария') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>