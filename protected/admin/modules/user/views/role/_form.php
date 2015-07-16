<?php
$form = $this->beginWidget('BsActiveForm',
    array(
    'id'                   => 'authitem-form',
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
            <a href="#tab2" data-toggle="tab" role="tab"><?php echo Yii::t('user', 'Назначения'); ?></a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <div class="row">
                <div class="col-sm-12">
                    <?php echo $form->textFieldControlGroup($model, 'name'); ?>
                    <?php echo $form->textFieldControlGroup($model, 'description'); ?>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab2">
            <a href="#" class="check-all">Выбрать все</a>
            <a href="#" class="uncheck-all">Отменить все</a>
            <?php
            foreach($operations as $obj)
            {
                (!isset($count)) ? $count = count($operations) : '';
                (isset($k)) ? $k++ : $k     = 1;
                (isset($i)) ? $i++ : $i     = 1;
                if ($i == 1)
                {
                    echo '<div class="row">';
                }
                {
                    echo '<div class="col-xs-4">';
                    {
                        echo CHtml::openTag('div', array( 'class' => "checkbox" ));
                        echo CHtml::hiddenField('operations[' . $obj->name . ']', 0);
                        echo CHtml::label(CHtml::checkBox('operations[' . $obj->name . ']', in_array($obj->name, $childrens),
                                array( 'id' => $obj->name )) . ' ' . $obj->description, $obj->name);
                        echo CHtml::closeTag('div');
                    }
                    echo CHtml::closeTag('div');
                }
                if ($i >= 3 || $count === $k)
                {
                    echo '</div>';
                    $i = 0;
                }
            }
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<script>
    $('.check-all').click(function(e) {
        e.preventDefault();

        $('input[type="checkbox"]').prop('checked', true);
    });

    $('.uncheck-all').click(function(e) {
        e.preventDefault();

        $('input[type="checkbox"]').prop('checked', false);
    });
</script>