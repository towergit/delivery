<?php
// название страницы
$this->pageTitle = Yii::t('user', 'Преподаватели');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи'),
    Yii::t('user', 'Преподаватели') => array( 'index' ),
);
?>

<div class="row">
    <div class="col-sm-12">
        <?php
        $box = $this->beginWidget('booster.widgets.TbPanel',
            array(
            'title'         => CHtml::encode($this->pageTitle),
            'padContent'    => false,
            'headerIcon'    => Yii::app()->getModule('user')->icon,
            'headerButtons' => array(
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'success',
                    'buttons'    => array(
                        array(
                            'label'   => Yii::t('user', 'Добавить'),
                            'icon'    => 'fa fa-plus',
                            'url'     => array( 'create' ),
                            'visible' => Yii::app()->user->checkAccess('createUserEducator')
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
                'username',
                'email',
                array(
                    'name'  => 'create_date',
                    'value' => 'Date::format($data->create_date)',
                    'htmlOptions' => array(
                        'style' => 'width: 170px; text-align: center;',
                    ),
                ),
                array(
                    'class'        => 'booster.widgets.TbToggleColumn',
                    'toggleAction' => 'toggle',
                    'name'         => 'status',
                    'filter'       => $model->statusList,
                    'visible'      => Yii::app()->user->checkAccess('updateUserEducator'),
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{update} {delete}',
                    'buttons'     => array(
                        'update' => array(
                            'visible' => 'Yii::app()->user->checkAccess("updateUserEducator")',
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("deleteUserEducator")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                        Yii::app()->user->checkAccess("updateUserEducator")
                        || Yii::app()->user->checkAccess("deleteUserEducator")
                )
            ),
        ));
        $this->endWidget();
        ?>
    </div>
</div>