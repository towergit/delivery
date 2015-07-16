<?php
// название страницы
$this->pageTitle = Yii::t('menu', 'Список меню');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('menu', 'Управление меню'),
    Yii::t('menu', 'Список меню') => array( 'index' ),
);
?>
<div class="row">
    <div class="col-sm-12">
        <?php
        $box               = $this->beginWidget('booster.widgets.TbPanel',
            array(
            'title'         => CHtml::encode($this->pageTitle),
            'padContent'    => false,
            'headerIcon'    => Yii::app()->getModule('menu')->icon,
            'headerButtons' => array(
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'success',
                    'buttons'    => array(
                        array(
                            'label'   => Yii::t('menu', 'Добавить'),
                            'icon'    => 'fa fa-plus',
                            'url'     => array( 'create' ),
                            'visible' => Yii::app()->user->checkAccess('createMenu'),
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
                array(
                    'name'        => 'title',
                    'htmlOptions' => array(
                        'style' => 'width: 250px',
                    ),
                ),
                array(
                    'name'        => 'code',
                    'htmlOptions' => array(
                        'style' => 'width: 250px',
                    ),
                ),
                array(
                    'header'      => Yii::t('menu', 'Пунктов'),
                    'type'        => 'raw',
                    'value'       => 'CHtml::link(count($data->menuItems), Yii::app()->createUrl("/menu/menuitem/index", array( "menu_id" => $data->id )))',
                    'htmlOptions' => array(
                        'style' => 'width: 80px',
                        'class' => 'text-center',
                    ),
                ),
                'description',
                array(
                    'class'        => 'booster.widgets.TbToggleColumn',
                    'toggleAction' => 'toggle',
                    'name'         => 'status',
                    'filter'       => $model->statusList,
                    'visible'      => Yii::app()->user->checkAccess('updateMenu'),
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                    'buttons'     => array(
                        'update' => array(
                            'visible' => 'Yii::app()->user->checkAccess("updateMenu")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deleteMenu")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                    Yii::app()->user->checkAccess("updateMenu") || Yii::app()->user->checkAccess("deleteMenu")
                )
            ),
        ));

        $this->endWidget();
        ?>
    </div>
</div>