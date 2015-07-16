<?php
// название страницы
$this->pageTitle = Yii::t('main', 'Blagovest');

$form = $this->beginWidget('CActiveForm',
    array(
    'id'                   => 'subscribe',
    'enableAjaxValidation' => true,
    'clientOptions'        => array(
        'validateOnSubmit' => true,
    ),
        'htmlOptions' => array(
            'class' => 'navbar-form',
        ),
    ));
?>
    <div class="form-group">
        <?php 
        echo $form->textField($model, 'email', array( 
            'class' => 'form-control form-control-cap',
            'placeholder' => Yii::t('main', 'Введите ваш email адрес')
        ));
        echo $form->error($model, 'email');
        ?>
    </div>
    <button type="submit" class="btn-cap">
        <?php echo Yii::t('main', 'Отправить'); ?>
    </button>
<?php $this->endWidget(); ?>