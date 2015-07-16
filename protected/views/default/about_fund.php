<?php

// название страницы
$this->pageTitle = Yii::t('main', Yii::t('main', 'О фонде'));

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('main', 'О фонде'),
);

$this->showHeadering = false;
?>
<div class="container about-fund">
    <div class="row">
        <div class="col-md-12">
            <?php echo $model->text; ?>
        </div>
    </div>
</div>