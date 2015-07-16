<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'authitem-form',
    'enableAjaxValidation' => true,
    'clientOptions'        => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions'          => array( 'role' => 'form' ),
    ));
?>

<?php
$box  = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
    'title'         => CHtml::encode($this->pageTitle),
    'padContent'    => false,
    'headerIcon'    => Yii::app()->getModule('user')->icon,
    'headerButtons' => array(
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'link',
            'context'    => 'danger',
            'buttons'    => array(
                array(
                    'label' => Yii::t('user', 'Отмена'),
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
                    'label'       => $model->isNewRecord 
                        ? Yii::t('user', 'Добавить и продолжить') 
                        : Yii::t('user', 'Сохранить и продолжить'),
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
                    'label'       => $model->isNewRecord 
                        ? Yii::t('user', 'Добавить и закрыть') 
                        : Yii::t('user', 'Сохранить и закрыть'),
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
));
$this->endWidget();
?>

<div class="panel panel-padding">
    <div class="row">
        <div class="col-sm-12">
            <?php echo $form->textFieldControlGroup($model, 'name'); ?>
            <?php echo $form->textFieldControlGroup($model, 'description'); ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>