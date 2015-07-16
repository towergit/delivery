<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'comment',
    'action'               => Yii::app()->createUrl('/default/comment', array( 'redirectTo' => $redirectTo )),
    'enableAjaxValidation' => true,
    'clientOptions'        => array(
        'validateOnSubmit' => true,
    ),
    ));
?>
    <?php 
    echo $form->hiddenField($model, 'owner_name');
    echo $form->hiddenField($model, 'owner_id');
    ?>
    <div class="col-md-6 input-past">
        <?php 
        echo $form->textFieldControlGroup($model, 'name', array(
            'placeholder' => ' ',
        ));
        
        echo $form->textFieldControlGroup($model, 'email', array(
            'placeholder' => ' ',
        ));
        
        echo $form->textFieldControlGroup($model, 'site', array(
            'placeholder' => ' ',
        ));
        ?>
    </div> 
    <div class="col-md-6 textarea-past"> 
        <?php
        echo $form->textAreaControlGroup($model, 'text', array(
            'placeholder' => ' ',
            'rows' => 5,
        ));
        ?>
        <button type="submit" class="btn btn-default">
            <?php echo Yii::t('main', 'Отправить'); ?>
        </button>
    </div>  	
<?php $this->endWidget(); ?>