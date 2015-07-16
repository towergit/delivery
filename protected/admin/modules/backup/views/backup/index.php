<?php
// название страницы
$this->pageTitle = Yii::t('backup', 'Резервные копии');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('backup', 'Резервные копии') => array( 'index' ),
);
?>

<div class="row">
    <div class="col-sm-12">
        <?php
        $box               = $this->beginWidget(
            'booster.widgets.TbPanel',
            array(
            'title'         => CHtml::encode($this->pageTitle),
            'padContent'    => false,
            'headerIcon'    => 'fa fa-database',
            'headerButtons' => array(
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'danger',
                    'buttons'    => array(
                        array(
                            'label'   => Yii::t('backup', 'Очистить таблицы'),
                            'icon'    => Yii::app()->getModule('backup')->icon,
                            'url'     => array( 'truncate' ),
                            'visible' => Yii::app()->user->checkAccess('truncateBackupDataBase'),
                        ),
                    ),
                ),
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'danger',
                    'buttons'    => array(
                        array(
                            'label'   => Yii::t('backup', 'Удалить все back-up'),
                            'icon'    => 'fa fa-trash-o',
                            'url'     => array( 'remove' ),
                            'visible' => Yii::app()->user->checkAccess('removeBackup'),
                        ),
                    ),
                ),
                array(
                    'class'      => 'booster.widgets.TbButtonGroup',
                    'buttonType' => 'link',
                    'context'    => 'success',
                    'buttons'    => array(
                        array(
                            'label'   => Yii::t('backup', 'Создать'),
                            'icon'    => 'fa fa-plus',
                            'url'     => array( 'create' ),
                            'visible' => Yii::app()->user->checkAccess('createBackup'),
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
            'dataProvider'    => $dataProvider,
            'template'        => "{items}\n{pager}",
            'columns'         => array(
                array(
                    'header'      => '#',
                    'value'       => '$data["id"]',
                    'htmlOptions' => array(
                        'width' => '50'
                    ),
                ),
                array(
                    'header' => Yii::t('backup', 'Название'),
                    'value'  => '$data["basename"]',
                ),
                array(
                    'header' => Yii::t('backup', 'Дата создания'),
                    'value'  => 'Date::format($data["created"])',
                ),
                array(
                    'header' => Yii::t('backup', 'Размер'),
                    'value'  => '$data["size"]',
                ),
                array(
                    'class'       => 'booster.widgets.TbButtonColumn',
                    'template'    => '{download} {restore} {delete}',
                    'buttons'     => array(
                        'download' => array(
                            'url'     => 'Yii::app()->createUrl("/backup/backup/download", array( "file" => $data["basename"] ))',
                            'icon'    => 'fa fa-download',
                            'visible' => 'Yii::app()->user->checkAccess("downloadBackup")',
                        ),
                        'restore'  => array(
                            'url'     => 'Yii::app()->createUrl("/backup/backup/restore", array( "file" => $data["basename"] ))',
                            'icon'    => 'fa fa-magic',
                            'visible' => 'Yii::app()->user->checkAccess("restoreBackup")',
                        ),
                        'delete'   => array(
                            'url'     => 'Yii::app()->createUrl("/backup/backup/delete", array( "file" => $data["basename"] ))',
                            'visible' => 'Yii::app()->user->checkAccess("deleteBackup")',
                        ),
                    ),
                    'htmlOptions' => array(
                        'nowrap' => 'nowrap',
                    ),
                    'visible'     =>
                    Yii::app()->user->checkAccess("downloadBackup") || Yii::app()->user->checkAccess("restoreBackup") || Yii::app()->user->checkAccess("deleteBackup"),
                ),
            ),
            )
        );
        $this->endWidget();
        ?>
    </div>
</div>