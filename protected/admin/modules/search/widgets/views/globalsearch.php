<div class="global-search close">
    <div class="content">
        <div class="container-fluid">
            <img src="<?php echo $this->controller->getAssetsBase(); ?>/images/logo.png" alt="" />
            <a href="javascript:;" class="close-search pull-right">
                <i class="fa fa-times"></i>
            </a>
        </div>
        <div class="container-fluid">
            <?php echo CHtml::beginForm(); ?>
            <?php
            echo CHtml::activeTextField($form, 'string',
                array(
                'id'          => 'input-search',
                'placeholder' => Yii::t('search', 'Найти'),
            ));
            ?>
            <br />
            <p><?php echo Yii::t('search', 'Пожалуйста введите для поиска'); ?></p>
            <?php echo CHtml::endForm(); ?>
        </div>
        <div class="container-fluid">
            <span>
                <strong><?php echo Yii::t('search', 'предложение'); ?>: </strong>
            </span>
            <span class="search-suggestions"></span>
            <br />
            <div class="search-result">

            </div>
        </div>
    </div>
</div>

<?php
$link = Yii::app()->createUrl('/search/search/index');
Yii::app()->getClientScript()->registerCoreScript('jquery');
Yii::app()->getClientScript()->registerScript(md5($this->id),
    "
    var search = $('.global-search'),
            input = search.find('#input-search'),
            searchResult = search.find('.search-result');

    input.keyup(function() {
            search.find('.search-suggestions').text($(this).val());
            $.ajax({
                    url: '{$link}',
                    type: 'POST',
                    data: 'string=' + $(this).val(),
                    success: function(data) {
                            searchResult.html(data);
                    }
            });
    });
", CClientScript::POS_END);
?>