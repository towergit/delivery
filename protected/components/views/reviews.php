<div id="owl-demo-reviews" class="owl-carousel">
    <?php foreach($models as $model): ?>
        <div class="item">
            <p><?php echo $model->text; ?></p>
            <h3><?php echo $model->name; ?></h3>
            
            <?php if ($model->post): ?>
                <h5>
                    (<?php echo $model->post; ?><?php echo isset($model->company) ? ' ' . Yii::t('main', 'в') . ' ' . $model->company : ''; ?>)
                </h5>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<?php
Yii::app()->clientScript->registerScript(uniqid(),
    "
        $(document).ready(function() {
            $('#owl-demo-reviews').owlCarousel({
                autoPlay: 6000,
                slideSpeed: 300,
                paginationSpeed: 400,
                singleItem: true,
            });
        });
    ", CClientScript::POS_END);
?>