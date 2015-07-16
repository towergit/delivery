<?php
// название страницы
$this->pageTitle = Yii::t('event', 'Список событий');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('event', 'События'),
    Yii::t('event', 'Список событий') => array( 'index' ),
);
?>

<div class="row">
    <div class="col-sm-12">
        <?php
        $box               = $this->beginWidget('booster.widgets.TbPanel',
            array(
            'title'         => CHtml::encode($this->pageTitle),
            'padContent'    => false,
            'headerIcon'    => Yii::app()->getModule('event')->icon,
            'headerButtons' => array(
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'success',
                    'buttons'    => array(
                        array(
                            'label'   => Yii::t('event', 'Добавить'),
                            'icon'    => 'fa fa-plus',
                            'url'     => array( 'create' ),
                            'visible' => Yii::app()->user->checkAccess('createEvent'),
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
            'type'            => 'striped',
            'responsiveTable' => true,
            'dataProvider'    => $model->search(),
            'filter'          => $model,
            'template'        => "{items}\n{pager}",
            'afterAjaxUpdate'   => "function() { 
		$('#Event_start_date, #Event_end_date').datepicker({
                    format: 'dd.mm.yyyy'
		}); 
            }",
            'columns'         => array(
                array(
                    'name'  => 'title',
                    'type'  => 'raw',
                    'value' => '$data->title . "<br /><small>Алиас: " . $data->alias . "</small>"',
                ),
                array(
                    'name'        => 'category_id',
                    'type'        => 'raw',
                    'filter'      => $category->parentList,
                    'value'       => 'CHtml::link($data->category->title, Yii::app()->createUrl("/event/category/update", array( "id" => $data->category->id )))',
                    'htmlOptions' => array(
                        'style' => 'width: 210px',
                    ),
                ),
                array(
                    'name'        => 'start_date',
                    'value'       => 'Date::format($data->start_date)',
                    'filter'      => $this->widget('booster.widgets.TbDatePicker',
                        array(
                        'model'       => $model,
                        'attribute'   => 'start_date',
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
                    'name'        => 'end_date',
                    'value'       => '$data->endDate',
                    'filter'      => $this->widget('booster.widgets.TbDatePicker',
                        array(
                        'model'       => $model,
                        'attribute'   => 'end_date',
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
                    'visible'      => Yii::app()->user->checkAccess('updateEvent'),
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                    'buttons'     => array(
                        'update' => array(
                            'visible' => 'Yii::app()->user->checkAccess("updateEvent")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deleteEvent")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                        Yii::app()->user->checkAccess("updateEvent") 
                        || Yii::app()->user->checkAccess("deleteEvent")
                )
            ),
        ));

        $this->endWidget();
        ?>
    </div>
</div>