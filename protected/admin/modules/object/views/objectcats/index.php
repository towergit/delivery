<style>

    .objects-list a {
        display: inline-block;
        padding: 8px;
        border: 1px solid #ccc;
    }
    .objects-list a.active{
        background-color: #600029;
        color: #fff;
    }

    .objects-list {
        margin-bottom: 15px;
    }
</style>

<?php
// название страницы
$this->pageTitle = Yii::t('object', 'Категории');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('object', 'Категории объектов помощи') => array('index'),
);

?>

<div class="row">
    <div class="col-sm-12">
        <?php

        $this->beginWidget('booster.widgets.TbPanel', array(
            'title' => CHtml::encode($this->pageTitle),
            'padContent' => false,
            'headerIcon' => Yii::app()->getModule('object')->icon,
            'headerButtons' => array(
                array(
                    'class' => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context' => 'success',
                    'buttons' => array(
                        array(
                            'label' => Yii::t('object', 'Добавить'),
                            'icon' => 'fa fa-plus',
                            'url' => array('/object/objectcats/create'),
                        //'visible' => Yii::app()->user->checkAccess('createObjectHelp'),
                        ),
                    ),
                ),
            ),
            'htmlOptions' => array(
                'class' => 'panel-table'
            ),
        ));


        $this->widget('booster.widgets.TbExtendedGridView', array(
            'sortableRows' => true,
            'sortableAttribute' => 'sort',
            'sortableAjaxSave' => true,
            'sortableAction' => Yii::app()->createUrl('object/objectcats/sort'),
            'type' => 'striped',
            'responsiveTable' => true,
            'dataProvider' => $model->search(),
            'filter' => new ObjectCategory,
            'template' => "{items}\n{pager}",
            /* 'afterAjaxUpdate'   => "function() { 
              $('#Material_publish_date, #Material_unpublish_date').datepicker({
              format: 'dd.mm.yyyy'
              });
              }", */
            'columns' => array(
                array(
                    'name' => 'title',
                    'type' => 'raw',
                ),
                array(
                    'name' => 'alias',
                    'type' => 'raw',
                    'htmlOptions' => array(
                        'style' => 'width: 130px',
                    ),
                ),
                array(
                    'class' => 'booster.widgets.TbToggleColumn',
                    'toggleAction' => 'toggle',
                    'name' => 'status',
                    'filter' => $model->statusList,
                ),
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => '{update} {delete}',
                    'buttons' => array(
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                ),
            ),
        ));

        $this->endWidget();
        ?>

    </div>
</div>