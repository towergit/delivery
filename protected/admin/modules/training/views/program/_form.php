<?php
$form = $this->beginWidget('BsActiveForm', array(
    'id'                   => 'trainingprogram-form',
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

<div class="panel">
    <!-- начало: вкладки -->
    <ul class="nav nav-tabs nav-tabs-simple" role="tablist">
        <li class="active">
            <a href="#tab1" data-toggle="tab" role="tab"><?php echo Yii::t('training', 'Основные данные'); ?></a>
        </li>
        <li>
            <a href="#tab2" data-toggle="tab" role="tab"><?php echo Yii::t('training', 'Описание'); ?></a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <div class="row">
                <div class="col-sm-9">
                    <h4 class="title"><?php echo Yii::t('training', 'Стадия обучения'); ?></h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <?php $model->year = $model->getYearOnMonth(); ?>
                            <?php echo $form->dropDownListControlGroup($model, 'year', $stage->yearList, array(
                                'empty' => Yii::t('training', '-- Выберите год --'),
                                'ajax' => array(
                                    'type' => 'POST',   
                                    'dataType' => 'json',
                                    'url' => Yii::app()->createAbsoluteUrl('/training/program/month'),
                                    'success' => 'function(data) { 
                                        $("#TrainingProgram_month").html(data);
                                    }',
                                )
                            )); ?>
                        </div>
                        <div class="col-sm-6">
                            <?php $model->month = $model->stage_id; ?>
                            <?php echo $form->dropDownListControlGroup($model, 'month', $model->isNewRecord ? array() : $model->getMonth(), array( 'empty' => Yii::t('traigetMonth()ning', '-- Выберите месяц --' ),)); ?>
                        </div>
                    </div>
                    <h4 class="title"><?php echo Yii::t('training', 'Назначение'); ?></h4>
                    <?php echo $form->dropDownListControlGroup($model, 'educator_id', $educator->lecturerList); ?>
                    <?php echo $form->textFieldControlGroup($model, 'name'); ?>
                </div>
                <div class="col-sm-3">
                     <?php echo $form->dropDownListControlGroup($model, 'status', $model->statusList); ?>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab2">
            <div class="form-group">
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php
                $this->widget('booster.widgets.TbRedactorJs',
                    array(
                    'model'     => $model,
                    'attribute' => 'description',
                    'editorOptions' => array(
                        'lang' => Yii::app()->language,
                        'minHeight' => '200',
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'description'); ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>