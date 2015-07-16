<div class="filter">
    <p>
        <?php foreach ($params as $key => $value): ?>
            <?php
            
            $icon = null;
            
            if ($alias == '' && $key == 'all')
                $class = 'active';
            else {
                if ($key == $alias)
                    $class = 'active';
                else
                    $class = '';
            }   
            $category = ObjectCategory::model()->findByAttributes(array('alias' => $key));
            if($category)
                $icon = UploadFile::getFile('сategory', $category->id);
            
            ?>

            <?php if ($icon): ?><img style="width: 26px;" src="/uploads/сategory/<?php echo $icon->file; ?>">  <?php endif ?> <a style="margin-left: 0;" href="<?php echo Yii::app()->createUrl('/default/projects_category', array('alias' => $key)); ?>" class="<?php echo $class; ?>">
            

    <?php echo $value; ?>
            </a>
            <?php endforeach; ?>
    </p>
</div>