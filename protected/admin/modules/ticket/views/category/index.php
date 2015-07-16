<?php
// название страницы
$this->pageTitle = Yii::t('ticket', 'Категории тикетов');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('ticket', 'Тикеты'),
    Yii::t('ticket', 'Категории тикетов') => array( 'index' ),
);
?>

<div class="row">
    <div class="col-sm-12">
        <?php
        $box               = $this->beginWidget('booster.widgets.TbPanel',
            array(
            'title'         => CHtml::encode($this->pageTitle),
            'padContent'    => false,
            'headerIcon'    => Yii::app()->getModule('ticket')->icon,
            'headerButtons' => array(
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'success',
                    'buttons'    => array(
                        array(
                            'label'   => Yii::t('ticket', 'Добавить'),
                            'icon'    => 'fa fa-plus',
                            'url'     => array( 'create' ),
                            'visible' => Yii::app()->user->checkAccess('createTicketCategory'),
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
		$('#TicketCategory_create_date').datepicker({
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
                    'name'        => 'parent_id',
                    'filter'      => $model->categoryList,
                    'value'       => '$data->parent',
                    'htmlOptions' => array(
                        'style' => 'width: 170px',
                    ),
                ),
                array(
                    'name'        => 'create_date',
                    'value'       => 'Date::format($data->create_date)',
                    'filter'      => $this->widget('booster.widgets.TbDatePicker',
                        array(
                        'model'       => $model,
                        'attribute'   => 'create_date',
                        'options'     => array(
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
                    'visible'      => Yii::app()->user->checkAccess('updateTicketCategory'),
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                    'buttons'     => array(
                        'update' => array(
                            'visible' => 'Yii::app()->user->checkAccess("updateTicketCategory")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deleteTicketCategory")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                        Yii::app()->user->checkAccess("updateTicketCategory") 
                        || Yii::app()->user->checkAccess("deleteTicketCategory")
                )
            ),
        ));
        $this->endWidget();
        ?>
    </div>
</div>