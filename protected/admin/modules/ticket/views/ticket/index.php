<?php
// название страницы
$this->pageTitle = Yii::t('ticket', 'Список тикетов');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('ticket', 'Тикеты'),
    Yii::t('ticket', 'Список тикетов') => array( 'index' ),
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
                            'visible' => Yii::app()->user->checkAccess('createTicket'),
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
		$('#Ticket_create_date, #Ticket_close_date').datepicker({
                    format: 'dd.mm.yyyy'
		}); 
            }",
            'columns'         => array(
                'code',
                array(
                    'name' => 'user_id',
                    'value' => '$data->user ? $data->user->username : ""',
                ),
                array(
                    'name'        => 'category_id',
                    'filter'      => $category->parentList,
                    'value'       => '$data->category->title',
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
                    'name'        => 'close_date',
                    'value'       => '$data->close_date ? Date::format($data->close_date) : "' . Yii::t('ticket', 'не закрыт') . '"',
                    'filter'      => $this->widget('booster.widgets.TbDatePicker',
                        array(
                        'model'       => $model,
                        'attribute'   => 'close_date',
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
                    'visible'      => Yii::app()->user->checkAccess('updateTicket'),
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{view} {update} {delete}',
                    'buttons'     => array(
                        'view' => array(
                            'visible' => 'Yii::app()->user->checkAccess("showTicketMessage")',
                        ),
                        'update' => array(
                            'visible' => 'Yii::app()->user->checkAccess("updateTicket")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deleteTicket")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                        Yii::app()->user->checkAccess("showTicketMessage")
                        || Yii::app()->user->checkAccess("updateTicket") 
                        || Yii::app()->user->checkAccess("deleteTicket")
                )
            ),
        ));
        $this->endWidget();
        ?>
    </div>
</div>