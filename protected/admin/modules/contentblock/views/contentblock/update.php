<?php
// название страницы
$this->pageTitle = Yii::t('contentblock', 'Редактирование блока контента');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('contentblock', 'Блоки контента')                => array( 'index' ),
    Yii::t('contentblock', 'Редактирование блока контента') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);

$this->renderPartial('_form', array( 'model' => $model ));
?>