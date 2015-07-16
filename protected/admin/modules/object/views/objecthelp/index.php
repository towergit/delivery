<?php
// название страницы
$this->pageTitle = Yii::t('object', 'Объекты помощи');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('object', 'Объекты помощи') => array( 'index' ),
);
?>

<div class="row">
    <div class="col-sm-12">
        <?php
        $this->beginWidget('booster.widgets.TbPanel',
            array(
            'title'         => CHtml::encode($this->pageTitle),
            'padContent'    => false,
            'headerIcon'    => Yii::app()->getModule('object')->icon,
            'headerButtons' => array(
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'success',
                    'buttons'    => array(
                        array(
                            'label'   => Yii::t('object', 'Добавить'),
                            'icon'    => 'fa fa-plus',
                            'url'     => array( '/admin/object/objecthelp/create' ),
                            //'visible' => Yii::app()->user->checkAccess('createObjectHelp'),
                        ),
                    ),
                ),
            ),
            'htmlOptions'   => array(
                'class' => 'panel-table'
            ),
        ));

        $this->widget('booster.widgets.TbExtendedGridView',
            array(
            'type'              => 'striped',
            'responsiveTable'   => true,
            'dataProvider'      => $model->search(),
            'filter'            => $model,
            'template'          => "{items}\n{pager}",
            'afterAjaxUpdate'   => "function() { 
		$('#ObjectHelp_create_date').datepicker({
                    format: 'dd.mm.yyyy'
		}); 
            }",
            'columns'           => array(
                'title',
                array(
                    'name'        => 'create_date',
                    'value'       => 'Date::format($data->create_date)',
                    'filter'      => $this->widget('booster.widgets.TbDatePicker',
                        array(
                        'model'       => $model,
                        'attribute'   => 'create_date',
                        'options'     => array(
                            'lang'   => Yii::app()->language,
                            'format' => 'dd.mm.yyyy',
                        ),
                        'htmlOptions' => array(
                            'class'       => 'form-control',
                            'placeholder' => '',
                        ),
                        ), true
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 130px; text-align: center;',
                    ),
                ),
                array(
                    'class'        => 'booster.widgets.TbToggleColumn',
                    'toggleAction' => 'toggle',
                    'name'         => 'status',
                    'filter'       => $model->statusList,
//                    'visible'      => Yii::app()->user->checkAccess('updateObjectHelp'),
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                    'buttons'     => array(
//                        'update' => array(
//                            'visible' => 'Yii::app()->user->checkAccess("updateObjectHelp")',
//                        ),
//                        'delete' => array(
//                            'visible' => 'Yii::app()->user->checkAccess("deleteObjectHelp")',
//                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
//                    'visible'     =>
//                        Yii::app()->user->checkAccess("updateObjectHelp") 
//                        || Yii::app()->user->checkAccess("deleteObjectHelp")
                ),
            ),
        ));

        $this->endWidget();
        ?>
    </div>
</div>