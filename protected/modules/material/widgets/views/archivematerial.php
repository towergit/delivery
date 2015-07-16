<h3><?php echo Yii::t('main', 'Архив статей блога'); ?></h3>
<div class="line-category"></div>
<nav>
    <ul class="menu-category">
        <li>Архив пуст</li>
        <?php /* foreach($models as $model): ?>
            <li>
                <a href="<?php echo Yii::app()->createUrl('/default/blog_archive', array( 'year' => $model->publish_date )); ?>">
                    <?php echo Yii::t('main', 'Архив за'); ?> <?php echo $model->publish_date; ?>
                </a>
            </li>
        <?php endforeach; */ ?>
    </ul>
</nav>