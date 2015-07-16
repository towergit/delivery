<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'faqcategory-form',
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
    'headerIcon'    => Yii::app()->getModule('faq')->icon,
    'headerButtons' => array(
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'link',
            'context'    => 'danger',
            'buttons'    => array(
                array(
                    'label' => Yii::t('faq', 'Отмена'),
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
                        ? Yii::t('faq', 'Добавить и продолжить') 
                        : Yii::t('faq', 'Сохранить и продолжить'),
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
                        ? Yii::t('faq', 'Добавить и закрыть') 
                        : Yii::t('faq', 'Сохранить и закрыть'),
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
            <a href="#tab1" data-toggle="tab" role="tab"><?php echo Yii::t('faq', 'Основные данные'); ?></a>
        </li>
        <li>
            <a href="#tab2" data-toggle="tab" role="tab"><?php echo Yii::t('faq', 'Описание'); ?></a>
        </li>
        <li>
            <a href="#tab3" data-toggle="tab" role="tab"><?php echo Yii::t('faq', 'SEO'); ?></a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <div class="row">
                <div class="col-sm-9">
                    <?php echo $form->dropDownListControlGroup($model, 'parent_id', $model->parentTree, array( 'encode' => false )); ?>
                    <?php echo $form->textFieldControlGroup($model, 'title'); ?>
                    <?php echo $form->textFieldControlGroup($model, 'alias'); ?>
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
        <div class="tab-pane" id="tab2">
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
        <div class="tab-pane" id="tab3">
            <?php echo $form->textFieldControlGroup($model, 'meta_keywords'); ?>
            <?php echo $form->textFieldControlGroup($model, 'meta_description'); ?>
        </div>
    </div>
    <!-- конец: вкладки -->
</div>

<?php $this->endWidget(); ?>