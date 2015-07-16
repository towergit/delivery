<?php
// название страницы
$this->pageTitle = Yii::t('main', 'Ошибка');

// хлебные крошки
$this->breadcrumbs = array(
    $message,
);
?>

<div class="container error">
    <div class="row">
        <h1><?php echo $code; ?></h1>
        <h3><?php echo CHtml::encode($message); ?></h3>
        <p>
            Наши интересы и цели выходят далеко за пределы. Мы знаем, что путь к настоящему успеху, на самом <br />
            деле, лежит не через удачную карьеру.
        </p>
        <a href="<?php echo $this->createUrl('/default/index'); ?>">
            <?php echo Yii::t('main', 'Вернуться на главную'); ?>
        </a>
    </div>
</div>