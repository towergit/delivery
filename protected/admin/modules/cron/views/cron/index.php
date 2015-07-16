<?php
// название страницы
$this->pageTitle = Yii::t('cron', 'Планировщик задач');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('cron', 'Планировщик задач') => array( 'index' ),
);
?>

<div class="row">
    <div class="col-sm-12">
        <?php
        $box = $this->beginWidget(
            'booster.widgets.TbPanel',
            array(
            'title'         => CHtml::encode($this->pageTitle),
            'padContent'    => false,
            'headerIcon'    => Yii::app()->getModule('cron')->icon,
            'headerButtons' => array(
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'success',
                    'buttons'    => array(
                        array(
                            'label'   => Yii::t('cron', 'Создать'),
                            'icon'    => 'fa fa-plus',
                            'url'     => array( 'create' ),
                            'visible' => Yii::app()->user->checkAccess('createCron'),
                        ),
                    ),
                ),
            ),
            'htmlOptions'   => array( 'class' => 'panel-table' ),
            )
        );
        $this->widget('booster.widgets.TbExtendedGridView',
            array(
            'type'            => 'striped',
            'responsiveTable' => true,
            'dataProvider'    => $model->search(),
            'filter'          => $model,
            'template'        => "{items}",
            'columns'         => array(
                'name',
                array(
                    'name'        => 'execution',
                    'htmlOptions' => array(
                        'style' => 'width: 150px; text-align: center;',
                    ),
                ),
                array(
                    'class'        => 'booster.widgets.TbToggleColumn',
                    'toggleAction' => 'toggle',
                    'name'         => 'status',
                    'filter'       => $model->statusList,
                    'visible'      => Yii::app()->user->checkAccess('updateCron'),
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                    'buttons'     => array(
                        'update' => array(
                            'visible' => 'Yii::app()->user->checkAccess("updateCron")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deleteCron")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                    Yii::app()->user->checkAccess("updateCron") || Yii::app()->user->checkAccess("deleteCron"),
                )
            ),
            )
        );
        $this->endWidget();
        ?>
    </div>
</div>