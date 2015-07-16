
<?php
// название страницы
$this->pageTitle = Yii::t('main', Yii::t('main', 'Проекты'));

// хлебные крошки
$this->breadcrumbs = array(
    Yii::t('main', 'Проекты'),
);
$this->showHeadering = false;
?>
<form method="POST">
    <input type="hidden" name="sum" id="sum" value="1000">
    <div class="container block-3 block-o3 selecteble">
        <div class="row">
            <?php foreach ($objects as $data): ?>

                <div class="col-md-4 selecteble-object">
                    <h4><?php echo $data->title; ?></h4>
                    <div class="grid">
                        <figure class="effect-julia">
                            <?php
                            $files = UploadFile::findAllFiles('object', $data->id);

                            if ($files):
                                ?>

                                <?php
                                foreach ($files as $file):
                                    ?>
                                    <div class="item" style="margin: 0;overflow: hidden;">
                                        <img style="height: 100%;" src="<?php echo $data->imagesUpload->getThumbFileUrl($file->file); ?>" alt=""/>
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
                        <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $data->percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $data->percent; ?>%;">
                            <div class="complete"><?php echo $data->percent; ?>%</div>
                        </div>
                    </div>
                    <p class="collected">
                        <?php echo Yii::t('main', 'Уже собрано'); ?>: $<?php echo General::numberFormat($data->totalSumCollected); ?>
                        <span class="stavka">/ $<?php echo General::numberFormat($data->totalSum); ?></span>
                    </p>
                    <p>Максимум <?php echo $data->totalSum - $data->totalSumCollected; ?></p>
                    <br>
                    <div class="range-pice price-selector<?php echo $data->id; ?>" style="display: none;">
                        
                        <!-- если сумма платежа  больше, то указать лимит-->
                        <?php if(1000 > $data->totalSum - $data->totalSumCollected):?>
                        <div class="progress">
                                
                        </div>
                        <?php endif;?>
                        
                        <input type="hidden" name="slider[<?php echo $data->id; ?>]" id="slider<?php echo $data->id; ?>_value" value="" />
                        <div id="slider<?php echo $data->id; ?>" data-max="<?php echo $data->totalSum - $data->totalSumCollected; ?>" data-maxrange="" data-start="100000" class="slider"></div>

                        <a class="button button-plus slide-plus" data-slider="#slider<?php echo $data->id; ?>" href="javascript:void(0)">+</a><a href="javascript:void(0)" class="button button-plus slide-minus" data-slider="#slider<?php echo $data->id; ?>">-</a>
                    </div>
                    <!--<div class="help">
                        <a  href="<?php echo Yii::app()->createUrl('/default/item_project', array('alias' => $data->alias)); ?>">
                    <?php echo Yii::t('main', 'Детали проекта'); ?>
                        </a>
                        <a  href="<?php echo Yii::app()->createUrl('/default/basket', array('id' => $data->id, 'auth' => 'anonim')); ?>">
                    <?php echo Yii::t('main', 'Оказать помощь'); ?>
                        </a>
                    </div>-->

                    <input type="checkbox" class="object_selector" data-slider="price-selector<?php echo $data->id; ?>" name="objects[]" value="<?php echo $data->id; ?>">
                </div>
            <?php endforeach; ?>

            <?php
            Yii::app()->clientScript->registerScript(uniqid(), "
        $(document).ready(function() {

    $('.slider').slider({
        min: 0,
        max: 5000,
        step:1,
        create: function( event, ui ) {
        console.log('init')

    $(this).find('.ui-slider-handle').append('<div class=\'complete complete-center\'>0</div>');

    },
    slide: function (ev, ui) {

    var total = ui.value;
    var other_sum = 0;
        
    

        $('.slider').not(this).each(function () {
            total += $(this).slider('value');
            other_sum += $(this).slider('value');
        })
        if (total > 1000) { //сумма платежа
            
             $(this).slider('value',1000 - other_sum);
             $(this).find('.complete').html(1000 - other_sum);
            return false;
        }
        
             console.log(ui.value);
        
$(this).find('.complete').html(ui.value);
    },
    change: function(ev, ui) {
        
        var total = ui.value;
        var input = $(this).attr('id')+ '_value';
$(this).find('.complete').html(ui.value);
        
        if(total > $(this).data('max')) {
            $(this).slider('value',$(this).data('max'));
               
           return false;
         }else {
                 $('.slider').not(this).each(function () {
            total += $(this).slider('value');
        })
            }
        
       var input = $(this).attr('id')+ '_value';

        $('#'+input).val(ui.value);
        $('#total').text(1000 - total);
    }
});

$('.slide-plus').on('click',function() {
    
    var slider = $($(this).data('slider'));
    var value = slider.slider(\"value\");
    
    if($('#total').text() > 0) {
        slider.slider('value',value + 1);
    }
    
})

var interval;
$('.slide-minus').on('mousedown',function(e) {
    interval = setInterval(function() {
      console.log('hold');
    },100); // 500ms between each frame
});
$('.slide-minus').on('mouseup',function(e) {
    clearInterval(interval);
});


$('.slide-minus').on('click',function() {

        var slider = $($(this).data('slider'));
        var value = slider.slider(\"value\");

     slider.slider('value',value - 1);

})

var Slider = {
    Show:function(target) {
    
        $('.'+target+' input').val('');
        $('.'+target+' .slider').slider('value',0);
        $('.'+target).show();
        
    },
    Hide: function(target) {
    
        $('.'+target+' input').val('');
        $('.'+target+' .slider').slider('value',0);
        $('.'+target).hide();
        
    }
}

$('.object_selector').click(function(e) {

    var checkbox = $(this);
    if (checkbox.is(':checked')) {

        Slider.Show(checkbox.data('slider'));
    
    } else {
    
        Slider.Hide(checkbox.data('slider'));

    }
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

            Всего сумма - 1000

            На распределении <span id="total">1000</span> <input type="submit" />
        </div>
    </div>

</form>