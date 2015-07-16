<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'language-form',
    'enableAjaxValidation' => true,
    'clientOptions'        => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions'          => array( 
        'role' => 'form'
    ),
    ));
?>

<?php
$box  = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
    'title'         => CHtml::encode($this->pageTitle),
    'padContent'    => false,
    'headerIcon'    => Yii::app()->getModule('language')->icon,
    'headerButtons' => array(
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'link',
            'context'    => 'danger',
            'buttons'    => array(
                array(
                    'label' => Yii::t('language', 'Отмена'),
                    'icon'  => 'fa fa-times',
                    'url'   => array( 'index' ),
                ),
            ),
        ),
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'submit',
            'context'    => 'success',
            'buttons'    => array(
                array(
                    'label'       => $model->isNewRecord ? Yii::t('language', 'Добавить и продолжить') : Yii::t('language', 'Сохранить и продолжить'),
                    'icon'        => $model->isNewRecord ? 'fa fa-plus-circle' : 'fa fa-floppy-o',
                    'htmlOptions' => array(
                        'name'  => 'submit-type',
                        'value' => $model->isNewRecord ? 'create' : 'refresh',
                    )
                ),
            ),
        ),
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'submit',
            'context'    => 'success',
            'buttons'    => array(
                array(
                    'label'       => $model->isNewRecord ? Yii::t('language', 'Добавить и закрыть') : Yii::t('language', 'Сохранить и закрыть'),
                    'icon'        => 'fa fa-floppy-o',
                    'htmlOptions' => array(
                        'name'  => 'submit-type',
                        'value' => 'index',
                    )
                ),
            ),
        ),
    ),
    'htmlOptions'   => array( 
        'class' => 'panel-table'
    ),
    )
);
$this->endWidget();
?>

<div class="panel panel-padding">
    <div class="row">
        <div class="col-sm-12">
            <?php echo $form->textFieldControlGroup($model, 'title'); ?>
            <?php echo $form->textFieldControlGroup($model, 'url'); ?>
            <?php echo $form->textFieldControlGroup($model, 'local'); ?>
            <?php echo $form->checkBoxControlGroup($model, 'default'); ?>
            <?php echo $form->checkBoxControlGroup($model, 'status'); ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>