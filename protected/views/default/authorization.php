<?php
// название страницы
$this->pageTitle = Yii::t('main', Yii::t('main', 'Участвовать в проекте'));

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('main', 'Участвовать в проекте'),
);
?>

<div id="tabs" class="container was-patron">
    <div class="row">
        <ul>
            <li class="col-md-4 login-head">
                <a href="#login"><?php echo Yii::t('main', 'Войти'); ?></a>
            </li>
            <li class="col-md-4 login-head">
                <a href="#registration"><?php echo Yii::t('main', 'Зарегистрироваться'); ?></a>
            </li>
            <li class="col-md-4 login-head">
                <a href="#restore"><?php echo Yii::t('main', 'Восстановить доступ'); ?></a>
            </li>
        </ul>
    </div>				
    <div id="login" class="login">
        <?php echo $this->renderPartial('authorization/login'); ?>
    </div>
    <div id="registration" class="login">
        <?php echo $this->renderPartial('authorization/registration'); ?>
    </div>
    <div id="restore" class="login">
        <?php echo $this->renderPartial('authorization/restore'); ?>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScript(uniqid(),
    "
        $(function() {
            $('#tabs').tabs();
        });
    ", CClientScript::POS_END);
?>