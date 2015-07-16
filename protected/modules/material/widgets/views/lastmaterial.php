<div id="owl-demo-news" class="owl-carousel">
    <?php
    for ($i = 0; $i < count($materials); $i++):
        //$this->controller->assetsBase;

        $image = null;
        $imagesModel = UploadFile::model()->findByAttributes(array('owner_name' => 'material', 'owner_id' => $materials[$i]->id));
        if ($imagesModel)
            $image = '/uploads/material/_thumbs/' . $imagesModel->file;
        ?>
        <div class="item">
            <?php if (isset($materials[$i]) && is_object($materials[$i])): ?>
                <div class="row">
                    <div class="col-md-5 col-sm-5">
                        <div class="grid">
                            <figure class="">                                
                                <?php if ($image): ?>
                                    <img src="<?php echo $image; ?>" alt="" />
                                <?php else: ?>
                                    <img src="<?php echo $this->controller->assetsBase; ?>/images/noimage_middle.jpg" alt="" />
                                <?php endif; ?>
                            </figure>
                        </div>			
                    </div>
                    <div class="col-md-7 col-sm-7">
                        <h3> <?php echo String::wordLimiter($materials[$i]->title, 3); ?></h3>
                        <div >
                            <div class="date-news pull-left">
                                <i class="fa fa-calendar"></i> 
                                <?php echo Date::format($materials[$i]->publish_date, 'dd MMM y'); ?>
                            </div> 
                            <div class="category-news">
                                <i class="fa fa-tag"></i> 
                                <?php echo Yii::t('main', 'Категория'); ?>: 
                                <a href="<?php echo Yii::app()->createUrl('/default/blog_category', array('alias' => $materials[$i]->category->alias)); ?>">
                                    <?php echo $materials[$i]->category->title; ?>
                                </a>
                            </div>
                            <p><?php echo String::wordLimiter($materials[$i]->description ? $materials[$i]->description : $materials[$i]->text, 7); ?></p> 
                            <div class="detailed">
                                <a href="<?php echo Yii::app()->createUrl('/default/item_blog', array('alias' => $materials[$i]->alias)); ?>">
                                    <?php echo Yii::t('main', 'Детальнее'); ?>
                                </a>
                            </div>    
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            $i++;
            if (isset($materials[$i]) && is_object($materials[$i])):

                $image = '/uploads/material/_thumbs/' . UploadFile::model()->findByAttributes(array('owner_name' => 'material', 'owner_id' => $materials[$i]->id))->file;
                ?>
                <div class="row">
                    <div class="col-md-5 col-sm-5">
                        <div class="grid">
                            <figure class="">

        <?php if ($image): ?>
                                    <img src="<?php echo $image; ?>" alt="" />

        <?php else: ?>
                                    <img src="<?php echo $this->controller->assetsBase; ?>/images/noimage_middle.jpg" alt="" />
                                <?php endif; ?>
                            </figure>
                        </div>			
                    </div>
                    <div class="col-md-7 col-sm-7">
                        <h3><?php echo String::wordLimiter($materials[$i]->title, 3); ?></h3>
                        <div >
                            <div class="date-news pull-left">
                                <i class="fa fa-calendar"></i> 
        <?php echo Date::format($materials[$i]->publish_date, 'dd MMM y'); ?>
                            </div> 
                            <div class="category-news">
                                <i class="fa fa-tag"></i> 
        <?php echo Yii::t('main', 'Категория'); ?>: 
                                <a href="<?php echo Yii::app()->createUrl('/default/blog_category', array('alias' => $materials[$i]->category->alias)); ?>">
                                <?php echo $materials[$i]->category->title; ?>
                                </a>
                            </div>
                            <p><?php echo String::wordLimiter($materials[$i]->description ? $materials[$i]->description : $materials[$i]->text, 7); ?></p> 
                            <div class="detailed">
                                <a href="<?php echo Yii::app()->createUrl('/default/item_blog', array('alias' => $materials[$i]->alias)); ?>">
        <?php echo Yii::t('main', 'Детальнее'); ?>
                                </a>
                            </div>    
                        </div>
                    </div>
                </div>
    <?php endif; ?>
        </div>
        <?php endfor; ?>
</div>