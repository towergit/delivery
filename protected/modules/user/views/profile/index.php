<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Редактирование профиля');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Редактирование профиля') => $this->createUrl('update',
        array( 'id' => Yii::app()->request->getQuery('id') )),
);
?>

<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'user-form',
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
                    'label'       => Yii::t('user', 'Сохранить и продолжить'),
                    'icon'        => 'fa fa-floppy-o',
                    'htmlOptions' => array(
                        'name'  => 'submit-type',
                        'value' => 'refresh',
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
                    'label'       => Yii::t('user', 'Сохранить и закрыть'),
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
        <?php if (Yii::app()->user->checkAccess('administrator')): ?>
            <li>
                <a href="#tab3" data-toggle="tab" role="tab"><?php echo Yii::t('user', 'Права'); ?></a>
            </li>
        <?php endif; ?>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <div class="row">
                <div class="col-sm-9">
                    <?php echo $form->textFieldControlGroup($model, 'username'); ?>
                    <?php echo $form->textFieldControlGroup($model, 'email'); ?>
                    <?php echo $form->textFieldControlGroup($profile, 'phone'); ?>
                    <?php echo $form->passwordFieldControlGroup($model, 'new_password'); ?>
                    <?php echo $form->passwordFieldControlGroup($model, 'confirm_password'); ?>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <?php echo $form->labelEx($profile, 'curator'); ?>
                        <div>
                            <?php
                            $profile->curator    = $profile->getCurator();
                            $this->widget('booster.widgets.TbTypeahead',
                                array(
                                'model'       => $profile,
                                'attribute'   => 'curator',
                                'datasets'    => array(
                                    'source' => $model->curatorList
                                ),
                                'htmlOptions' => array(
                                    'class'        => 'form-control',
                                    'autocomplete' => 'on',
                                ),
                                )
                            );
                            ?>
                            <?php echo $form->error($profile, 'curator'); ?>
                        </div>
                    </div>
                    <?php
                    $model->create_date  = Date::format($model->create_date);
                    echo $form->textFieldControlGroup($model, 'create_date', array( 'readonly' => true ));
                    ?>
                    <?php
                    $model->update_date  = Date::format($model->update_date);
                    echo $form->textFieldControlGroup($model, 'update_date', array( 'readonly' => true ));
                    ?>
                    <?php
                    $model->last_visit   = Date::format($model->last_visit);
                    echo $form->textFieldControlGroup($model, 'last_visit', array( 'readonly' => true ));
                    ?>
                    <?php echo $form->dropDownListControlGroup($model, 'status', $model->statusList); ?>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab2">
            <h4 class="title"><?php echo Yii::t('user', 'Паспортные данные'); ?></h4>
            <div class="row">
                <div class="col-sm-6">
                    <?php echo $form->textFieldControlGroup($profile, 'lastname'); ?>
                    <?php echo $form->textFieldControlGroup($profile, 'firstname'); ?>
                    <?php echo $form->textFieldControlGroup($profile, 'patronymic'); ?>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo $form->labelEx($profile, 'birth_date'); ?>
                        <div>
                            <?php
                            $profile->birth_date = Date::format($profile->birth_date, 'd-MM-y');
                            $this->widget('booster.widgets.TbDatePicker',
                                array(
                                'model'       => $profile,
                                'attribute'   => 'birth_date',
                                'options'     => array(
                                    'format'    => 'dd-mm-yyyy',
                                    'autoclose' => true,
                                ),
                                'htmlOptions' => array(
                                    'class' => 'form-control',
                                )
                                )
                            );
                            ?>
                            <?php echo $form->error($profile, 'birth_date'); ?>
                        </div>
                    </div>
                    <?php echo $form->dropDownListControlGroup($profile, 'gender',
                        $profile->genderList); ?>
                </div>
            </div>

            <h4 class="title"><?php echo Yii::t('user', 'Адрес проживания'); ?></h4>
            <div class="row">
                <div class="col-sm-6">
                    <?php echo $form->textFieldControlGroup($profile, 'country'); ?>
                    <?php echo $form->textFieldControlGroup($profile, 'region'); ?>
<?php echo $form->textFieldControlGroup($profile, 'zip_code'); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->textFieldControlGroup($profile, 'city'); ?>
<?php echo $form->textFieldControlGroup($profile, 'address'); ?>
                </div>
            </div>
            <h4 class="title"><?php echo Yii::t('user', 'Cоциальные данные'); ?></h4>
            <div class="row">
                <div class="col-sm-6">
                    <?php echo $form->textFieldControlGroup($profile, 'skype'); ?>
                    <?php echo $form->textFieldControlGroup($profile, 'icq'); ?>
<?php echo $form->textFieldControlGroup($profile, 'vk'); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->textFieldControlGroup($profile, 'fb'); ?>
<?php echo $form->textFieldControlGroup($profile, 'ok'); ?>
                </div>
            </div>
        </div>
<?php if (Yii::app()->user->checkAccess('administrator')): ?>
            <div class="tab-pane" id="tab3">
                <div class="form-group">
                        <?php echo $form->labelEx($model, 'role'); ?>
                    <div>
                        <?php
                        $this->widget('booster.widgets.TbSelect2',
                            array(
                            'model'       => $model,
                            'attribute'   => 'role',
                            'data'        => $model->rolesList,
                            'options'     => array(
                                'placeholder' => Yii::t('user', 'Роль'),
                                'width'       => '100%',
                                'class'       => 'form-control',
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
                <div class="form-group">
                        <?php echo $form->labelEx($model, 'operation'); ?>
                    <div>
                        <?php
                        $this->widget('booster.widgets.TbSelect2',
                            array(
                            'model'       => $model,
                            'attribute'   => 'operation',
                            'data'        => $model->operationList,
                            'options'     => array(
                                'placeholder' => Yii::t('user', 'Операции'),
                                'width'       => '100%',
                                'class'       => 'form-control',
                            ),
                            'htmlOptions' => array(
                                'multiple' => 'multiple',
                                'options'  => $operations,
                            )
                        ));
                        ?>
    <?php echo $form->error($model, 'operation'); ?>
                    </div>
                </div>
            </div>
<?php endif; ?>
    </div>
    <!-- конец: вкладки -->
</div>

<?php $this->endWidget(); ?>