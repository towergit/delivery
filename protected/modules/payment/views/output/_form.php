<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'outputmoney-form',
    'enableAjaxValidation' => true,
    'clientOptions'        => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions'          => array( 'role' => 'form' ),
    ));

$box              = $this->beginWidget('booster.widgets.TbPanel',
    array(
    'title'         => CHtml::encode($this->pageTitle),
    'padContent'    => false,
    'headerIcon'    => Yii::app()->getModule('payment')->icon,
    'headerButtons' => array(
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'link',
            'context'    => 'danger',
            'buttons'    => array(
                array(
                    'label' => Yii::t('payment', 'Отмена'),
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
                    'label'       => $model->isNewRecord ? Yii::t('payment', 'Добавить и продолжить') : Yii::t('payment',
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
                    'label'       => $model->isNewRecord ? Yii::t('payment', 'Добавить и закрыть') : Yii::t('payment',
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
        <div class="col-sm-9">
            <?php if (!$model->isNewRecord): ?>
                <?php echo $form->textFieldControlGroup($model, 'code', array( 'disabled' => true )); ?>
            <?php endif; ?>
            
            <div class="form-group">
                <?php echo $form->labelEx($model, 'user_id'); ?>
                <div>
                    <?php
                    if (!$model->isNewRecord)
                        $model->user_id = $model->user->username;
                    
                    $this->widget('booster.widgets.TbTypeahead', array(
                        'model'       => $model,
                        'attribute'   => 'user_id',
                        'datasets'    => array(
                            'source' => $user->userList,
                        ),
                        'htmlOptions' => array(
                            'class'        => 'form-control',
                            'autocomplete' => 'off',
                        ),
                        )
                    );
                    ?>
                    <?php echo $form->error($model, 'user_id'); ?>
                </div>
            </div>
            <?php echo $form->dropDownListControlGroup($model, 'purse_id', $paymentPurse->purseList); ?>
            <?php echo $form->textFieldControlGroup($model, 'sum'); ?>
        </div>
        <div class="col-sm-3">
            <?php if (!$model->isNewRecord): ?>
                <?php $model->create_date = Date::format($model->create_date, 'dd.MM.y HH:mm'); ?>
                <?php echo $form->textFieldControlGroup($model, 'create_date', array( 'disabled' => true )); ?>

                <?php $model->update_date = Date::format($model->update_date, 'dd.MM.y HH:mm'); ?>
                <?php echo $form->textFieldControlGroup($model, 'update_date', array( 'disabled' => true )); ?>
            <?php endif; ?>
            
            <?php echo $form->dropDownListControlGroup($model, 'status', $model->statusList); ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>