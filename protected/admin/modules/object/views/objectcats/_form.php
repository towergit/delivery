<?php
$form = $this->beginWidget('BsActiveForm', array(
    'id' => 'ObjectHelp-form',
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

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldControlGroup($model, 'title'); ?>
        <?php echo $form->textFieldControlGroup($model, 'alias'); ?>

    </div>

    <div class="col-sm-7">

        <?php
            $file = UploadFile::getFile('сategory', $model->id);

        ?>
        
        <?php if($file):?>
                        <div style="float:left; margin-bottom: 20px">
                            <a href="<?php echo $model->imagesUpload->getFileUrl($file->file); ?>" class="fancybox">
                                <img src="<?php echo $model->imagesUpload->getFileUrl($file->file); ?>" alt="" style="max-width: 150px; max-height: 210px;" />
                                <br />
                                <a  class="btn btn-default" href="<?php echo $this->createUrl('/file/delete',array('id' => $file->id, 'redirect_url' => $_SERVER['REQUEST_URI'])); ?>">Удалить</a>

                            </a>
                        </div>
        
        <?php endif;?>
        
        <?php
        $this->widget('CMultiFileUpload', array(
            'name' => 'image',
            'accept' => 'jpeg|jpg|gif|png',
            'duplicate' => 'Дубликат файла!',
            'denied' => 'Не верный формат',
            'remove' => '&times',
        ));
        ?>
    </div>
</div>


<?php $this->endWidget(); ?>