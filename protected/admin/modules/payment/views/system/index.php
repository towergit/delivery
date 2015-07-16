<?php
// название страницы
$this->pageTitle = Yii::t('payment', 'Платежные системы');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('payment', 'Платежи'),
    Yii::t('payment', 'Платежные системы') => array( 'index' ),
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
                           // 'visible' => Yii::app()->user->checkAccess('createPaymentPaymentSystem'),
                        ),
                    ),
                ),
            ),
            'htmlOptions'   => array(
                'class' => 'panel-table'
            ),
        ));

        $this->widget('booster.widgets.TbExtendedGridView', array(
            'sortableRows' => true,
            'sortableAttribute' => 'sort',
            'sortableAjaxSave' => true,
            'sortableAction' => Yii::app()->createUrl('payment/system/sort'),
            'type' => 'striped',
            'responsiveTable' => true,
            'dataProvider' => $model->search(),
            'filter' => new PaymentSystem,
            'template' => "{items}\n{pager}",
            'columns'         => array(
                'title',
                'code',
                array(
                    'header'      => Yii::t('payment', 'Кошельков'),
                    'type'        => 'raw',
                    'value'       => 'CHtml::link(count($data->purses), Yii::app()->createUrl("/payment/purse/index"))',
                    'htmlOptions' => array(
                        'style' => 'width: 50px; text-align: center;',
                    ),
                    'visible'      => Yii::app()->user->checkAccess('showPaymentPurse'),
                ),
                array(
                    'name'  => 'site',
                    'type'  => 'raw',
                    'value' => 'String::createUrlLink($data->site)',
                ),
                array(
                    'name'        => 'type',
                    'value'       => '$data->getType()',
                    'filter'      => $model->typeList,
                    'htmlOptions' => array(
                        'style' => 'width: 150px',
                    ),
                ),
                array(
                    'class'        => 'booster.widgets.TbToggleColumn',
                    'toggleAction' => 'toggle',
                    'name'         => 'debug',
                    'filter'       => $model->debugList,
                    'visible'      => Yii::app()->user->checkAccess('updatePaymentPaymentSystem'),
                ),
                array(
                    'class'        => 'booster.widgets.TbToggleColumn',
                    'toggleAction' => 'toggle',
                    'name'         => 'status',
                    'filter'       => $model->statusList,
                   # 'visible'      => Yii::app()->user->checkAccess('updateFAQ'),
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                   /* 'buttons'     => array(
                        'update' => array(
                            'visible' => 'Yii::app()->user->checkAccess("updatePaymentPaymentSystem")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deletePaymentPaymentSystem")',
                        ),
                    ),*/
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                   /* 'visible'     =>
                    Yii::app()->user->checkAccess("updatePaymentPaymentSystem")
                    || Yii::app()->user->checkAccess("deletePaymentPaymentSystem")*/
                ),
            ),
        ));

        $this->endWidget();
        ?>
    </div>
</div>