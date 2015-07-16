<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'menuitem-form',
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
    'headerIcon'    => Yii::app()->getModule('menu')->icon,
    'headerButtons' => array(
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'link',
            'context'    => 'danger',
            'buttons'    => array(
                array(
                    'label' => Yii::t('menu', 'Отмена'),
                    'icon'  => 'fa fa-times',
                    'url'   => array( 'index', 'menu_id' => Yii::app()->request->getQuery('menu_id') ),
                ),
            ),
        ),
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'submit',
            'context'    => 'success',
            'buttons'    => array(
                array(
                    'label'       => $model->isNewRecord ? Yii::t('menu', 'Добавить и продолжить') : Yii::t('menu',
                            'Сохранить и продолжить'),
                    'icon'        => $model->isNewRecord ? 'fa fa-plus-circle' : 'fa fa-floppy-o',
                    'htmlOptions' => array(
                        'name'  => 'submit-type',
                        'value' => $model->isNewRecord ? $this->createUrl('create',
                                array( 'menu_id' => Yii::app()->request->getQuery("menu_id") )) : 'refresh',
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
                    'label'       => $model->isNewRecord ? Yii::t('menu', 'Добавить и закрыть') : Yii::t('menu',
                            'Сохранить и закрыть'),
                    'icon'        => 'fa fa-floppy-o',
                    'htmlOptions' => array(
                        'name'  => 'submit-type',
                        'value' => $this->createUrl('index',
                            array( 'menu_id' => Yii::app()->request->getQuery("menu_id") )),
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
            <?php echo $form->dropDownListControlGroup($model, 'menu_id', $model->menuList); ?>
            <?php echo $form->dropDownListControlGroup($model, 'parent_id', $model->parentTree, array( 'encode' => false )); ?>
            <?php echo $form->textFieldControlGroup($model, 'title'); ?>
            <?php echo $form->textFieldControlGroup($model, 'href'); ?>
            <?php echo $form->dropDownListControlGroup($model, 'target', $model->targetList); ?>
            <?php echo $form->checkBoxControlGroup($model, 'status'); ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>