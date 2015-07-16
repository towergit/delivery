<?php
// название страницы
$this->pageTitle = Yii::t('material', 'Список материалов');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('material', 'Материалы'),
    Yii::t('material', 'Список материалов') => array( 'index' ),
);
?>
<div class="row">
    <div class="col-sm-12">
        <?php
        $box               = $this->beginWidget('booster.widgets.TbPanel',
            array(
            'title'         => CHtml::encode($this->pageTitle),
            'padContent'    => false,
            'headerIcon'    => Yii::app()->getModule('material')->icon,
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
                            'visible' => Yii::app()->user->checkAccess('createMaterial'),
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
            'sortableRows'      => true,
            'sortableAttribute' => 'sort',
            'sortableAjaxSave'  => true,
            'sortableAction'    => Yii::app()->createUrl('material/material/sort'),
            'type'              => 'striped',
            'responsiveTable'   => true,
            'dataProvider'      => $model->search(),
            'filter'            => $model,
            'template'          => "{items}\n{pager}",
            'afterAjaxUpdate'   => "function() { 
		$('#Material_publish_date, #Material_unpublish_date').datepicker({
                    format: 'dd.mm.yyyy'
		}); 
            }",
            'columns'           => array(
                array(
                    'name'  => 'title',
                    'type'  => 'raw',
                    'value' => 'String::wordLimiter($data->title, 4) . "<br /><small>Алиас: " . $data->alias . "</small>"',
                ),
                array(
                    'class'         => 'booster.widgets.TbToggleColumn',
                    'toggleAction'  => 'toggle',
                    'name'          => 'elect',
                    'checkedIcon'   => 'star',
                    'uncheckedIcon' => 'star-empty',
                    'filter'        => $model->electList,
                    'visible'       => Yii::app()->user->checkAccess('updateMaterial'),
                ),
                array(
                    'name'        => 'category_id',
                    'type'        => 'raw',
                    'filter'      => $category->parentList,
                    'value'       => 'CHtml::link($data->category->title, Yii::app()->createUrl("/material/category/update", array( "id" => $data->category->id )))',
                    'htmlOptions' => array(
                        'style' => 'width: 130px',
                    ),
                ),
                array(
                    'name'        => 'create_user_id',
                    'type'        => 'raw',
                    'value'       => 'CHtml::link($data->createUser->username, Yii::app()->createUrl("/user/user/update", array( "id" => $data->createUser->id )))',
                    'htmlOptions' => array(
                        'style' => 'width: 130px',
                    ),
                ),
                array(
                    'name'        => 'publish_date',
                    'value'       => 'Date::format($data->publish_date)',
                    'filter'      => $this->widget('booster.widgets.TbDatePicker',
                        array(
                        'model'       => $model,
                        'attribute'   => 'publish_date',
                        'options'     => array(
                            'lang'   => Yii::app()->language,
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
                    'name'        => 'unpublish_date',
                    'value'       => '$data->unpublishDate',
                    'filter'      => $this->widget('booster.widgets.TbDatePicker',
                        array(
                        'model'       => $model,
                        'attribute'   => 'unpublish_date',
                        'options'     => array(
                            'lang'   => Yii::app()->language,
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
                    'name'        => 'visits',
                    'htmlOptions' => array(
                        'style' => 'width: 30px; text-align: center;',
                    ),
                ),
                array(
                    'class'        => 'booster.widgets.TbToggleColumn',
                    'toggleAction' => 'toggle',
                    'name'         => 'status',
                    'filter'       => $model->statusList,
                    'visible'      => Yii::app()->user->checkAccess('updateMaterial'),
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                    'buttons'     => array(
                        'update' => array(
                            'visible' => 'Yii::app()->user->checkAccess("updateMaterial")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deleteMaterial")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                        Yii::app()->user->checkAccess("updateMaterial") 
                        || Yii::app()->user->checkAccess("deleteMaterial")
                ),
            ),
        ));

        $this->endWidget();
        ?>
    </div>
</div>