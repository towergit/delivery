<div class="lang">
    <?php foreach($langs as $lang): ?>
        <a href="<?php echo Yii::app()->createUrl('language/selector/index', array( 'name' => $lang->url, 'url' => $cleanUrl )); ?>" <?php echo ($lang->url == $currentLanguage) ? 'class="active"' : ''; ?>>
            <?php echo $lang->url; ?>
        </a>
    <?php endforeach; ?>
</div>