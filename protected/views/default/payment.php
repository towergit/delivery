<?php
// название страницы
$this->pageTitle = Yii::t('main', Yii::t('main', 'Оказание помощи'));

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('main', 'Оказание помощи'),
);
?>

<?php
$stepsTab = array(
    /*1 => array(
        'title' => Yii::t('main', 'Авторизация')
    ),*/
    2 => array(
        'title' => Yii::t('main', 'Обзор и оплата')
    ),
    3 => array(
        'title' => Yii::t('main', 'Статус')
    ),
    4 => array(
        'title' => Yii::t('main', 'Благодарность')
    ),
        )
?>

<div id="tabs" class="container was-patron payment">
    <div class="row">
        <ul class="tabs" style="padding-left: 25%;">
         
            <?php foreach ($stepsTab as $key => $value): ?>
                <?php
                    if ($key == $step):
                        $active = 'ui-state-active';
                    else:
                        $active = false;
                    endif;
                    ?>    

                    <li class="col-md-3 login-head <?php echo $active; ?>">
                        <a href="javascript:void(0);">
                            <?php echo $value['title']; ?>
                        </a>
                    </li>

                <?php endforeach; ?>

        </ul>
    </div>
    <div id="step-1" class="login">
    <?php echo $this->renderPartial('payment/step_' . $step); ?>
    </div>
</div>