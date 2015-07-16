<?php
// название страницы
$this->pageTitle = Yii::t('payment', 'Кошельки платежных систем');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('payment', 'Платежи'),
    Yii::t('payment', 'Кошельки платежных систем') => array( 'index' ),
);
?>

<div class="row">
    <div class="col-sm-12">
        <?php
        $box               = $this->beginWidget('booster.widgets.TbPanel',
            array(
            'title'         => CHtml::encode($this->pageTitle),
            'padContent'    => false,
            'headerIcon'    => Yii::app()->getModule('payment')->icon,
            'headerButtons' => array(
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'success',
                    'buttons'    => array(
                        array(
                            'label'   => Yii::t('payment', 'Добавить'),
                            'icon'    => 'fa fa-plus',
                            'url'     => array( 'create' ),
                            'visible' => Yii::app()->user->checkAccess('createPaymentPurse'),
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
            'columns'           => array(
                array(
                    'name'  => 'name',
                    'type'  => 'raw',
                    'value' => '$data->name . "<br /><small>Алиас: " . $data->alias . "</small>"',
                ),
                'pattern',
                'example',
                array(
                    'name'        => 'payment_system_id',
                    'value'       => '$data->paymentSystem->title',
                    'filter'      => $paymentSystem->systemList,
                    'htmlOptions' => array(
                        'style' => 'width: 150px',
                    ),
                ),
                array(
                    'class'        => 'booster.widgets.TbToggleColumn',
                    'toggleAction' => 'toggle',
                    'name'         => 'status',
                    'filter'       => $model->statusList,
                    'visible'      => Yii::app()->user->checkAccess('updateFAQ'),
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                    'buttons'     => array(
                        'update' => array(
                            'visible' => 'Yii::app()->user->checkAccess("updatePaymentPurse")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deletePaymentPurse")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                        Yii::app()->user->checkAccess("updatePaymentPurse") 
                        || Yii::app()->user->checkAccess("deletePaymentPurse")
                ),
            ),
        ));

        $this->endWidget();
        ?>
    </div>
</div>