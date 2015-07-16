<?php
$form = $this->beginWidget('BsActiveForm', array(
    'id' => 'objectpackage-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array(
        'role' => 'form',
        'enctype' => 'multipart/form-data'
    ),
        ));
?>

<?php
$box = $this->beginWidget(
        'booster.widgets.TbPanel', array(
    'title' => CHtml::encode($this->pageTitle),
    'padContent' => false,
    'headerIcon' => Yii::app()->getModule('user')->icon,
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'link',
            'context' => 'danger',
            'buttons' => array(
                array(
                    'label' => Yii::t('user', 'Отмена'),
                    'icon' => 'fa fa-times',
                    'url' => array('index'),
                ),
            ),
        ),
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'submit',
            'context' => 'success',
            'buttons' => array(
                array(
                    'label' => $model->isNewRecord ? Yii::t('user', 'Добавить и продолжить') : Yii::t('user', 'Сохранить и продолжить'),
                    'icon' => $model->isNewRecord ? 'fa fa-plus-circle' : 'fa fa-floppy-o',
                    'htmlOptions' => array(
                        'name' => 'submit-type',
                        'value' => $model->isNewRecord ? 'create' : 'refresh',
                    )
                ),
            ),
        ),
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'submit',
            'context' => 'success',
            'buttons' => array(
                array(
                    'label' => $model->isNewRecord ? Yii::t('user', 'Добавить и закрыть') : Yii::t('user', 'Сохранить и закрыть'),
                    'icon' => 'fa fa-floppy-o',
                    'htmlOptions' => array(
                        'name' => 'submit-type',
                        'value' => 'index',
                        'style' => $model->isNewRecord ? 'display: none' : 'display: block',
                    )
                ),
            ),
        ),
    ),
    'htmlOptions' => array(
        'class' => 'panel-table'
    ),
        ));
$this->endWidget();
?>

<div class="row">
    <div class="col-sm-7">
           <?php echo $form->textFieldControlGroup($model, 'title'); ?>
           <?php echo $form->textFieldControlGroup($model, 'sum'); ?>
        
         <?php if (!$model->isNewRecord): ?>
                <?php echo $form->textFieldControlGroup($model, 'sum_collected'); ?>
          <?php endif;?>
    </div>
    <div class="col-sm-5">
            <?php echo $form->dropDownListControlGroup($model, 'help_id', ObjectHelp::getHelpsList()); ?>

    </div>
</div>


<?php $this->endWidget(); ?>