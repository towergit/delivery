<?php
// название страницы
$this->pageTitle = Yii::t('comment', 'Комментарии');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('comment', 'Комментарии') => array( 'index' ),
);
?>
<div class="row">
    <div class="col-sm-12">
        <?php
        $box               = $this->beginWidget('booster.widgets.TbPanel',
            array(
            'title'         => CHtml::encode($this->pageTitle),
            'padContent'    => false,
            'headerIcon'    => Yii::app()->getModule('comment')->icon,
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
                            'label'   => Yii::t('comment', 'Добавить'),
                            'icon'    => 'fa fa-plus',
                            'url'     => array( 'create' ),
                            'visible' => Yii::app()->user->checkAccess('createComment'),
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
                    'header' => 'Контент',
                    'type' => 'raw',
                    'value' => '$data->content',
                ),
                'name',
                'email',
                array(
                    'name'        => 'create_date',
                    'value'       => 'Date::format($data->create_date)',
                    'htmlOptions' => array(
                        'style' => 'width: 170px; text-align: center;',
                    ),
                ),
                array(
                    'name' => 'text',
                    'type' => 'raw',
                    'value' => 'String::wordLimiter($data->text, 5)',
                ),
                array(
                    'name' => 'status',
                    'filter' => $model->statusList,
                    'value' => '$data->getStatus()',
                    'htmlOptions' => array(
                        'style' => 'width: 100px;',
                    ),
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                    'buttons'     => array(
                        'update' => array(
                            'visible' => 'Yii::app()->user->checkAccess("updateComment")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deleteComment")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                    Yii::app()->user->checkAccess("updateComment") || Yii::app()->user->checkAccess("deleteComment")
                )
            ),
        ));

        $this->endWidget();
        ?>
    </div>
</div>