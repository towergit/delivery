<?php
// название страницы
$this->pageTitle = Yii::t('main', Yii::t('main', 'Блог'));

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('main', 'Блог'),
);

$this->showHeadering = false;
?>

<div class="container news-page">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView'     => '_blog',
                    'emptyText'    => Yii::t('main', 'На данный момент ни одной записи в блоге'),
                    'summaryText'  => false,
                    'template'     => '{items} {pager}',
                    'pager'        => array(
                        'maxButtonCount'       => 5,
                        'header'               => '',
                        'prevPageLabel'        => Yii::t('main', 'Пред'),
                        'nextPageLabel'        => Yii::t('main', 'След'),
                        'firstPageCssClass'    => 'hidden',
                        'lastPageCssClass'     => 'hidden',
                        'htmlOptions'          => array( 'class' => 'pagination' ),
                    ),
                ));
                ?>
            </div>	
        </div>	
        <div class="col-md-3 col-sm-3 navigation">
            <?php $this->widget('application.modules.material.widgets.CategoryMaterialWidget'); ?>
            <?php $this->widget('application.modules.material.widgets.ArchiveMaterialWidget'); ?>
        </div>
    </div>
</div>