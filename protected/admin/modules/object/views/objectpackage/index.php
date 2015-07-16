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
$this->pageTitle = Yii::t('object', 'Пакеты');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('object', 'Пакеты объектов помощи') => array('index'),
);

$helpObjects = ObjectHelp::model()->findAll();
?>
<h3>Доступные объекты помощи</h3>
<div class="objects-list">
    <?php
    foreach ($helpObjects as $object):

        $active = $object->id == $this->objecthelp ? 'active' : null;
        ?>

        <a class="<?php echo $active; ?>" href="/admin/object/objectpackage?object_id=<?php echo $object->id; ?>"><?php echo $object->title; ?></a>

    <?php endforeach; ?>

    <a href="/admin/object/objecthelp/create" id="yw1" class="btn btn-success"><i class="fa fa-plus"></i> Добавить объект</a>
</div>

<div class="row">
    <div class="col-sm-12">
        <?php
        $addition_url = $this->objecthelp ? '?object_id='.$this->objecthelp : '';
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
                            'url' => array('/admin/object/objectpackage/create'.$addition_url),
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
            'sortableAction' => Yii::app()->createUrl('object/objectpackage/sort'),
            'type' => 'striped',
            'responsiveTable' => true,
            'dataProvider' => $model->search(),
            'filter' => new ObjectPackage,
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
                    'name' => 'sum',
                    'type' => 'raw',
                    'htmlOptions' => array(
                        'style' => 'width: 130px',
                    ),
                ),
                /* array(
                  'name' => 'help_id',
                  'type' => 'raw',
                  'filter' => ObjectHelp::getHelpsList(),
                  'value' => '$data->object->title',
                  ), */
                array(
                    'name' => 'sum_collected',
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
                    'visible' =>
                    Yii::app()->user->checkAccess("updateMaterial") || Yii::app()->user->checkAccess("deleteMaterial")
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