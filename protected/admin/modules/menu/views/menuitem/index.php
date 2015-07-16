<?php
// название страницы
$this->pageTitle = Yii::t('menu', 'Список пунктов меню');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('menu', 'Управление меню')     => $this->createUrl('/menu/menu/index'),
    Yii::t('menu', 'Список пунктов меню') => array( 'index', 'menu_id' => Yii::app()->request->getQuery('menu_id') ),
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
                            'url'     => $this->createUrl('create',
                                array( 'menu_id' => Yii::app()->request->getQuery('menu_id') )),
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
                'title',
                'href',
                array(
                    'name'        => 'menu_id',
                    'type'        => 'raw',
                    'filter'      => $model->menuList,
                    'value'       => 'CHtml::link($data->menu->title, Yii::app()->createUrl("/menu/menu/update", array("id" => $data->menu->id)))',
                    'visible'     => Yii::app()->user->checkAccess('updateMenu'),
                    'htmlOptions' => array(
                        'style' => 'width: 160px',
                    ),
                ),
                array(
                    'name'        => 'parent_id',
                    'value'       => '$data->parent',
                    'htmlOptions' => array(
                        'style' => 'width: 160px',
                    ),
                ),
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
                            'url'     => 'Yii::app()->createUrl("/menu/menuitem/update", array( "menu_id" => $data->menu->id, "id" => $data->id ))',
                            'visible' => 'Yii::app()->user->checkAccess("updateMenu")',
                        ),
                        'delete' => array(
                            'url'     => 'Yii::app()->createUrl("/menu/menuitem/delete", array( "menu_id" => $data->menu->id, "id" => $data->id ))',
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