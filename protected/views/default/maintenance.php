<?php
// название страницы
$this->pageTitle = Yii::t('main', 'На стадии разработки');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('main', 'На стадии разработки')
);
$this->showHeadering = false;
?>

<div class="container error">
    <div class="row">
        <h2><?php echo Yii::t('main', 'Данный контент<br />на стадии разработки'); ?></h2>
        <p>
            Наши интересы и цели выходят далеко за пределы. Мы знаем, что путь к настоящему успеху, на самом<br />
            деле, лежит не через удачную карьеру.
        </p>
        <a href="<?php echo $this->createUrl('/default/index'); ?>">
            <?php echo Yii::t('main', 'Вернуться на главную'); ?>
        </a>
    </div>
</div>