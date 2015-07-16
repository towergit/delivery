<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'cron-form',
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
    'headerIcon'    => Yii::app()->getModule('cron')->icon,
    'headerButtons' => array(
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'link',
            'context'    => 'danger',
            'buttons'    => array(
                array(
                    'label' => Yii::t('cron', 'Отмена'),
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
                        ? Yii::t('cron', 'Добавить и продолжить') 
                        : Yii::t('cron', 'Сохранить и продолжить'),
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
                        ? Yii::t('cron', 'Добавить и закрыть') 
                        : Yii::t('cron', 'Сохранить и закрыть'),
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

<?php echo $form->textFieldControlGroup($model, 'name'); ?>
<?php echo $form->textFieldControlGroup($model, 'filename'); ?>
<?php echo $form->dropDownListControlGroup($model, 'day_week', $model->getDaysWeek(), array( 'multiple' => true )); ?>
<?php echo $form->dropDownListControlGroup($model, 'month', $model->getMonths(), array( 'multiple' => true )); ?>
<?php echo $form->dropDownListControlGroup($model, 'day', $model->getDays()); ?>
<?php echo $form->dropDownListControlGroup($model, 'hour', $model->getHours()); ?>
<?php echo $form->dropDownListControlGroup($model, 'minute', $model->getMinutes()); ?>
<?php echo $form->checkBoxControlGroup($model, 'status'); ?>

<?php $this->endWidget(); ?>