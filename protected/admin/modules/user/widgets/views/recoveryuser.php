<?php
$form = $this->beginWidget('CActiveForm',
    array(
    'id'                   => 'recover',
    'action'               => Yii::app()->createUrl('/default/recovery'),
    'enableAjaxValidation' => true,
    'clientOptions'        => array(
        'validateOnSubmit' => true,
    ),
    ));
?>
    <?php echo $form->labelEx($model, 'username_or_email'); ?><br>
    <?php echo $form->textField($model, 'username_or_email', array( 'class' => 'input' )); ?><br>
    <?php echo $form->error($model, 'username_or_email'); ?>
    
    <?php echo CHtml::submitButton('отправить', array( 'class' => 'submit' )); ?>
<?php $this->endWidget(); ?>
<?php unset($form); ?>