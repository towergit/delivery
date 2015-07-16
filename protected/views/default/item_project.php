<?php
// название страницы
$this->pageTitle = $model->category->title . ' проекты';

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('main', 'Проекты') => $this->createUrl('/default/projects'),
    $model->category->title => $this->createUrl('/default/projects_category', array('alias' => $model->category->alias)),
    $model->title,
);
$this->showHeadering = false;
?>






<div class="container page-object">
    <div class="row">
        <div class="col-md-9 col-sm-9 object-help">
            <div class="row">
                <div class="col-md-9 col-sm-9">
                    <h1> <?php echo $model->title; ?></h1>

                </div>
                <div class="col-md-3 col-sm-3">
                    <p class="page-data pull-right"><?php echo Date::format($model->publish_date, 'dd MMM, y'); ?></p>

                </div>   
            </div>

            <div id="owl-demo" >

                <?php
                $files = UploadFile::findAllFiles('object', $model->id);

                if ($files):
                    foreach ($files as $file):
                        ?>
                        <div class="item">
                            <a href="<?php echo $model->imagesUpload->getFileUrl($file->file); ?>">
                                <img src="<?php echo $model->imagesUpload->getFileUrl($file->file); ?>" alt=""/>

                            </a>                        
                        </div>
                        <?php
                    endforeach;
                else:
                    ?>
                    <img src="<?php echo Yii::app()->controller->assetsBase; ?>/images/noimage_big.jpg" alt="" />
                <?php endif; ?>
            </div> 

            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $model->percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $model->percent; ?>%;">
                    <div class="complete"><?php echo $model->percent; ?>%</div>
                </div>
            </div>



            <div class="soyurano">
                <p class="collected pull-left  fs-15-em">
                    <?php echo Yii::t('main', 'Уже собрано'); ?>: $<?php echo General::numberFormat($model->totalSumCollected); ?> 
                    <span class="stavka">/ $<?php echo General::numberFormat($model->totalSum); ?></span>
                </p>

                <?php if ($model->percent != 100): ?>
                    <a class="object-help-link pull-right" href="<?php echo $this->createUrl('/default/basket', array('id' => $model->id)); ?>">
                        <?php echo Yii::t('main', 'Оказать помощь'); ?>
                    </a>
                <?php else: ?>
                    <a class="object-help-link pull-right collected-help" href="#" data-toggle="modal" data-target="#colected">
                        <?php echo Yii::t('main', 'Оказать помощь'); ?>
                    </a>
                <?php endif; ?>
                <div class="clear"></div>
            </div>
            <div class="small-page-text">
                <?php echo $model->text; ?>
            </div>	
            <?php if ($model->percent != 100): ?>
                <a class="object-help-link pull-right" href="<?php echo $this->createUrl('/default/basket', array('id' => $model->id)); ?>">
                    <?php echo Yii::t('main', 'Оказать помощь'); ?>
                </a>
            <?php else: ?>
                <a class="object-help-link pull-right collected-help" href="#" data-toggle="modal" data-target="#colected">
                    <?php echo Yii::t('main', 'Оказать помощь'); ?>
                </a>
            <?php endif; ?>	
            <br>
            <br>

            <script type="text/javascript">(function () {
                    if (window.pluso)
                        if (typeof window.pluso.start == "function")
                            return;
                    if (window.ifpluso == undefined) {
                        window.ifpluso = 1;
                        var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                        s.type = 'text/javascript';
                        s.charset = 'UTF-8';
                        s.async = true;
                        s.src = ('https:' == window.location.protocol ? 'https' : 'http') + '://share.pluso.ru/pluso-like.js';
                        var h = d[g]('body')[0];
                        h.appendChild(s);
                    }
                })();</script>
            <div class="pluso" data-background="transparent" data-options="medium,square,line,horizontal,counter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,google"></div>
        </div>
        <div class="col-md-3 col-sm-3 navigation">
            <?php $this->widget('application.modules.object.widgets.CategoriesObjectsWidget'); ?>	
        </div>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScript(uniqid(), "
        

        $(document).ready(function() {
        
  $(\"#owl-demo\").owlCarousel({
 
      autoPlay: 3000, //Set AutoPlay to 3 seconds
      navigation : true, // Show next and prev buttons
      slideSpeed : 300,
      pagination:false,
      paginationSpeed : 400,
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

<style> 
    #owl-demo .item{
        margin: 3px;
        overflow: hidden;

    }
    #owl-demo .item img{
        display: block;
        width: 100%;

    }
</style>