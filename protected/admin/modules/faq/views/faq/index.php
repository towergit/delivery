<?php
// название страницы
$this->pageTitle = Yii::t('faq', 'Список FAQ');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('faq', 'FAQ'),
    Yii::t('faq', 'Список FAQ') => array( 'index' ),
);
?>
<div class="row">
    <div class="col-sm-12">
        <?php
        $box               = $this->beginWidget('booster.widgets.TbPanel',
            array(
            'title'         => CHtml::encode($this->pageTitle),
            'padContent'    => false,
            'headerIcon'    => Yii::app()->getModule('faq')->icon,
            'headerButtons' => array(
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'success',
                    'buttons'    => array(
                        array(
                            'label'   => Yii::t('faq', 'Добавить'),
                            'icon'    => 'fa fa-plus',
                            'url'     => array( 'create' ),
                            'visible' => Yii::app()->user->checkAccess('createFAQ'),
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
            'sortableAction'    => Yii::app()->createUrl('faq/faq/sort'),
            'type'              => 'striped',
            'responsiveTable'   => true,
            'dataProvider'      => $model->search(),
            'filter'            => $model,
            'template'          => "{items}\n{pager}",
            'afterAjaxUpdate'   => "function() { 
		$('#Faq_create_date').datepicker({
                    format: 'dd.mm.yyyy'
		}); 
            }",
            'columns'           => array(
                'question',
                array(
                    'name'        => 'category_id',
                    'type'        => 'raw',
                    'filter'      => $category->parentList,
                    'value'       => 'CHtml::link($data->category->title, Yii::app()->createUrl("/faq/category/update", array( "id" => $data->category->id )))',
                    'htmlOptions' => array(
                        'style' => 'width: 250px',
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
                            'visible' => 'Yii::app()->user->checkAccess("updateFAQ")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deleteFAQ")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                        Yii::app()->user->checkAccess("updateFAQ") 
                        || Yii::app()->user->checkAccess("deleteFAQ")
                ),
            ),
        ));

        $this->endWidget();
        ?>
    </div>
</div>