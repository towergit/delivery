<?php
// название страницы
$this->pageTitle = Yii::t('language', 'Языки');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('language', 'Языки') => array( 'index' ),
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
            'headerIcon'    => Yii::app()->getModule('language')->icon,
            'headerButtons' => array(
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'success',
                    'buttons'    => array(
                        array(
                            'label'   => Yii::t('language', 'Добавить'),
                            'icon'    => 'fa fa-plus',
                            'url'     => array( 'create' ),
                            'visible' => Yii::app()->user->checkAccess('createLanguage'),
                        ),
                    ),
                ),
            ),
            'htmlOptions'   => array( 
                'class' => 'panel-table'
            ),
            )
        );
        $this->widget('booster.widgets.TbExtendedGridView',
            array(
            'type'            => 'striped',
            'responsiveTable' => true,
            'dataProvider'    => $model->search(),
            'filter'          => $model,
            'template'        => "{items}\n{pager}",
            'columns'         => array(
                'title',
                'url',
                'local',
                array(
                    'class'        => 'booster.widgets.TbToggleColumn',
                    'toggleAction' => 'toggle',
                    'name'         => 'default',
                    'filter'       => '',
                    'visible'      => Yii::app()->user->checkAccess('updateLanguage'),
                ),
                array(
                    'class'        => 'booster.widgets.TbToggleColumn',
                    'toggleAction' => 'toggle',
                    'name'         => 'status',
                    'filter'       => $model->statusList,
                    'visible'      => Yii::app()->user->checkAccess('updateLanguage'),
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                    'buttons'     => array(
                        'update' => array(
                            'visible' => 'Yii::app()->user->checkAccess("updateLanguage")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deleteLanguage")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                        Yii::app()->user->checkAccess("updateLanguage") || 
                        Yii::app()->user->checkAccess("deleteLanguage")
                )
            ),
            )
        );
        $this->endWidget();
        ?>
    </div>
</div>