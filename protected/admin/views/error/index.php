<?php
// название страницы
$this->pageTitle = Yii::t('template', 'Ошибка');
?>

<h1><?php echo $code; ?></h1>
<h2><?php echo CHtml::encode($message); ?></h2>
<p>
    <a href="<?php echo Yii::app()->request->urlReferrer; ?>">
        <?php echo Yii::t('template', 'Вернуться назад'); ?>
    </a>
</p>