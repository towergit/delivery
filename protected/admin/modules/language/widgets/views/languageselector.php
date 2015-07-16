<div class="header-inner">
    <div class="dropdown">
        <button type="button" data-toggle="dropdown">
            <?php echo $currentLanguage; ?>
        </button>
        <ul class="dropdown-menu">
            <?php foreach($langs as $lang): ?>
                <li <?php echo ($lang->url == $currentLanguage) ? 'class="active"' : ''; ?>>
                    <a href="<?php echo Yii::app()->createUrl('language/selector/index', array(
                        'id'  => $lang->id,
                        'url' => $cleanUrl,
                    ));
                    ?>">
                    <?php echo $lang->title; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>