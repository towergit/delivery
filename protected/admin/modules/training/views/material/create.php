<?php
// название страницы
$this->pageTitle = Yii::t('training', 'Создание материала');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('training', 'Обучающая прогамма'),
    Yii::t('training', 'Список материалов')  => array( 'index' ),
    Yii::t('training', 'Создание материала') => array( 'create' ),
);

$this->renderPartial('_form', array(
    'model'    => $model,
    'stage'    => $stage,
    'educator' => $educator,
    'program'  => $program,
));
?>