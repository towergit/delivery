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

<div class="panel">
    <!-- начало: вкладки -->
    <ul class="nav nav-tabs nav-tabs-simple" role="tablist">
        <li class="active">
            <a href="#tab1" data-toggle="tab" role="tab"><?php echo Yii::t('object', 'Основные данные'); ?></a>
        </li>
        <li class="">
            <a href="#tab2" data-toggle="tab" role="tab"><?php echo Yii::t('object', 'Графические материалы'); ?></a>
        </li>
        <?php if (!$model->isNewRecord): ?>
            <li>
                <a href="/admin/object/objectpackage?object_id=<?php echo $model->id;?>"><?php echo Yii::t('object', 'Пакеты'); ?></a>
            </li>
        <?php endif; ?>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <div class="row">
                <div class="col-sm-8">
                    <?php echo $form->textFieldControlGroup($model, 'title'); ?>

                    <?php echo $form->textFieldControlGroup($model, 'alias'); ?>

                    <?php
                    echo $form->label($model, 'text');
                    $this->widget('ext.imperavi-redactor.ImperaviRedactorWidget', array(
                        'model' => $model,
                        'attribute' => 'text',
                        'name' => 'text',
                        'options' => array(
                            'lang' => Yii::app()->language,
                            'toolbar' => true,
                        ),
                    ));
                    ?>
                    <br />
                    
                    <?php if ($model->isNewRecord): ?>
                        <?php echo $form->hiddenField($model,'uniqid',array('value'=>  uniqid())); ?>
                    <?php endif;?>
                    
                </div>
                <div class="col-sm-4">
                    <?php
                    $model->create_date = Date::format($model->create_date, 'dd.MM.y HH:mm');
                    echo $form->textFieldControlGroup($model, 'create_date', array('disabled' => true));
                    ?>
                    <?php
                    $model->update_date = Date::format($model->update_date, 'dd.MM.y HH:mm');
                    echo $form->textFieldControlGroup($model, 'update_date', array('disabled' => true));
                    ?>

                    <?php echo $form->dropDownListControlGroup($model, 'category_id', $category->getCategoryList()); ?>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab2">
            <fieldset>
                <?php
                $files = UploadFile::findAllFiles('object', $model->id);

                if ($files):
                    foreach ($files as $file):
                        ?>
                        <div style="float:left; margin-bottom: 20px">
                            <a href="<?php echo $model->imagesUpload->getFileUrl($file->file); ?>" class="fancybox">
                                <img src="<?php echo $model->imagesUpload->getFileUrl($file->file); ?>" alt="" style="max-width: 150px; max-height: 210px;" />
                                <br />
                                <a  class="btn btn-default" href="/admin/object/objecthelp/deleteimage/<?php echo $file->id;?>?redirect_url=<?php echo $_SERVER['REQUEST_URI']?>">Удалить</a>

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

       

    </div>
    <!-- конец: вкладки -->
</div>

<?php $this->endWidget(); ?>