<?php
// название страницы
$this->pageTitle = Yii::t('payment', 'Заявки на вывод средств');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('payment', 'Платежи'),
    Yii::t('payment', 'Заявки на вывод средств') => array( 'index' ),
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
                            'visible' => Yii::app()->user->checkAccess('createPaymentOutputMoney'),
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
            'columns'         => array(
                'code',
                'sum',
                array(
                    'name'  => 'user_id',
                    'value' => '$data->user->username',
                ),
                array(
                    'name' => 'purse_id',
                    'value' => '$data->purse->name',
                    'filter' => $paymentPurse->purseList,
                ),
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
                    'visible'      => Yii::app()->user->checkAccess('updatePaymentOutputMoney'),
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                    'buttons'     => array(
                        'update' => array(
                            'visible' => 'Yii::app()->user->checkAccess("updatePaymentOutputMoney")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deletePaymentOutputMoney")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                    Yii::app()->user->checkAccess("updatePaymentOutputMoney")
                    || Yii::app()->user->checkAccess("deletePaymentOutputMoney")
                ),
            ),
        ));

        $this->endWidget();
        ?>
    </div>
</div>