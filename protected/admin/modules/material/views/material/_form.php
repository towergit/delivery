<?php
$form = $this->beginWidget('BsActiveForm', array(
    'id' => 'material-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array(
        'role' => 'form',
                'enctype' => 'multipart/form-data'
    ),
        ));

$box = $this->beginWidget('booster.widgets.TbPanel', array(
    'title' => CHtml::encode($this->pageTitle),
    'padContent' => false,
    'headerIcon' => Yii::app()->getModule('material')->icon,
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'link',
            'context' => 'danger',
            'buttons' => array(
                array(
                    'label' => Yii::t('material', 'Отмена'),
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
                    'label' => $model->isNewRecord ? Yii::t('material', 'Добавить и продолжить') : Yii::t('material', 'Сохранить и продолжить'),
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
                    'label' => $model->isNewRecord ? Yii::t('material', 'Добавить и закрыть') : Yii::t('material', 'Сохранить и закрыть'),
                    'icon' => 'fa fa-floppy-o',
                    'htmlOptions' => array(
                        'name' => 'submit-type',
                        'value' => 'index',
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

<div class="panel">
    <!-- начало: вкладки -->
    <ul class="nav nav-tabs nav-tabs-simple" role="tablist">
        <li class="active">
            <a href="#tab1" data-toggle="tab" role="tab">Основные данные</a>
        </li>
        <li>
            <a href="#tab2" data-toggle="tab" role="tab">Картинки</a>
        </li>
        <li>
            <a href="#tab3" data-toggle="tab" role="tab">SEO</a>
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
                        <?php echo $form->labelEx($model, 'description'); ?>
                        <?php
                        $this->widget('booster.widgets.TbRedactorJs', array(
                            'model' => $model,
                            'attribute' => 'description',
                            'editorOptions' => array(
                                'lang' => Yii::app()->language,
                                'minHeight' => '100',
                            ),
                        ));
                        ?>
                        <p class="help-block"><?php echo $model->getAttributeDescription('description'); ?></p>
                        <?php echo $form->error($model, 'description'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'text'); ?>
                        <?php
                        $this->widget('booster.widgets.TbRedactorJs', array(
                            'model' => $model,
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
                            <?php echo $form->textFieldControlGroup($model, 'create_date', array('disabled' => true)); ?>

                            <?php $model->update_date = Date::format($model->update_date, 'dd.MM.y HH:mm'); ?>
                            <?php echo $form->textFieldControlGroup($model, 'update_date', array('disabled' => true)); ?>
                        <?php endif; ?>

                        <?php $model->publish_date = Date::format($model->publish_date, 'dd.MM.y HH:mm'); ?>
                        <?php echo $form->labelEx($model, 'publish_date'); ?>
                        <div>
                            <?php
                            $this->widget('booster.widgets.TbDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'publish_date',
                                'options' => array(
                                    'format' => 'dd.mm.yyyy hh:ii',
                                    'autoclose' => true,
                                ),
                                'htmlOptions' => array(
                                    'class' => 'form-control',
                                )
                                    )
                            );
                            ?>
                            <?php echo $form->error($model, 'publish_date'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php $model->unpublish_date = Date::format($model->unpublish_date, 'dd.MM.y HH:mm'); ?>
                        <?php echo $form->labelEx($model, 'unpublish_date'); ?>
                        <div>
                            <?php
                            $this->widget('booster.widgets.TbDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'unpublish_date',
                                'options' => array(
                                    'format' => 'dd.mm.yyyy hh:ii',
                                    'autoclose' => true,
                                ),
                                'htmlOptions' => array(
                                    'class' => 'form-control',
                                )
                                    )
                            );
                            ?>
                            <?php echo $form->error($model, 'unpublish_date'); ?>
                        </div>
                    </div>
                    <?php if (!$model->isNewRecord): ?>
                        <?php echo $form->textFieldControlGroup($model, 'visits', array('disabled' => true)); ?>
                    <?php endif; ?>

                    <?php echo $form->dropDownListControlGroup($model, 'elect', $model->electList); ?>
                    <?php echo $form->dropDownListControlGroup($model, 'status', $model->statusList); ?>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab2">
            <fieldset>
                <?php
                $files = UploadFile::findAllFiles('material', $model->id);

                if ($files):
                    foreach ($files as $file):
                        ?>
                        <div style="float:left; margin-bottom: 20px">
                            <a href="<?php echo $model->imagesUpload->getFileUrl($file->file); ?>" class="fancybox">
                                <img src="<?php echo $model->imagesUpload->getFileUrl($file->file); ?>" alt="" style="max-width: 150px; max-height: 210px;" />
                                <br />
                                <a  class="btn btn-default" href="<?php echo $this->createUrl('/file/delete',array('id' => $file->id, 'redirect_url' => $_SERVER['REQUEST_URI'])); ?>">Удалить</a>

                            </a>
                        </div>
                    <?php endforeach; ?>
                    <br /><br />
                    <div style="clear:both"></div>
                    <?php
                endif;
                $this->widget('CMultiFileUpload', array(
                    'name' => 'image',
                    'accept' => 'jpeg|jpg|gif|png',
                    'duplicate' => 'Дубликат файла!',
                    'denied' => 'Не верный формат',
                    'remove' => '&times',
                ));
                ?>
            </fieldset>
        </div>
        <div class="tab-pane" id="tab3">
            <?php echo $form->textFieldControlGroup($model, 'meta_keywords'); ?>
            <?php echo $form->textFieldControlGroup($model, 'meta_description'); ?>
        </div>
    </div>
    <!-- конец: вкладки -->
</div>

<?php $this->endWidget(); ?>