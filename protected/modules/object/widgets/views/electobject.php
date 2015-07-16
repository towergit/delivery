<div class="col-md-12">
    <div id="owl-demo" class="owl-carousel post">
        <?php foreach ($models as $model): ?>
            <div class="item">
                <h4><?php echo $model->title; ?></h4>
                <div class="grid">
                    <figure class="effect-julia">
                        <?php
                        $files = UploadFile::findAllFiles('object', $model->id);

                        if ($files):
                            ?>

                            <?php
                            foreach ($files as $file):
                                ?>
                                <div class="item" style="margin: 0;overflow: hidden;">
                                    <img style="height: 100%;" src="<?php echo $model->imagesUpload->getThumbFileUrl($file->file); ?>" alt=""/>
                                </div>
                                <?php
                            endforeach;
                        else:
                            ?>
                            <img style="height: 100%;width: auto;" src="<?php echo Yii::app()->controller->assetsBase; ?>/images/noimage_big.jpg" alt="" />
                        <?php endif; ?>

                    </figure>
                </div>	
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $model->percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $model->percent; ?>%;">
                        <div class="complete"><?php echo $model->percent; ?>%</div>
                    </div>
                </div>
                <p class="collected">
                    <?php echo Yii::t('main', 'Уже собрано'); ?>: $<?php echo General::numberFormat($model->totalSumCollected); ?>
                    <span class="stavka">/ $<?php echo General::numberFormat($model->totalSum); ?></span>
                </p>
                <?php if($model->percent != 100):?>
                <div class="help">
                    <a class="" href="<?php echo Yii::app()->createUrl('/default/item_project', array('alias' => $model->alias)); ?>">
                        <?php echo Yii::t('main', 'Детали проекта'); ?>
                    </a>

                    <a class="link" href="<?php echo Yii::app()->createUrl('/default/basket', array('id' => $model->id, 'auth' => 'anonim')); ?>">
                        <?php echo Yii::t('main', 'Оказать помощь'); ?>
                    </a>
                </div>
                <?php else:?>
                <div class="help collected-help">
                    <a class="" href="<?php echo Yii::app()->createUrl('/default/item_project', array('alias' => $model->alias)); ?>">
                        <?php echo Yii::t('main', 'Детали проекта'); ?>
                    </a>

                    <a class="link" href="#"  data-toggle="modal" data-target="#colected">
                        <?php echo Yii::t('main', 'Оказать помощь'); ?>
                    </a>
                </div>                
                <?php endif;?>
            </div> 
        <?php endforeach; ?>
    </div>  
</div>

<div align="center" class="col-md-12">
    <div class="detailed">
        <a class="" href="/projects"> Посмотреть все</a>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScript(uniqid(), "
        $(document).ready(function() {
        
  $(\".effect-julia\").owlCarousel({
 
      autoPlay: false, //Set AutoPlay to 3 seconds
      navigation : true, // Show next and prev buttons
      slideSpeed : 300,
    pagination:false,

      navigationText: ['<','>'],
      singleItem:true
 
  });

            $('.progress-bar').each(function() {
                if ($(this).attr('aria-valuenow') <= 10)
                    $(this).children('div').addClass('complete-left');
                else if ($(this).attr('aria-valuenow') >= 90)
                    $(this).children('div').addClass('complete-right');
                else
                    $(this).children('div').addClass('complete-center');
            });
        });
    ", CClientScript::POS_END);
?>