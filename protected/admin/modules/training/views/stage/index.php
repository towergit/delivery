<?php
// название страницы
$this->pageTitle = Yii::t('training', 'Стадии обучения');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('training', 'Обучающая программа'),
    Yii::t('training', 'Стадии обучения') => array( 'index' ),
);
?>
<div class="row">
    <div class="col-sm-12">
        <?php
        $box               = $this->beginWidget('booster.widgets.TbPanel',
            array(
            'title'         => CHtml::encode($this->pageTitle),
            'padContent'    => false,
            'headerIcon'    => Yii::app()->getModule('training')->icon,
            'headerButtons' => array(
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'success',
                ),
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'success',
                    'buttons'    => array(
                        array(
                            'label'   => Yii::t('training', 'Добавить'),
                            'icon'    => 'fa fa-plus',
                            'url'     => array( 'create' ),
                            'visible' => Yii::app()->user->checkAccess('createTrainingStage'),
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
                'name',
                array(
                    'name' => 'parent_id',
                    'filter' => $model->categoryList,
                    'value' => '$data->parent',
                ),
                array(
                    'class'        => 'booster.widgets.TbToggleColumn',
                    'toggleAction' => 'toggle',
                    'name'         => 'status',
                    'filter'       => $model->statusList,
                    'visible'      => Yii::app()->user->checkAccess('updateTrainingStage'),
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                    'buttons'     => array(
                        'update' => array(
                            'visible' => 'Yii::app()->user->checkAccess("updateTrainingStage")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deleteTrainingStage")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                        Yii::app()->user->checkAccess("updateTrainingStage") 
                        || Yii::app()->user->checkAccess("deleteTrainingStage")
                ),
            ),
        ));

        $this->endWidget();
        ?>
    </div>
</div>