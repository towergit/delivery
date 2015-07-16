<?php
// название страницы
$this->pageTitle = Yii::t('payment', 'История денежных операций');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('payment', 'Платежи'),
);


/*$model = PaymentObject::model()->findByPk('1');
var_dump($model->getrestsum()) ;
exit();*/

?>



<div class="row">
    <div class="col-sm-12">
        
                <?php
        $this->beginWidget('booster.widgets.TbPanel',
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
                            'label'   => Yii::t('material', 'Добавить'),
                            'icon'    => 'fa fa-plus',
                            'url'     => array( 'create' ),
                           // 'visible' => Yii::app()->user->checkAccess('createMaterial'),
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
                array(
                    'name' => 'id_oject',
                    'value' => '$data->object->uniqid',
                ),
                array (
                    'name' => 'ids_list',
                    'type'        => 'raw',
                    'value' => 'CHtml::link($data->object->title, Yii::app()->createUrl("/object/objecthelp/update", array( "id" => $data->object->id),array("target" => "_blank")))',

                ),
                'sum',
                'name',
                'email',
                'phone',
                array(
                    'name' => 'system',
                    'filter' => $model->getSystemList(),
                ),
                array(
                    'name'  => 'rest_sum',
                    'value' => '$data->restsum',
                ),
                array(
                    'name'  => 'total_sum',
                    'value' => '$data->object->totalsum',
                ),
                'date',
                array(
                    'name'  => 'status',
                    'filter' => $model->getStatusList(),
                    'value' => '$data->StatusString'
                ),
               /* array(
                    'class'        => 'booster.widgets.TbToggleColumn',
                    'toggleAction' => 'toggle',
                    'name'         => 'status',
                    'filter'       => $model->statusList,
                    'visible'      => Yii::app()->user->checkAccess('updatePaymentInputMoney'),
                ),*/
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                    'buttons'     => array(
                        'update' => array(
                            //'visible' => 'Yii::app()->user->checkAccess("updatePaymentInputMoney")',
                        ),
                        'delete' => array(
                           // 'visible' => 'Yii::app()->user->checkAccess("deletePaymentInputMoney")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                   /* 'visible'     =>
                    Yii::app()->user->checkAccess("updatePaymentInputMoney")
                    || Yii::app()->user->checkAccess("deletePaymentInputMoney")*/
                ),
            ),
        ));

        $this->endWidget();
        ?>
    </div>
</div>