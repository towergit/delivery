<?php
// название страницы
$this->pageTitle = Yii::t('module', 'Модули');

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('module', 'Модули') => array( 'index' ),
);
?>

<div class="row">
    <div class="col-sm-12">
        <?php
        $box = $this->beginWidget('booster.widgets.TbPanel',
            array(
            'title'       => CHtml::encode($this->pageTitle),
            'padContent'  => false,
            'headerIcon'  => Yii::app()->getModule('module')->icon,
            'htmlOptions' => array(
                'class' => 'panel-table'
            ),
        ));
        $this->widget('booster.widgets.TbExtendedGridView',
            array(
            'type'            => 'striped',
            'responsiveTable' => true,
            'dataProvider'    => $model->search(),
            'template'        => "{items}\n{pager}",
            'columns'         => array(
                array(
                    'header' => Yii::t('module', 'Название'),
                    'value'  => 'Yii::app()->getModule($data->name)->name',
                ),
                array(
                    'header' => Yii::t('module', 'Описание'),
                    'value'  => 'Yii::app()->getModule($data->name)->description',
                ),
                array(
                    'header'      => Yii::t('module', 'URL сайта'),
                    'type'        => 'raw',
                    'value'       => 'String::createUrlLink(Yii::app()->getModule($data->name)->url)',
                    'htmlOptions' => array(
                        'style' => 'width: 150px',
                    ),
                ),
                array(
                    'header'      => Yii::t('module', 'Автор'),
                    'value'       => 'Yii::app()->getModule($data->name)->author',
                    'htmlOptions' => array(
                        'style' => 'width: 150px',
                    ),
                ),
                array(
                    'header'      => Yii::t('module', 'Версия'),
                    'type'        => 'raw',
                    'value'       => '$data->version',
                    'htmlOptions' => array(
                        'style' => 'width: 100px;',
                    ),
                ),
            ),
        ));
        $this->endWidget();
        ?>
    </div>
</div>