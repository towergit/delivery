<?php
// название страницы
$this->pageTitle = Yii::t('main', Yii::t('main', 'Проекты'));

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('main', 'Проекты'),
);
$this->showHeadering = false;

?>

<div class="container block-3 block-o3">
    <div class="row">
        <h2><?php echo Yii::t('main', 'Ваша даже небольшая помощь служит поддержкой для многих людей!'); ?></h2>
        
        <?php  $this->widget('application.modules.object.widgets.FilterObjectsWidget', array( 'alias' => $alias )); ?>
        <?php
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'itemView'     => '_projects',
            'emptyText'    => Yii::t('main', 'На данный момент ни одного проекта'),
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