<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'gallery-form',
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
    'headerIcon'    => Yii::app()->getModule('gallery')->icon,
    'headerButtons' => array(
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'link',
            'context'    => 'danger',
            'buttons'    => array(
                array(
                    'label' => Yii::t('gallery', 'Отмена'),
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
                        ? Yii::t('gallery', 'Добавить и продолжить') 
                        : Yii::t('gallery', 'Сохранить и продолжить'),
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
                        ? Yii::t('gallery', 'Добавить и закрыть') 
                        : Yii::t('gallery', 'Сохранить и закрыть'),
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
            <?php echo $form->dropDownListControlGroup($model, 'category_id', $category->parentTree, array( 'encode' => false )); ?>
            <?php echo $form->textFieldControlGroup($model, 'filename'); ?>
            <?php echo $form->textFieldControlGroup($model, 'path'); ?>
            <?php echo $form->textFieldControlGroup($model, 'alt'); ?>
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