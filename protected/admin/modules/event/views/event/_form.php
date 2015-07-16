<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'event-form',
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
    'headerIcon'    => Yii::app()->getModule('event')->icon,
    'headerButtons' => array(
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'link',
            'context'    => 'danger',
            'buttons'    => array(
                array(
                    'label' => Yii::t('event', 'Отмена'),
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
                        ? Yii::t('event', 'Добавить и продолжить') 
                        : Yii::t('event', 'Сохранить и продолжить'),
                    'icon'        => $model->isNewRecord 
                        ? 'fa fa-plus-circle' 
                        : 'fa fa-floppy-o',
                    'htmlOptions' => array(
                        'name'  => 'submit-type',
                        'value' => $model->isNewRecord 
                            ? 'create' 
                            : 'refresh',
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
                        ? Yii::t('event', 'Добавить и закрыть') 
                        : Yii::t('event', 'Сохранить и закрыть'),
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
            <a href="#tab1" data-toggle="tab" role="tab"><?php echo Yii::t('event', 'Основные данные'); ?></a>
        </li>
        <li>
            <a href="#tab2" data-toggle="tab" role="tab"><?php echo Yii::t('event', 'Дополнительно'); ?></a>
        </li>
        <li>
            <a href="#tab3" data-toggle="tab" role="tab"><?php echo Yii::t('event', 'SEO'); ?></a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <div class="row">
                <div class="col-sm-9">
                    <?php echo $form->dropDownListControlGroup($model, 'category_id', $category->parentList); ?>
                    <?php echo $form->textFieldControlGroup($model, 'title'); ?>
                    <?php echo $form->textFieldControlGroup($model, 'alias'); ?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'text'); ?>
                        <?php
                        $this->widget('booster.widgets.TbRedactorJs',
                            array(
                            'model'     => $model,
                            'attribute' => 'text',
                            'editorOptions' => array(
                                'lang' => Yii::app()->language,
                                'minHeight' => '200',
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'text'); ?>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <?php if (!$model->isNewRecord): ?>
                            <?php $model->create_date = Date::format($model->create_date, 'dd.MM.y HH:mm'); ?>
                            <?php echo $form->textFieldControlGroup($model, 'create_date', array( 'disabled' => true )); ?>

                            <?php $model->update_date = Date::format($model->update_date, 'dd.MM.y HH:mm'); ?>
                            <?php echo $form->textFieldControlGroup($model, 'update_date', array( 'disabled' => true )); ?>
                        <?php endif; ?>
                        
                        <?php $model->start_date = Date::format($model->start_date, 'dd.MM.y HH:mm'); ?>
                        <?php echo $form->labelEx($model, 'start_date'); ?>
                        <div>
                            <?php
                            $this->widget('booster.widgets.TbDateTimePicker',
                                array(
                                'model'       => $model,
                                'attribute'   => 'start_date',
                                'options'     => array(
                                    'format'    => 'dd.mm.yyyy hh:ii',
                                    'autoclose' => true,
                                ),
                                'htmlOptions' => array(
                                    'class' => 'form-control',
                                )
                                )
                            );
                            ?>
                            <?php echo $form->error($model, 'start_date'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php $model->end_date = Date::format($model->end_date, 'dd.MM.y HH:mm'); ?>
                        <?php echo $form->labelEx($model, 'end_date'); ?>
                        <div>
                            <?php
                            $this->widget('booster.widgets.TbDateTimePicker',
                                array(
                                'model'       => $model,
                                'attribute'   => 'end_date',
                                'options'     => array(
                                    'format'    => 'dd.mm.yyyy hh:ii',
                                    'autoclose' => true,
                                ),
                                'htmlOptions' => array(
                                    'class' => 'form-control',
                                )
                                )
                            );
                            ?>
                            <?php echo $form->error($model, 'end_date'); ?>
                        </div>
                    </div>
                    <?php echo $form->dropDownListControlGroup($model, 'status', $model->statusList); ?>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab2">
            <?php echo $form->textFieldControlGroup($model, 'organizers'); ?>
            <?php echo $form->textFieldControlGroup($model, 'theme'); ?>
            <?php echo $form->textFieldControlGroup($model, 'speakers'); ?>
            <?php echo $form->textFieldControlGroup($model, 'duration'); ?>
            <?php echo $form->textFieldControlGroup($model, 'cost'); ?>
            <?php echo $form->textFieldControlGroup($model, 'contacts'); ?>
            <?php echo $form->textFieldControlGroup($model, 'venue'); ?>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'comment'); ?>
                <?php
                $this->widget('booster.widgets.TbRedactorJs',
                    array(
                    'model'     => $model,
                    'attribute' => 'comment',
                    'editorOptions' => array(
                        'lang' => Yii::app()->language,
                        'minHeight' => '200',
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'comment'); ?>
            </div>
        </div>
        <div class="tab-pane" id="tab3">
            <?php echo $form->textFieldControlGroup($model, 'meta_keywords'); ?>
            <?php echo $form->textFieldControlGroup($model, 'meta_description'); ?>
        </div>
    </div>
    <!-- конец: вкладки -->
</div>

<?php $this->endWidget(); ?>