<?php if (!$models): ?>
    <div class="media-empty">
        <?php echo Yii::t('main', 'Будьте первым, кто оставит комментарий!') ?>
    </div>
<?php else: ?>
    <?php foreach ($models as $model): ?>
        <div class="media">
            <div class="media-body">
                <h4 class="media-heading pull-left comment-autor"><?php echo $model->name; ?></h4>
                <div class="clear"></div>
                <p class="comment-text"><?php echo $model->text; ?></p>
                <div class="clear"></div>
                <div class="date-coments pull-left comment-date">
                    <?php echo Date::format($model->create_date, 'dd MMM y'); ?> 
                    <?php echo Yii::t('main', 'в') ?>
                    <?php echo Date::format($model->create_date, 'HH:mm'); ?> 
                </div>
            </div>
        </div>
<hr style="width: 30%;">
    <?php endforeach; ?>
<?php endif; ?>
