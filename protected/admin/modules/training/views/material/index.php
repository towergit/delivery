<?php
// название страницы
$this->pageTitle = Yii::t('training', 'Список материалов обучения');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('training', 'Обучающая программа'),
    Yii::t('training', 'Список материалов обучения') => array( 'index' ),
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
                    'buttons'    => array(
                        array(
                            'label'   => Yii::t('training', 'Добавить'),
                            'icon'    => 'fa fa-plus',
                            'url'     => array( 'create' ),
                            'visible' => Yii::app()->user->checkAccess('createTrainingMaterial'),
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
                'title',
                array(
                    'name'        => 'parent_id',
                    'type'        => 'raw',
                    'filter'      => $model->categoryList,
                    'value'       => '$data->parent',
                    'htmlOptions' => array(
                        'style' => 'width: 230px',
                    ),
                ),
                array(
                    'name'        => 'program_id',
                    'type'        => 'raw',
                    'filter'      => $program->categoryList,
                    'value'       => '$data->program ? $data->program->name : ""',
                    'htmlOptions' => array(
                        'style' => 'width: 200px',
                    ),
                ),
                array(
                    'name'        => 'type',
                    'filter'      => $model->typeList,
                    'value'       => '$data->getType()',
                    'htmlOptions' => array(
                        'style' => 'width: 100px',
                    ),
                ),
                array(
                    'class'        => 'booster.widgets.TbToggleColumn',
                    'toggleAction' => 'toggle',
                    'name'         => 'status',
                    'filter'       => $model->statusList,
                    'visible'      => Yii::app()->user->checkAccess('updateTrainingMaterial'),
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                    'buttons'     => array(
                        'update' => array(
                            'visible' => 'Yii::app()->user->checkAccess("updateTrainingMaterial")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deleteTrainingMaterial")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                        Yii::app()->user->checkAccess("updateTrainingMaterial") 
                        || Yii::app()->user->checkAccess("deleteTrainingMaterial")
                )
            ),
        ));

        $this->endWidget();
        ?>
    </div>
</div>