<?php
unset($form);
$form = $this->beginWidget('CActiveForm',
    array(
    'id'                   => 'subscribe',
    'action'               => Yii::app()->createUrl('/default/subscribe'),
    'enableAjaxValidation' => true,
    'clientOptions'        => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions'          => array(
        'class' => 'form-inline',
    ),
    ));
?>
<div class="form-group">
    <?php
    echo $form->textField($model, 'email',
        array(
        'class'       => 'form-control-footer',
        'placeholder' => Yii::t('main', 'Ваш email адрес')
    ));
    ?>
</div>
<button type="submit" class="btn-footer">
    <?php echo Yii::t('main', 'Отправить'); ?>
</button>
<?php echo $form->error($model, 'email'); ?>
<?php $this->endWidget(); ?>