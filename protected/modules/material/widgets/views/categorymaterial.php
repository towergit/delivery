<h3><?php echo Yii::t('main', 'Категории'); ?></h3>
<div class="line-category"></div>
<nav>
    <ul class="menu-category">
        <li>
            <a <?php if (!isset($_GET['alias'])): ?>
                style="font-weight: bold;" 
                <?php endif; ?>
                href="<?php echo Yii::app()->createUrl('/blog'); ?>">Все</a>
        </li>
        <?php foreach ($models as $model): ?>
            <li>
                <a 
                <?php if (isset($_GET['alias'])): ?>
                    <?php if ($model->alias == $_GET['alias']): ?> 
                            style="font-weight: bold;" 
                        <?php endif; ?> 
                    <?php endif; ?>
                    href="<?php echo Yii::app()->createUrl('/default/blog_category', array('alias' => $model->alias)); ?>">
                        <?php echo $model->title; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
