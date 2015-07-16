<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'signin',
    'action'               => Yii::app()->createUrl('/default/authorization'),
    'enableAjaxValidation' => true,
    'clientOptions'        => array(
        'validateOnSubmit' => true,
    ),
    ));
?>
    <?php 
    echo $form->textFieldControlGroup($model, 'username', array(
        'placeholder' => ' ',
    )); 
    echo $form->passwordFieldControlGroup($model, 'password', array(
        'placeholder' => ' ',
    )); 
    ?>
    
    <button type="submit" class="btn btn-default signin">
        <?php echo Yii::t('main', 'Войти'); ?>
    </button>
    
    <a class="pull-right" href="<?php echo Yii::app()->createUrl('/default/authorization', array( '#' => 'restore' )); ?>">
        <?php echo Yii::t('main', 'Восстановить доступ'); ?>?
    </a>
<?php $this->endWidget(); ?>