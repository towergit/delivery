<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'contentblock-form',
    'enableAjaxValidation' => true,
    'clientOptions'        => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions'          => array(
        'role' => 'form'
    ),
    ));

$box = $this->beginWidget('booster.widgets.TbPanel',
    array(
    'title'         => CHtml::encode($this->pageTitle),
    'padContent'    => false,
    'headerIcon'    => Yii::app()->getModule('contentblock')->icon,
    'headerButtons' => array(
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'link',
            'context'    => 'danger',
            'buttons'    => array(
                array(
                    'label' => Yii::t('contentblock', 'Отмена'),
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
                        ? Yii::t('contentblock', 'Добавить и продолжить') 
                        : Yii::t('contentblock', 'Сохранить и продолжить'),
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
                        ? Yii::t('contentblock', 'Добавить и закрыть') 
                        : Yii::t('contentblock', 'Сохранить и закрыть'),
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
            <?php echo $form->dropDownListControlGroup($model, 'type', $model->typeList); ?>
            <?php echo $form->textFieldControlGroup($model, 'title'); ?>
            <?php echo $form->textFieldControlGroup($model, 'code'); ?>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'content'); ?>
                <?php
                $this->widget('booster.widgets.TbRedactorJs',
                    array(
                    'model'     => $model,
                    'attribute' => 'content',
                    'htmlOptions' => array( 'rows' => 20, 'cols' => 6 ),
                ));
                ?>
                <?php echo $form->error($model, 'content'); ?>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php
                $this->widget('booster.widgets.TbRedactorJs',
                    array(
                    'model'     => $model,
                    'attribute' => 'description',
                ));
                ?>
                <?php echo $form->error($model, 'description'); ?>
            </div>
            <?php echo $form->checkBoxControlGroup($model, 'status'); ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>