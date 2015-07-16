<?php
Yii::import('admin.modules.object.modules.*');

$form = $this->beginWidget('BsActiveForm', array(
    'id' => 'paymentobject-form',
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

<div class="row">

    <div class="col-sm-7">

        <?php echo $form->textFieldControlGroup($model, 'sum'); ?>
        <?php echo $form->textFieldControlGroup($model, 'name'); ?>
        <?php echo $form->textFieldControlGroup($model, 'email'); ?>
        <?php echo $form->textFieldControlGroup($model, 'phone'); ?>

    </div>

    <?php
    $object = ObjectHelp::model()->findByAttributes(array('uniqid' => $model->ids_list));

    if (isset($object->id))
        $model->ids_list = $object->id;

    $paysys = PaymentSystem::model()->findByAttributes(array('code' => $model->system));

    if (isset($paysys->id))
        $model->system = $paysys->id;
    ?>

    <div class="col-sm-5">
<?php echo $form->dropDownListControlGroup($model, 'ids_list', ObjectHelp::getHelpsList()); ?>

        <?php echo $form->dropDownListControlGroup($model, 'status', $model->getStatusList()); ?>
        <?php echo $form->dropDownListControlGroup($model, 'system', $model->getSystemList()); ?>
    </div>
</div>

<?php $this->endWidget(); ?>