<div class="col-md-12">
    
    <?php                 
    
    $imagePauth = '/uploads/material/_full/';

    $file = UploadFile::model()->findByAttributes(array('owner_name' => 'material','owner_id' => $data->id))->file;    

    if($file):
    ?>
     
    <img src="<?php echo $imagePauth.$file; ?>" alt="" />
        
    <?php else:?>
    
    <img src="<?php echo $this->assetsBase; ?>/images/noimage_big.jpg" alt="" />   
    
    <?php endif;?>
    <div class="content-news">
        <h1><?php echo $data->title; ?></h1>
        <h5>
            <?php echo Yii::t('main', 'Категория'); ?>: 
            <a href="<?php echo $this->createUrl('/default/blog_category', array( 'alias' => $data->category->alias )); ?>">
                <?php echo $data->category->title; ?>
            </a> / 
            <?php echo $data->countComments(); ?> <?php echo Yii::t('main', 'комментарий|комментария|комментариев', array($data->countComments())); ?>
        </h5>
        <p><?php echo String::wordLimiter($data->text, '35'); ?></p>
        <div class="news-detal">
            <a href="<?php echo $this->createUrl('/default/item_blog', array( 'alias' => $data->alias )); ?>">
                <?php echo Yii::t('main', 'Детальнее'); ?>
            </a>
        </div>
    </div>	
    <div class="line-news"></div>
</div>