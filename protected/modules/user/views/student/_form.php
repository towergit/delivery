<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'student-form',
    'enableAjaxValidation' => true,
    'clientOptions'        => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions'          => array(
        'role' => 'form'
    ),
    ));
?>

<?php
$box  = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
    'title'         => CHtml::encode($this->pageTitle),
    'padContent'    => false,
    'headerIcon'    => Yii::app()->getModule('user')->icon,
    'headerButtons' => array(
        array(
            'class'      => 'booster.widgets.TbButtonGroup',
            'buttonType' => 'link',
            'context'    => 'danger',
            'buttons'    => array(
                array(
                    'label' => Yii::t('user', 'Отмена'),
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
                        ? Yii::t('user', 'Добавить и продолжить') 
                        : Yii::t('user', 'Сохранить и продолжить'),
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
                    'label'       => $model->isNewRecord 
                        ? Yii::t('user', 'Добавить и закрыть') 
                        : Yii::t('user', 'Сохранить и закрыть'),
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
            <a href="#tab1" data-toggle="tab" role="tab"><?php echo Yii::t('user', 'Основные данные'); ?></a>
        </li>
        <li>
            <a href="#tab2" data-toggle="tab" role="tab"><?php echo Yii::t('user', 'Профиль'); ?></a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <?php echo $form->textFieldControlGroup($model, 'username'); ?>
            <?php echo $form->textFieldControlGroup($model, 'email'); ?>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'role', array( 'class' => 'control-label required' ));
                ?>
                <div>
                    <?php
                    $this->widget('booster.widgets.TbSelect2',
                        array(
                        'model'       => $model,
                        'attribute'   => 'role',
                        'data'        => $model->rolesList,
                        'options'     => array(
                            'placeholder'     => Yii::t('user', 'Роль'),
                            'width'           => '100%',
                            'tokenSeparators' => array( ',', ' ' )
                        ),
                        'htmlOptions' => array(
                            'multiple' => 'multiple',
                            'options'  => $roles,
                        )
                    ));
                    ?>
                    <?php echo $form->error($model, 'role'); ?>
                </div>
            </div>
            <?php echo $form->passwordFieldControlGroup($model, 'new_password'); ?>
            <?php echo $form->passwordFieldControlGroup($model, 'confirm_password'); ?>
            <?php echo $form->dropDownListControlGroup($model, 'status', $model->statusList); ?>
        </div>
        <div class="tab-pane" id="tab2">
            <?php echo $form->textFieldControlGroup($profile, 'firstname'); ?>
            <?php echo $form->textFieldControlGroup($profile, 'lastname'); ?>
            <?php echo $form->textFieldControlGroup($profile, 'patronymic'); ?>
            <?php echo $form->textFieldControlGroup($profile, 'phone'); ?>
        </div>
    </div>
    <!-- конец: вкладки -->
</div>

<?php $this->endWidget(); ?>