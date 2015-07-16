<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'traininglecturer-form',
    'enableAjaxValidation' => true,
    'clientOptions'        => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions'          => array( 'role' => 'form' ),
    ));

$box = $this->beginWidget('booster.widgets.TbPanel',
    array(
    'title'         => CHtml::encode($this->pageTitle),
    'padContent'    => false,
    'headerIcon'    => Yii::app()->getModule('training')->icon,
    'headerButtons' => array(
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'link',
            'context'    => 'danger',
            'buttons'    => array(
                array(
                    'label' => Yii::t('training', 'Отмена'),
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
                        ? Yii::t('training', 'Добавить и продолжить') 
                        : Yii::t('training', 'Сохранить и продолжить'),
                    'icon'        => $model->isNewRecord 
                        ? 'fa fa-plus-circle' 
                        : 'fa fa-floppy-o',
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
                        ? Yii::t('training', 'Добавить и закрыть') 
                        : Yii::t('training', 'Сохранить и закрыть'),
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
        <div class="col-sm-9">
            <?php echo $form->textFieldControlGroup($model, 'name'); ?>
            <?php echo $form->textFieldControlGroup($model, 'photo'); ?>
            
            <div class="form-group">
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php
                $this->widget('booster.widgets.TbRedactorJs',
                    array(
                    'model'     => $model,
                    'attribute' => 'description',
                    'editorOptions' => array(
                        'lang' => Yii::app()->language,
                        'minHeight' => '100',
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'description'); ?>
            </div>
            
            <div class="form-group">
                <?php echo $form->labelEx($model, 'text'); ?>
                <?php
                $this->widget('booster.widgets.TbRedactorJs',
                    array(
                    'model'     => $model,
                    'attribute' => 'text',
                    'editorOptions' => array(
                        'lang' => Yii::app()->language,
                        'minHeight' => '100',
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'text'); ?>
            </div>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListControlGroup($model, 'status', $model->statusList); ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>