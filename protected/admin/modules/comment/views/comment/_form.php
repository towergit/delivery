<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'comment-form',
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
    'headerIcon'    => Yii::app()->getModule('comment')->icon,
    'headerButtons' => array(
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'link',
            'context'    => 'danger',
            'buttons'    => array(
                array(
                    'label' => Yii::t('comment', 'Отмена'),
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
                    'label'       => $model->isNewRecord ? Yii::t('comment', 'Добавить и продолжить') : Yii::t('comment',
                            'Сохранить и продолжить'),
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
                    'label'       => $model->isNewRecord ? Yii::t('comment', 'Добавить и закрыть') : Yii::t('comment',
                            'Сохранить и закрыть'),
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
            <?php echo $form->textFieldControlGroup($model, 'owner_name'); ?>
            <?php echo $form->textFieldControlGroup($model, 'owner_id'); ?>
            <?php echo $form->textFieldControlGroup($model, 'name'); ?>
            <?php echo $form->textFieldControlGroup($model, 'email'); ?>
            <?php echo $form->textFieldControlGroup($model, 'site'); ?>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'text'); ?>
                <?php
                $this->widget('booster.widgets.TbRedactorJs', array(
                    'model'     => $model,
                    'attribute' => 'text',
                ));
                ?>
                <?php echo $form->error($model, 'text'); ?>
            </div>

            <?php echo $form->dropDownListControlGroup($model, 'status', $model->statusList); ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>