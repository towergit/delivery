<?php
// название страницы
$this->pageTitle = Yii::t('share', 'Заявки на покупку акций');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('share', 'Акции'),
    Yii::t('share', 'Заявки на покупку акций') => array( 'index' ),
);
?>

<div class="row">
    <div class="col-sm-12">
        <?php
        $box               = $this->beginWidget('booster.widgets.TbPanel',
            array(
            'title'         => CHtml::encode($this->pageTitle),
            'padContent'    => false,
            'headerIcon'    => Yii::app()->getModule('share')->icon,
            'headerButtons' => array(
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'success',
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
            'afterAjaxUpdate' => "function() { 
		$('#SharePurchase_create_date, #SharePurchase_update_date').datepicker({
                    format: 'dd.mm.yyyy'
		}); 
            }",
            'columns'         => array(
                array(
                    'name'  => 'user_id',
                    'value' => '$data->user->username',
                ),
                array(
                    'name'   => 'type_id',
                    'filter' => $type->typeList,
                    'value'  => '$data->type->title',
                ),
                'count',
                'price',
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
                        'style' => 'width: 150px; text-align: center;',
                    ),
                ),
                array(
                    'name'        => 'update_date',
                    'value'       => '$data->update_date != null ? Date::format($data->update_date) : ""',
                    'filter'      => $this->widget('booster.widgets.TbDatePicker',
                        array(
                        'model'       => $model,
                        'attribute'   => 'update_date',
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
                        'style' => 'width: 150px; text-align: center;',
                    ),
                ),
                array(
                    'name' => 'status',
                    'filter' => $model->statusList,
                    'value' => '$data->getStatus()',
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                    'buttons'     => array(
                        'update' => array(
                            'visible' => 'Yii::app()->user->checkAccess("updateSharePurchase")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deleteSharePurchase")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                    Yii::app()->user->checkAccess("updateSharePurchase")
                    || Yii::app()->user->checkAccess("deleteSharePurchase")
                )
            ),
        ));

        $this->endWidget();
        ?>
    </div>
</div>