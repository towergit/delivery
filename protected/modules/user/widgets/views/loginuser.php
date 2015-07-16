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
<?php $this->endWidget(); ?>