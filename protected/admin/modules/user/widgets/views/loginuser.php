<?php
$form = $this->beginWidget('CActiveForm',
    array(
    'id'                   => 'signin',
    'action'               => Yii::app()->createUrl('/default/login'),
    'enableAjaxValidation' => true,
    'clientOptions'        => array(
        'validateOnSubmit' => true,
    ),
    ));
?>
    <?php echo $form->labelEx($model, 'username'); ?><br>
    <?php echo $form->textField($model, 'username', array( 'class' => 'input' )); ?><br>
    <?php echo $form->error($model, 'username'); ?>
    
    <?php echo $form->labelEx($model, 'password'); ?><br>
    <?php echo $form->passwordField($model, 'password', array( 'class' => 'input' )); ?><br>
    <?php echo $form->error($model, 'password'); ?>
    
    <?php echo CHtml::submitButton('войти', array( 'class' => 'submit' )); ?>
    
    <div class="lost_pw">
        <a class="recover_pw">забыли пароль?</a>
    </div>
<?php $this->endWidget(); ?>
<?php unset($form); ?>