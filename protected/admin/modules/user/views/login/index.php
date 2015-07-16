<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'login-form',
    'enableAjaxValidation' => true,
    'clientOptions'        => array(
        'validateOnSubmit' => true,
    ),
    )
);
?>
<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <div>
        <?php echo $form->textField($model, 'username', array( 'class' => 'form-control' )); ?>
        <?php $form->error($model, 'username'); ?>
    </div>
</div>
<div class="form-group">
    <div>
        <?php echo $form->passwordField($model, 'password', array( 'class' => 'form-control' )); ?>
        <?php $form->error($model, 'password'); ?>
    </div>
</div>
<?php echo BsHtml::submitButton(Yii::t('user', 'Войти')); ?>
<?php $this->endWidget(); ?>