<h3><?php echo Yii::t('main', 'Категории'); ?></h3>
<div class="line-category"></div>
<nav>
    <ul class="menu-category">
        <li>
            <a href="/projects">
                Все 
            </a>
        </li>
        <?php foreach($params as $key => $value): ?>
            <li>
                <a href="<?php echo Yii::app()->createUrl('/default/projects_category', array( 'alias' => $key )); ?>" <?php if ($key==$link->alias): ?> style="font-weight: bold;"<?php endif; ?>>
                    <?php echo $value; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>